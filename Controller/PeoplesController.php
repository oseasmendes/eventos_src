<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Core\Configure;


/**
 * Peoples Controller
 *
 * @property \App\Model\Table\PeoplesTable $Peoples
 * @method \App\Model\Entity\People[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PeoplesController extends AppController
{
  //  public $ctrl;
   
    public function initialize(): void
    {
         parent::initialize();
    //   $this->viewBuilder()->setLayout("admin");
    //   $this->loadComponent('Peoplescontacts');
         //$this->loadComponent('Paginator');
         $this->loadComponent('Usr');
         $this->loadComponent('Staff');         
         $this->loadModel('Rolevents'); 
        
        // $ctrl = '7307135';

         $this->viewBuilder()->setLayout("admin");      

        
         
    }    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */


    public function index()
    {
        //---- Início do controle de acesso -------
       

        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        $profileid = $this->request
        ->getAttribute('identity')        
        ->get('profile_id'); 

        $confirmed = $this->request
        ->getAttribute('identity')        
        ->get('confirmed'); 
        
        $useractive = $this->request
        ->getAttribute('identity')        
        ->get('active'); 

        $userid = $this->request
        ->getAttribute('identity')
        ->get('id');
        
        $ctrl = Configure::read('ctrl._peoples');
        $act = Configure::read('act._index');
        $ok = Configure::read('answ.alw');
        
       

        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);


         
        if (($allprof->value == $ok) && ($useractive == true) && ($confirmed == true)) {
        
        // } else {
        //    return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        //}

        //---- Fim do controle de acesso -------    
            $bussinessunits = $this->Peoples->Bussinessunits->find('list',array('order' => array('description' => 'asc')), ['limit' => 200]); //'conditions' => ['Bussinessunits.id ='=> 1],


            $keyword = $this->request->getQueryParams('descricao');
        
            if (!empty($keyword['name'])) {

                $this->paginate = [
                    'contain' => ['Bussinessunits', 
                    'Positions', 
                    'Districts', 
                    'Cities', 
                    'Civilstatus', 
                    'Conditions', 
                    'Users'],
                    'conditions' => ['Peoples.name LIKE '=> '%'.$keyword['name'].'%'],             
                    'order' => array('bussinessunit_id' => 'asc','name' => 'asc'),                   
                ];

                $peoples = $this->paginate($this->Peoples);   
            
            } elseif (!empty($keyword['bussinessunit_id'])) {

                $this->paginate = [
                    'contain' => [
                    'Bussinessunits', 
                    'Positions', 
                    'Districts', 
                    'Cities', 
                    'Civilstatus', 
                    'Conditions', 
                    'Users'],
                    'conditions' => ['Peoples.bussinessunit_id = '=> $keyword['bussinessunit_id']],             
                    'order' => array('Peoples.bussinessunit_id' => 'asc','Peoples.name' => 'asc'),                   
                ];

                $peoples = $this->paginate($this->Peoples);   

            } elseif (!empty($keyword['idocnumber'])) {

                $this->paginate = [
                    'contain' => [
                    'Bussinessunits', 
                    'Positions', 
                    'Districts', 
                    'Cities', 
                    'Civilstatus', 
                    'Conditions', 
                    'Users'],
                    'conditions' => ['Peoples.idocnumber LIKE '=> ''.$keyword['idocnumber'].''],               
                    'order' => array('Peoples.bussinessunit_id' => 'asc','Peoples.name' => 'asc'),                   
                ];

                $peoples = $this->paginate($this->Peoples);   
                
            } else {
                    
                    $this->paginate = [
                        'contain' => ['Bussinessunits', 'Positions', 'Districts', 'Cities', 'Civilstatus', 'Conditions', 'Users'],
                        'order' => array('bussinessunit_id' => 'asc','name' => 'asc'),   
                    ];

                    $peoples = $this->paginate($this->Peoples);
            }


        
        
        


        $this->set(compact('peoples','bussinessunits'));

        } else {

            
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
            $this->Flash->error(__('Acesso não autorizado. Fale com o Administrador'));
        }
    }

    /**
     * View method
     *
     * @param string|null $id People id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

         //---- Início do controle de acesso -------
       

       $roleid = $this->request
       ->getAttribute('identity')
       ->get('role_id');

       $profileid = $this->request
       ->getAttribute('identity')        
       ->get('profile_id'); 

       $confirmed = $this->request
       ->getAttribute('identity')        
       ->get('confirmed'); 
       
       $useractive = $this->request
       ->getAttribute('identity')        
       ->get('active'); 

       $userid = $this->request
       ->getAttribute('identity')
       ->get('id');
       
       $ctrl = Configure::read('ctrl._peoples');
       $act = Configure::read('act._viewsub');
       $ok = Configure::read('answ.alw');
       
      

       $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);


        
       if (($allprof->value == $ok) && ($useractive == true) && ($confirmed == true)) {
      
    
        if (($roleid != 3) && ($roleid != 6)) {

                $people = $this->Peoples->get($id, [
                    'contain' => [
                            'Bussinessunits', 
                            'Positions',
                            'Subscriptions' ,
                            'Districts', 
                            'Cities', 
                            'Civilstatus', 
                            'Conditions', 
                            'Users'],
                ]);

                $this->set(compact('people'));
                        } else {
                            
                            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
                        
                        }


            } else {

            return $this->redirect(['controller'=>'Users','action' => 'refuse']);

            }        

    }


    public function viewsub($id = null)
    {
       //---- Início do controle de acesso -------
       

       $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        $profileid = $this->request
        ->getAttribute('identity')        
        ->get('profile_id'); 

        $confirmed = $this->request
        ->getAttribute('identity')        
        ->get('confirmed'); 
        
        $useractive = $this->request
        ->getAttribute('identity')        
        ->get('active'); 

        $userid = $this->request
        ->getAttribute('identity')
        ->get('id');
        
        $ctrl = Configure::read('ctrl._peoples');
        $act = Configure::read('act._viewsub');
        $ok = Configure::read('answ.alw');
        
       

        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);


         
        if (($allprof->value == $ok) && ($useractive == true) && ($confirmed == true)) {
       
     
       //---- Fim do controle de acesso ------- 
       
                                    if (($roleid != 3) && ($roleid != 6)) {

                                        $people = $this->Peoples->get($id, [
                                            'contain' => [
                                                    'Subscriptions'=>[
                                                        'sort' => ['Subscriptions.created' => 'DESC'],
                                                        'conditions' => [
                                                                'Subscriptions.people_id =' => $id,
                                                                'Subscriptions.activeflag =' => true],
                                                        ],
                                            /*    'Bussinessunits',
                                                'Positions',                
                                                'Districts', 
                                                'Cities', 
                                                'Civilstatus',
                                                'Conditions', */
                                                'Users'], 
                                        ]);

                                        $this->set(compact('people'));

                                    } else {
                
                                        return $this->redirect(['controller'=>'Users','action' => 'refuse']);
                                       
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
        //---- Início do controle de acesso -------
       

       $roleid = $this->request
       ->getAttribute('identity')
       ->get('role_id');

       $profileid = $this->request
       ->getAttribute('identity')        
       ->get('profile_id');        
       
       $ctrl = Configure::read('CtrlPeople.control');
       $ok = Configure::read('RespAll.Ok');
       $reg = Configure::read('CtrlPeople.dd');

       $allprof = $this->Staff->mcontrol($ctrl,$reg,$profileid,$roleid);
        
       if ($allprof->value == $ok) {

        $people = $this->Peoples->newEmptyEntity();
        if ($this->request->is('post')) {
            $people = $this->Peoples->patchEntity($people, $this->request->getData());
            if ($this->Peoples->save($people)) {
                $this->Flash->success(__('The people has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The people could not be saved. Please, try again.'));
        }
        $bussinessunits = $this->Peoples->Bussinessunits->find('list', ['limit' => 200]);
        $positions = $this->Peoples->Positions->find('list', ['limit' => 200]);
        $districts = $this->Peoples->Districts->find('list', ['limit' => 200]);
        $cities = $this->Peoples->Cities->find('list', ['limit' => 200]);
        $civilstatus = $this->Peoples->Civilstatus->find('list', ['limit' => 200]);
        $conditions = $this->Peoples->Conditions->find('list', ['limit' => 200]);
        $users = $this->Peoples->Users->find('list', ['limit' => 200]);
        $this->set(compact('people', 'bussinessunits', 'positions', 'districts', 'cities', 'civilstatus', 'conditions', 'users'));
        
        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
            $this->Flash->error(__('Acesso não autorizado. Fale com o Administrador'));
        }
   
    }

    public function addmn()
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');
 
        $profileid = $this->request
        ->getAttribute('identity')        
        ->get('profile_id');        
        
        $ctrl = Configure::read('CtrlPeople.control');
        $ok = Configure::read('RespAll.Ok');
        $reg = Configure::read('CtrlPeople.dm');
 
        $allprof = $this->Staff->mcontrol($ctrl,$reg,$profileid,$roleid);

          
         
        if ($allprof->value == $ok) {
            


                    $people = $this->Peoples->newEmptyEntity();
       

        

                    if ($this->request->is('post')) {
                        $people = $this->Peoples->patchEntity($people, $this->request->getData());
                        $people->user_id = $usrid;
                        $people->origin = 'staff';
                        $people->origindescription = 'EBO';
                    
                        if ($this->Peoples->save($people)) {
                            $this->Flash->success(__('The people has been saved.'));

                            return $this->redirect(['action' => 'index']);
                        }
                        $this->Flash->error(__('The people could not be saved. Please, try again.'));
                    }
                    $bussinessunits = $this->Peoples->Bussinessunits->find('list', ['limit' => 200]);
                    $positions = $this->Peoples->Positions->find('list', ['limit' => 200]);
                    $districts = $this->Peoples->Districts->find('list', ['limit' => 200]);
                    $cities = $this->Peoples->Cities->find('list', ['limit' => 200]);
                    $civilstatus = $this->Peoples->Civilstatus->find('list', ['limit' => 200]);
                    $conditions = $this->Peoples->Conditions->find('list', ['limit' => 200]);
                    $users = $this->Peoples->Users->find('list', ['limit' => 200]);
                    $this->set(compact('people', 'bussinessunits', 'positions', 'districts', 'cities', 'civilstatus', 'conditions', 'users'));
        
        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
           
        }
   
    }

    public function addid($id = null)
    {
        $people = $this->Peoples->newEmptyEntity();
        if ($this->request->is('post')) {
            $people = $this->Peoples->patchEntity($people, $this->request->getData());
           
            $usr = $this->Usr->findUserbyId($id); 
            $people->user_id = $id; 
            $people->name = $usr->name;
            $people->idocnumber = $usr->docnumber;
            $people->mobile = $usr->mobile;
            $people->origin = 9;
            $people->origindescription = "bysite";



            if ($this->Peoples->save($people)) {
                $this->Flash->success(__('The people has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The people could not be saved. Please, try again.'));
        }
        $bussinessunits = $this->Peoples->Bussinessunits->find('list', ['limit' => 200]);
        $positions = $this->Peoples->Positions->find('list', ['limit' => 200]);
        $districts = $this->Peoples->Districts->find('list', ['limit' => 200]);
        $cities = $this->Peoples->Cities->find('list', ['limit' => 200]);
        $civilstatus = $this->Peoples->Civilstatus->find('list', ['limit' => 200]);
        $conditions = $this->Peoples->Conditions->find('list', ['limit' => 200]);
        $users = $this->Peoples->Users->find('list', ['limit' => 200]);
        $this->set(compact('people', 'bussinessunits', 'positions', 'districts', 'cities', 'civilstatus', 'conditions', 'users'));
    }
    /**
     * Edit method
     *
     * @param string|null $id People id.
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

        $confirmed = $this->request
        ->getAttribute('identity')        
        ->get('confirmed'); 
        
        $useractive = $this->request
        ->getAttribute('identity')        
        ->get('active'); 

        $userid = $this->request
        ->getAttribute('identity')        
        ->get('id'); 
        
        $ctrl = Configure::read('ctrl._peoples');
        $act = Configure::read('act._edit');
        $ok = Configure::read('answ.alw');

            
        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);          

        if (!is_null($allprof)) {                      
                               
                if (($profileid == 10) && ($roleid == 1)) {

                        $people = $this->Peoples->get($id, [
                            'contain' => [],
                        ]);
                        if ($this->request->is(['patch', 'post', 'put'])) {
                            $people = $this->Peoples->patchEntity($people, $this->request->getData());
                            if ($this->Peoples->save($people)) {
                                $this->Flash->success(__('The people has been saved.'));

                                return $this->redirect(['action' => 'index']);
                            }
                            $this->Flash->error(__('The people could not be saved. Please, try again.'));
                        }

                    } else {       
                   

                        if (($allprof->value == $ok) && ($useractive) && ($confirmed)) {

                            $people = $this->Peoples->get($id, [
                                'contain' => [],
                            ]);
                            if ($this->request->is(['patch', 'post', 'put'])) {
                                $people = $this->Peoples->patchEntity($people, $this->request->getData());
                                if ($this->Peoples->save($people)) {
                                    $this->Flash->success(__('The people has been saved.'));
    
                                    return $this->redirect(['action' => 'index']);
                                }
                                $this->Flash->error(__('The people could not be saved. Please, try again.'));
                            }

                        } else {
                            return $this->redirect(['controller'=>'Users','action' => 'refuse']);    
                        }
                }              
                                
            } else {
                    
                    return $this->redirect(['controller'=>'Users','action' => 'refuse']);
                    
            }



        $bussinessunits = $this->Peoples->Bussinessunits->find('list', ['limit' => 200]);
        $positions = $this->Peoples->Positions->find('list', ['limit' => 200]);
        $districts = $this->Peoples->Districts->find('list', ['limit' => 200]);
        $cities = $this->Peoples->Cities->find('list', ['limit' => 200]);
        $civilstatus = $this->Peoples->Civilstatus->find('list', ['limit' => 200]);
        $conditions = $this->Peoples->Conditions->find('list', ['limit' => 200]);
        $users = $this->Peoples->Users->find('list', ['limit' => 200]);
        $this->set(compact('people', 'bussinessunits', 'positions', 'districts', 'cities', 'civilstatus', 'conditions', 'users'));
    }

    public function editmn($id = null)
    {

        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        $profileid = $this->request
        ->getAttribute('identity')        
        ->get('profile_id'); 

        $confirmed = $this->request
        ->getAttribute('identity')        
        ->get('confirmed'); 
        
        $useractive = $this->request
        ->getAttribute('identity')        
        ->get('active'); 

        $userid = $this->request
        ->getAttribute('identity')        
        ->get('id'); 
        
        $ctrl = Configure::read('ctrl._peoples');
        $act = Configure::read('act._editmn');
        $ok = Configure::read('answ.alw');

            
        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);          

        if (!is_null($allprof)) {                      
                               
                if (($profileid == 10) && ($roleid == 1)) {

                        $people = $this->Peoples->get($id, [
                            'contain' => [],
                        ]);
                        if ($this->request->is(['patch', 'post', 'put'])) {
                            $people = $this->Peoples->patchEntity($people, $this->request->getData());
                            if ($this->Peoples->save($people)) {
                                $this->Flash->success(__('The people has been saved.'));

                                //return $this->redirect(['action' => 'index']);
                                return $this->redirect(['controller'=>'Users','action' => 'view',$userid]);
                            }
                            $this->Flash->error(__('The people could not be saved. Please, try again.'));
                        }
                        
                        
                                    $bussinessunits = $this->Peoples->Bussinessunits->find('list', ['limit' => 200]);
                                    $positions = $this->Peoples->Positions->find('list', ['limit' => 200]);
                                    $districts = $this->Peoples->Districts->find('list', ['limit' => 200]);
                                    $cities = $this->Peoples->Cities->find('list', ['limit' => 200]);
                                    $civilstatus = $this->Peoples->Civilstatus->find('list', ['limit' => 200]);
                                    $conditions = $this->Peoples->Conditions->find('list', ['limit' => 200]);
                                    $users = $this->Peoples->Users->find('list', ['limit' => 200]); 
                                    $this->set(compact('people', 'bussinessunits', 'positions', 'districts', 'cities', 'civilstatus', 'conditions', 'users')); 
                        
                    } else {       
                   

                        if (($allprof->value == $ok) && ($useractive) && ($confirmed)) {

                            $people = $this->Peoples->get($id, [
                                'contain' => [],
                            ]);
                            if ($this->request->is(['patch', 'post', 'put'])) {
                                $people = $this->Peoples->patchEntity($people, $this->request->getData());
                                if ($this->Peoples->save($people)) {
                                    $this->Flash->success(__('The people has been saved.'));    
                                    
                                    return $this->redirect(['controller'=>'Users','action' => 'view',$userid]);
                                }
                                $this->Flash->error(__('The people could not be saved. Please, try again.'));
                        
                            }

                            
                                                $bussinessunits = $this->Peoples->Bussinessunits->find('list', ['limit' => 200]);
                                                $positions = $this->Peoples->Positions->find('list', ['limit' => 200]);
                                                $districts = $this->Peoples->Districts->find('list', ['limit' => 200]);
                                                $cities = $this->Peoples->Cities->find('list', ['limit' => 200]);
                                                $civilstatus = $this->Peoples->Civilstatus->find('list', ['limit' => 200]);
                                                $conditions = $this->Peoples->Conditions->find('list', ['limit' => 200]);
                                                $users = $this->Peoples->Users->find('list', ['limit' => 200]); 
                                                $this->set(compact('people', 'bussinessunits', 'positions', 'districts', 'cities', 'civilstatus', 'conditions', 'users')); 
                            

                        } else {
                            return $this->redirect(['controller'=>'Users','action' => 'refuse']);    
                        }
                }              
                                
            } else {
                    
                    return $this->redirect(['controller'=>'Users','action' => 'refuse']);
                    
            }



    }

    /**
     * Delete method
     *
     * @param string|null $id People id.
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
        $people = $this->Peoples->get($id);
        if ($this->Peoples->delete($people)) {
            $this->Flash->success(__('The people has been deleted.'));
        } else {
            $this->Flash->error(__('The people could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

   
}
