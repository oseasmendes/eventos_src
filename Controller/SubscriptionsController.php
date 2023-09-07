<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Mailer\MailerAwareTrait;
use Cake\Core\Configure;

/**
 * Subscriptions Controller
 *
 * @property \App\Model\Table\SubscriptionsTable $Subscriptions
 * @method \App\Model\Entity\Subscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscriptionsController extends AppController
{
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
                    'contain' => ['Rolevents', 'Users'],
                ];
                $subscriptions = $this->paginate($this->Subscriptions);

                $this->set(compact('subscriptions'));

         
        } else {

                $this->paginate = [
                    'contain' => ['Rolevents', 'Users'],                         
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

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userid = $this->request
        ->getAttribute('identity')
        ->getIdentifier();


        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {
                $subscription = $this->Subscriptions->newEmptyEntity();
                if ($this->request->is('post')) {
                    $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
                    if ($this->Subscriptions->save($subscription)) {
                        $this->Flash->success(__('The subscription has been saved.'));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
                }
                $rolevents = $this->Subscriptions->Rolevents->find('list', ['limit' => 200]);
                $subscriptionstypes = $this->Subscriptions->Subscriptionstypes->find('list', ['limit' => 200]);
                $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
                $this->set(compact('subscription', 'rolevents', 'users','subscriptionstypes'));

        } else {
                return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    use MailerAwareTrait;

    public function addid($id = null)
    {
        $subscription = $this->Subscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
            $subscription->rolevent_id = $id;
            $subscription->subscriptiontype_id = 1;
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
            $subscription->subscriptiontype_id = 1;
            $hoje = date("Y-m-d H:i:s");
            $subscription->dateissue = $hoje;
            //identificando o usuário logado
            $subscription->user_id = $this->request->getAttribute('identity')->getIdentifier();
            $subscription->statusflag = 'ABERTA';
            $subscription->activeflag = true;
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
            $subscription->subscriptiontype_id = 1;
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
  
    $userid = $this->request
    ->getAttribute('identity')
    ->getIdentifier();


    $roleid = $this->request
    ->getAttribute('identity')
    ->get('role_id');

    if ($roleid == 1) {

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

        $subscription = $this->Subscriptions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscription = $this->Subscriptions->patchEntity($subscription, $this->request->getData());
            $roleventid = $subscription->rolevent_id; 
            
            if ($userid == $subscription->user_id) {
                        if ($this->Subscriptions->save($subscription)) {
                            $this->Flash->success(__('The subscription has been saved.'));

                            //return $this->redirect(['action' => 'index']);
                            return $this->redirect(['controller'=>'rolevents','action' => 'view', $roleventid]);
                        }
                        $this->Flash->error(__('The subscription could not be saved. Please, try again.'));
                    } else {
                        $this->Flash->error(__('The subscription could not be saved. User not equal from subscription.'));

                        return $this->redirect(['controller'=>'Users','action' => 'refuse']);
                    }
        }
        $rolevents = $this->Subscriptions->Rolevents->find('list', ['limit' => 200]);
        $subscriptionstypes = $this->Subscriptions->Subscriptionstypes->find('list', ['limit' => 200]);
        $users = $this->Subscriptions->Users->find('list', ['limit' => 200]);
        $this->set(compact('subscription', 'rolevents', 'users','subscriptionstypes'));
     
       
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
