<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Mailer\MailerAwareTrait;
use Cake\Core\Configure;
use Cake\Validation\Validator;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\Query;
/**
 * Subscriptions Controller
 *
 * @property \App\Model\Table\SubscriptionsTable $Subscriptions
 * @method \App\Model\Entity\Subscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscriptionsController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);    
        $this->Authentication->allowUnauthenticated(['viewfree']);
    }
   

    public function initialize(): void
    {
   
        parent::initialize();
     //   $this->viewBuilder()->setLayout("admin");
     //   $this->loadComponent('Peoplescontacts');
          //$this->loadComponent('Paginator');
          $this->loadComponent('Usr');
          $this->loadComponent('Subscr');
          $this->loadComponent('Rlevent');
          $this->loadComponent('Peopl');
          $this->loadComponent('Staff');    
          $this->loadComponent('Singlesubscription');
          $this->loadModel('Singlesubscriptions');
    }


    public function index()
    {
        
        $userid = $this->request
        ->getAttribute('identity')
        ->getIdentifier();

        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

                $this->paginate = [
                    'contain' => ['Rolevents', 'Users','Singlesubscriptions'],
                ];
                $subscriptions = $this->paginate($this->Subscriptions);

                $this->set(compact('subscriptions'));

         
        } else {

                $this->paginate = [
                    'contain' => ['Rolevents', 'Users','Singlesubscriptions'],                         
                    'conditions' => ['user_id ='=>$userid],       
                    'order' => ['Subscriptions.dateissue' => 'desc']
                ];
                $subscriptions = $this->paginate($this->Subscriptions);
        
                $this->set(compact('subscriptions'));

            //return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Subscription id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        $profileid = $this->request
        ->getAttribute('identity')        
        ->get('profile_id'); 

        $userid = $this->request
        ->getAttribute('identity')        
        ->get('id'); 
        
        $useractive = $this->request
        ->getAttribute('identity')        
        ->get('active'); 

        $confirmed = $this->request
        ->getAttribute('identity')
        ->get('confirmed');
        
        $ctrl = Configure::read('ctrl._subscriptions');
        $act = Configure::read('act._view');
        $ok = Configure::read('answ.alw');
        
       

        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);

      

         
        if (($allprof->value == $ok) && ($useractive == true) && ($confirmed == true)) {



                        if (($roleid != 3) && ($roleid != 6)) {
                    
                                $subscription = $this->Subscriptions->get($id, [
                                    'contain' => [
                                                'Rolevents', 
                                                'Users', 
                                                'Subscriptionsdocs', 
                                                'Subscriptionsflows'],
                                ]);

                                $this->set(compact('subscription'));
                        } else {
                      

                            $subscription = $this->Subscriptions->get($id, [
                                'contain' => [
                                   'Rolevents', 
                                     'Users', 
                                    'Subscriptionsdocs', 
                                    'Subscriptionsflows'],
                                'conditions' => ['Subscriptions.user_id ='=>$userid],       
                                'order' => ['Subscriptions.dateissue' => 'desc'] 
                            ]);

                            $this->set(compact('subscription'));
                        }

                    } else {
                
                        return $this->redirect(['controller'=>'Users','action' => 'refuse']);
                        
        }        
    }

    public function viewfree($id = null)
    {
        
                    
                                $subscription = $this->Subscriptions->get($id, [
                                    'contain' => [
                                                'Rolevents', 
                                                'Users', 
                                                'Subscriptionsdocs', 
                                                'Subscriptionsflows'],
                                ]);

                                $this->set(compact('subscription'));
                    

                        
          
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
                $dataatual = date('Y-m-d H:i:s');
                $subscription = $this->Subscriptions->newEmptyEntity();
                if ($this->request->is('post')) {
                    $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
                    if ($this->Subscriptions->save($subscription)) {
                        $this->Flash->success(__('The subscription has been saved.'));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
                }
                $rolevents = $this->Subscriptions->Rolevents->find('list',array(
                                                                            'conditions'=>array(
                                                                                'Rolevents.activeflag is '=>true,
                                                                                'Rolevents.subscriptionrequired is '=>true,
                                                                                'Rolevents.subscexpirationdate >= '=>$dataatual,
                                                                                )
                                                                        ));
                $subscriptionstypes = $this->Subscriptions->Subscriptionstypes->find('list', ['limit' => 200]);
                $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
                $this->set(compact('subscription', 'rolevents', 'users','subscriptionstypes'));

      
    }

    use MailerAwareTrait;

    public function addid($id = null)
    {
        $subscription = $this->Subscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
            $subscription->rolevent_id = $id;
            $subscription->subscriptionstype_id = 2;
            $hoje = date("Y-m-d H:i:s");
            $subscription->dateissue = $hoje;
            //identificando o usuário logado
            $subscription->user_id = $this->request->getAttribute('identity')->getIdentifier();
            $subscription->statusflag = 'ABERTA';
            $subscription->activeflag = true;
            $peo = $this->Peopl->findpeoplebyuserid($subscription->user_id);    
            $usr = $this->Usr->finduserbyId($subscription->user_id);          
            $subscription->mobile = $usr->mobile; 
            $subscription->people_id = $peo;             
            $originid = $this->Peopl->findPeopleOriginidByUserId($subscription->user_id);
            $subscription->originid = $originid;  
            
                       
            

           if ($this->Subscriptions->save($subscription)) {

                if ($user = $this->Usr->finduserbyid($subscription->user_id))          
                {            
                          $userarray = array(
                              "usrname" => $user->name,
                              "usremail" => $user->email,
                              "usrid" => $user->id,  
                          );

                          
      
                          if(!empty($userarray['usremail'])){                                
                                
                                $subsarray = array(
                                    "subscdate" => $subscription->date,
                                    "subscid" => $subscription->id                             
                                );                    
                               
                                
                               
                                if ($rol = $this->Rlevent->findroleventsbyid($subscription->rolevent_id))  {

                                    $evearray = array(
                                        "evedescription" => $rol->description,
                                        "eveid" => $rol->id,
                                        "evedatainicio"  => $rol->startdate,
                                        "evedatafim" => $rol->enddate,
                                        "evevalor" => $rol->price
                                    ); 

                                    $allarray = array(
                                        
                                        "msgusrid" => $userarray['usrid'],
                                        "msgname" => $userarray['usrname'],
                                        "msgemail" => $userarray['usremail'],
                                        "msgsubid" => $subsarray['subscid'],
                                        "msgsubdate" => $subsarray['subscdate'],
                                        "msgevedescription" => $evearray['evedescription'],
                                        "msgeveid" => $evearray['eveid'],
                                        "msgeveinicio" => $evearray['evedatainicio'],
                                        "msgevefim" => $evearray['evedatafim'],
                                        "msgeveprice" => $evearray['evevalor']
                                    );
                                  
                                    // Rotina de envio de email

                                    if (filter_var($allarray['msgemail'], FILTER_VALIDATE_EMAIL)) {
                                       
                                        $this->getMailer('Subscripti')->send('subscriptionconfirmation', [$allarray]);
                                        $this->Flash->success(__('Foi enviado uma mensagem no seu email com os detalhes de ABERTURA de sua PRE-INSCRICAO para o evento escolhido'));
                                    } 

                                } else {
                                    $this->Flash->success(__('Evento não localizado para envio de email.'));
                                }
                          } else {
                            $this->Flash->success(__('Endereço de email inválido para o usuário'));
                          }
                } else {
                    $this->Flash->success(__('Usuáro inválido.'));
                }




               $this->Flash->success(__('The subscription has been saved.'));

                //return $this->redirect(['action' => 'index']);
                return $this->redirect(['controller'=>'rolevents','action' => 'view', $id]);

            }
            $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
        }
        $rolevents = $this->Subscriptions->Rolevents->find('list', ['limit' => 200]);
        $subscriptionstypes = $this->Subscriptions->Subscriptionstypes->find('list', ['limit' => 200]);
        $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
        $this->set(compact('subscription', 'rolevents', 'users','subscriptionstypes'));
    }

    public function addsub($id = null)
    {

       

        $subscription = $this->Subscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
            $subscription->people_id = $id;
            $subscription->subscriptionstype_id = 2;
            $hoje = date("Y-m-d H:i:s");
            $subscription->dateissue = $hoje;
            //identificando o usuário logado
            $subscription->user_id = $this->request->getAttribute('identity')->getIdentifier();
            $subscription->statusflag = 'ABERTA';
            $subscription->activeflag = true;
            $usr = $this->Usr->finduserbyId($subscription->user_id);          
            $subscription->mobile = $usr->mobile; 
            //$peo = $this->Peopl->findpeoplebyuserid($subscription->user_id);          
            //$subscription->people_id = $peo;     
            //$originid = $this->Peopl->findPeopleOriginidByUserId($subscription->user_id);
            //$subscription->originid = $originid;  
                       
            

           if ($this->Subscriptions->save($subscription)) {

                if ($user = $this->Usr->finduserbyid($subscription->user_id))          
                {            
                          $userarray = array(
                              "usrname" => $user->name,
                              "usremail" => $user->email,
                              "usrid" => $user->id,  
                          );

                          
      
                          if(!empty($userarray['usremail'])){                                
                                
                                $subsarray = array(
                                    "subscdate" => $subscription->date,
                                    "subscid" => $subscription->id                             
                                );                    
                               
                                if ($peop = $this->Peopl->findallpeoplebypeopleid($id))    {
                                    $peoplearr = array(
                                        "peoname" => $peop->name,
                                        "peoid" => $peop->id,
                                    ); 
                                }        
                               
                                if ($rol = $this->Rlevent->findroleventsbyid($subscription->rolevent_id))  {

                                    $evearray = array(
                                        "evedescription" => $rol->description,
                                        "eveid" => $rol->id,
                                        "evedatainicio"  => $rol->startdate,
                                        "evedatafim" => $rol->enddate,
                                        "eveemail" => $rol->email,
                                        "evevalor" => $rol->price
                                    ); 

                                    $allarray = array(
                                        
                                        "msgusrid" => $peoplearr['peoid'],
                                        "msgname" => $peoplearr['peoname'],
                                       // "msgemail" => $userarray['usremail'],
                                        "msgemail" => $evearray['eveemail'],                                        
                                        "msgsubid" => $subsarray['subscid'],
                                        "msgsubdate" => $subsarray['subscdate'],
                                        "msgevedescription" => $evearray['evedescription'],
                                        "msgeveid" => $evearray['eveid'],
                                        "msgeveinicio" => $evearray['evedatainicio'],
                                        "msgevefim" => $evearray['evedatafim'],
                                        "msgeveprice" => $evearray['evevalor']
                                    );
                                  
                                    // Rotina de envio de email

                                    if (filter_var($allarray['msgemail'], FILTER_VALIDATE_EMAIL)) {
                                       
                                        $this->getMailer('Subscripti')->send('subscriptionconfirmation', [$allarray]);
                                        $this->Flash->success(__('Foi enviado uma mensagem no seu email com os detalhes de ABERTURA de sua PRE-INSCRICAO para o evento escolhido'));
                                    } 

                                } else {
                                    $this->Flash->success(__('Evento não localizado para envio de email.'));
                                }
                          } else {
                            $this->Flash->success(__('Endereço de email inválido para o usuário'));
                          }
                } else {
                    $this->Flash->success(__('Usuáro inválido.'));
                }




               $this->Flash->success(__('The subscription has been saved.'));

                //return $this->redirect(['action' => 'index']);
                return $this->redirect(['controller'=>'peoples','action' => 'viewsub', $id]);

            }
            $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
        }
        
        $peoples = $this->Subscriptions->Peoples->find('list',array('conditions'=>array('Peoples.id'=>$id),'order' => array('name' => 'asc')));
        $rolevents = $this->Subscriptions->Rolevents->find('list',array('conditions'=>array('Rolevents.activeflag'=> true,'Rolevents.subscriptionrequired'=> true),'order' => array('Rolevents.id' => 'desc')));
        $subscriptionstypes = $this->Subscriptions->Subscriptionstypes->find('list', ['limit' => 200]);
        $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
        $this->set(compact('subscription', 'rolevents', 'users','peoples','subscriptionstypes'));

     
    }

    public function addgene($id = null)
    {
        $subscription = $this->Subscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
            $subscription->rolevent_id = $id;
            $subscription->subscriptionstype_id = 2;
            $hoje = date("Y-m-d H:i:s");
            $subscription->dateissue = $hoje;
            //identificando o usuário logado
            $subscription->user_id = $this->request->getAttribute('identity')->getIdentifier();
            $subscription->statusflag = 'ABERTA';
            $subscription->activeflag = true;
            $peo = $this->Peopl->findpeoplebyuserid($subscription->user_id);          
            $subscription->people_id = $peo;     
            $originid = $this->Peopl->findPeopleOriginidByUserId($subscription->user_id);
            $subscription->originid = $originid;  
            $usr = $this->Usr->finduserbyId($subscription->user_id);          
            $subscription->mobile = $usr->mobile; 
                       
            

           if ($this->Subscriptions->save($subscription)) {

                if ($user = $this->Usr->finduserbyid($subscription->user_id))          
                {            
                          $userarray = array(
                              "usrname" => $user->name,
                              "usremail" => $user->email,
                              "usrid" => $user->id,  
                          );

                          
      
                          if(!empty($userarray['usremail'])){                                
                                
                                $subsarray = array(
                                    "subscdate" => $subscription->date,
                                    "subscid" => $subscription->id                             
                                );                    
                               
                                
                               
                                if ($rol = $this->Rlevent->findroleventsbyid($subscription->rolevent_id))  {

                                    $evearray = array(
                                        "evedescription" => $rol->description,
                                        "eveid" => $rol->id,
                                        "evedatainicio"  => $rol->startdate,
                                        "evedatafim" => $rol->enddate,
                                        "evevalor" => $rol->price
                                    ); 

                                    $allarray = array(
                                        
                                        "msgusrid" => $userarray['usrid'],
                                        "msgname" => $userarray['usrname'],
                                        "msgemail" => $userarray['usremail'],
                                        "msgsubid" => $subsarray['subscid'],
                                        "msgsubdate" => $subsarray['subscdate'],
                                        "msgevedescription" => $evearray['evedescription'],
                                        "msgeveid" => $evearray['eveid'],
                                        "msgeveinicio" => $evearray['evedatainicio'],
                                        "msgevefim" => $evearray['evedatafim'],
                                        "msgeveprice" => $evearray['evevalor']
                                    );
                                  
                                    // Rotina de envio de email

                                    if (filter_var($allarray['msgemail'], FILTER_VALIDATE_EMAIL)) {
                                       
                                        $this->getMailer('Subscripti')->send('subscriptionconfirmation', [$allarray]);
                                        $this->Flash->success(__('Foi enviado uma mensagem no seu email com os detalhes de ABERTURA de sua PRE-INSCRICAO para o evento escolhido'));
                                    } 

                                } else {
                                    $this->Flash->success(__('Evento não localizado para envio de email.'));
                                }
                          } else {
                            $this->Flash->success(__('Endereço de email inválido para o usuário'));
                          }
                } else {
                    $this->Flash->success(__('Usuáro inválido.'));
                }




               $this->Flash->success(__('The subscription has been saved.'));

                //return $this->redirect(['action' => 'index']);
                return $this->redirect(['controller'=>'rolevents','action' => 'view', $id]);

            }
            $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
        }
        $rolevents = $this->Subscriptions->Rolevents->find('list', ['limit' => 200]);
        $subscriptionstypes = $this->Subscriptions->Subscriptionstypes->find('list', ['limit' => 200]);
        $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
        $this->set(compact('subscription', 'rolevents', 'users','subscriptionstypes'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Subscription id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
  
          
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        $profileid = $this->request
        ->getAttribute('identity')        
        ->get('profile_id'); 

        $userid = $this->request
        ->getAttribute('identity')        
        ->get('id'); 
        
        $useractive = $this->request
        ->getAttribute('identity')        
        ->get('active'); 

        $confirmed = $this->request
        ->getAttribute('identity')
        ->get('confirmed');
        
        $ctrl = Configure::read('ctrl._subscriptions');
        $act = Configure::read('act._edit');
        $ok = Configure::read('answ.alw');
        
       

        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);
        //var_dump($allprof->value);
                 
        if (($allprof->value == $ok) && ($useractive == true) && ($confirmed == true)) {

                            $subscription = $this->Subscriptions->get($id, [
                                'contain' => [],
                            ]);
                            if ($this->request->is(['patch', 'post', 'put'])) {
                                $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
                                $roleventid = $subscription->rolevent_id; 
                                if ($this->Subscriptions->save($subscription)) {
                                    $this->Flash->success(__('The subscription has been saved.'));

                                    //return $this->redirect(['action' => 'index']);
                                    return $this->redirect(['controller'=>'rolevents','action' => 'view', $roleventid]);
                                }
                                $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
                            }
                            $rolevents = $this->Subscriptions->Rolevents->find('list', ['limit' => 200]);
                            $subscriptionstypes = $this->Subscriptions->Subscriptionstypes->find('list', ['limit' => 200]);
                            $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
                            $this->set(compact('subscription', 'rolevents', 'users','subscriptionstypes'));
                        
                        } else {
                            $this->Flash->error(__('Inscrição não pode ser alterada.'));
                            return $this->redirect(['action' => 'view', $id]);
                            
                        }               

    
    }

    public function confirmation($id = null)
    {
  
          
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        $profileid = $this->request
        ->getAttribute('identity')        
        ->get('profile_id'); 

        $userid = $this->request
        ->getAttribute('identity')        
        ->get('id'); 
        
        $useractive = $this->request
        ->getAttribute('identity')        
        ->get('active'); 

        $confirmed = $this->request
        ->getAttribute('identity')
        ->get('confirmed');
        
        $ctrl = Configure::read('ctrl._subscriptions');
        $act = Configure::read('act._conf');
        $ok = Configure::read('answ.alw');
        
       

        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);
        //var_dump($allprof);
        //exit;
                 
        if (($allprof->value == $ok) && ($useractive == true) && ($confirmed == true)) {

                            $subscription = $this->Subscriptions->get($id, [
                                'contain' => [],
                            ]);
                            if ($this->request->is(['patch', 'post', 'put'])) {
                                $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
                                //$roleventid = $subscription->rolevent_id; 
                                $subscription->mobile = $subscription->mobile;
                               // var_dump($subscription);    
                               // exit;
                                if ($this->Subscriptions->save($subscription)) {
                                    $this->Flash->success(__('The subscription has been saved.'));

                                    //return $this->redirect(['action' => 'index']);
                                    return $this->redirect(['action' => 'view', $id]);
                                }
                                $this->Flash->error(__('saindo aqui'));
                            }

                            $rolevents = $this->Subscriptions->Rolevents->find('list', ['limit' => 200]);
                            $subscriptionstypes = $this->Subscriptions->Subscriptionstypes->find('list', ['limit' => 200]);
                            $singlesubscriptions = $this->Subscriptions->Singlesubscriptions->find('list',array('conditions'=>array('Singlesubscriptions.id'=>$subscription->singlesubscription_id),'order' => array('Singlesubscriptions.id' => 'asc')));
                            $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
                            $this->set(compact('subscription', 'rolevents', 'users','subscriptionstypes','singlesubscriptions'));
                        
                        } else {
                            $this->Flash->error(__('Inscrição não pode ser alterada.'));
                            return $this->redirect(['action' => 'view', $id]);
                            
                        }               

    
    }

    public function convertsub($id = null)
    {
  
          
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        $profileid = $this->request
        ->getAttribute('identity')        
        ->get('profile_id'); 

        $userid = $this->request
        ->getAttribute('identity')        
        ->get('id'); 
        
        $useractive = $this->request
        ->getAttribute('identity')        
        ->get('active'); 

        $confirmed = $this->request
        ->getAttribute('identity')
        ->get('confirmed');
        
        $ctrl = Configure::read('ctrl._subscriptions');
        $act = Configure::read('act._conv');
        $ok = Configure::read('answ.alw');
        
       

        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);
        //var_dump($allprof->value);
                 
        if (($allprof->value == $ok) && ($useractive == true) && ($confirmed == true)) {

                           
                                $subscription = $this->Subscriptions->get($id);
                          
                                $singlesubscription =  $this->Singlesubscription->FindSingleSubscriptionById($subscription->singlesubscription_id);       
                                $subscription->id = $id; 
                                $subscription->user_id = $userid; 
                                $subscription->subscriptionstype_id = 2;
                                $subscription->rolevent_id = $singlesubscription->rolevent_id; 
                                $subscription->people_id = $singlesubscription->people_id; 
                                $subscription->originid = $singlesubscription->originid; 
                                $hoje = date("Y-m-d H:i:s");
                                $subscription->dateissue = $hoje;                                
                                $subscription->activeflag = true; 
                                $subscription->paymentvalue = $singlesubscription->price; 
                                $subscription->statusflag = "CONVERTIDA";
                                $subscription->description = "PREINSCON-".$singlesubscription->fullname;

                                if ($this->Subscriptions->save($subscription)) {

                                    $query = $this->Singlesubscriptions->find('all', [
                                        'conditions' => ['Singlesubscriptions.id' => $subscription->singlesubscription_id],  
                                    ]);
                                    $row = $query->first();
                                                                        
                                    $preinscricaoTable = TableRegistry::getTableLocator()->get('Singlesubscriptions');
                                    $preinscricao = $preinscricaoTable->get($row->id);
                                    $preinscricao->subscription_id = $subscription->id;
                                    $preinscricao->statusflag = 'INSCRICAO_CONVERTIDA';
                    
                                    $this->Singlesubscriptions->save($preinscricao);

                                    $this->Flash->success(__('The subscription has been saved.'));

                                    return $this->redirect(['action' => 'view', $id]);
                                    //return $this->redirect(['controller'=>'rolevents','action' => 'view', $roleventid]);
                                } else {
                                 $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
                            } 
                            /*
                            $rolevents = $this->Subscriptions->Rolevents->find('list', ['limit' => 200]);
                            $subscriptionstypes = $this->Subscriptions->Subscriptionstypes->find('list', ['limit' => 200]);
                            $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
                            $this->set(compact('subscription', 'rolevents', 'users','subscriptionstypes')); */
                        
                        } else {
                            $this->Flash->error(__('Inscrição não pode ser alterada.'));
                            return $this->redirect(['action' => 'view', $id]);
                            
                        }               

    
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscription id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

                $this->request->allowMethod(['post', 'delete']);
                $subscription = $this->Subscriptions->get($id);
                $roleventid = $subscription->rolevent_id;
                if ($this->Subscriptions->delete($subscription)) {
                    $this->Flash->success(__('The subscription has been deleted.'));
                } else {
                    $this->Flash->error(__('The subscription could not be deleted. Please, try again.'));
                }

                // return $this->redirect(['action' => 'index']);
                return $this->redirect(['controller'=>'rolevents','action' => 'view', $roleventid]);

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }
}
