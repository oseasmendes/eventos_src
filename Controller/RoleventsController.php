<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Core\Configure;
use Cake\I18n\FrozenTime;

/**
 * Rolevents Controller
 *
 * @property \App\Model\Table\RoleventsTable $Rolevents
 * @method \App\Model\Entity\Rolevent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoleventsController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->allowUnauthenticated(['viewfree']);
       

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function initialize(): void
    {
         parent::initialize();   
         $this->viewBuilder()->setLayout("newslight"); 
         $this->loadComponent('Staff'); 
         
    }    

   

    public function index()
    {
        //$this->viewBuilder()->setLayout('news');

        $bussinessunits = $this->Rolevents->Bussinessunits->find('list',array('conditions'=>array('Bussinessunits.org_id'=>1),'order' => array('Bussinessunits.seq' => 'asc','Bussinessunits.description' => 'asc')));


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
        
        $ctrl = Configure::read('ctrl._rolevents');
        $act = Configure::read('act._index');
        $ok = Configure::read('answ.alw');

            
        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);   
      
        $keyword = $this->request->getQueryParams('description');

        // --- falta fazer os IFs --- parei aqui 20/06

      
                    if (!is_null($allprof)) {                      
                                        
                            if (($profileid == 10) && ($roleid == 1)) {
                                if (!empty($keyword['description'])) {             
                                        $this->paginate = [
                                            'contain' => ['Bussinessunits'],
                                            'conditions' => [
                                                'Rolevents.description LIKE'=> '%'.$keyword['description'].'%',
                                                ],             
                                            'order' => [                        
                                            'Rolevents.description' => 'asc'
                                                ]            
                                            ];
                                            
                                        $rolevents = $this->paginate($this->Rolevents);
                                        } elseif(!empty($keyword['bussinessunit_id'])) {    
                                                        
                                            $this->paginate = [ 
                                            'contain' => ['Bussinessunits'],                       
                                            'conditions' => [
                                                    'Rolevents.bussinessunit_id ='=> $keyword['bussinessunit_id'],
                                                    'Rolevents.activeflag'=> true,
                                                    'Rolevents.enddate >'=> FrozenTime::now()
                                                    ],             
                                            'order' => ['Rolevents.description' => 'asc']            
                                        ];
                                        $rolevents = $this->paginate($this->Rolevents);          

                                        } else {
                                            $this->paginate = [
                                                'contain' => ['Bussinessunits'],
                                                'order' => [                        
                                                'Rolevents.description' => 'asc'
                                                    ]            
                                                ];
                                                
                                            $rolevents = $this->paginate($this->Rolevents);
                                }


                                $this->set(compact('rolevents','bussinessunits'));

                            } else {
                                if (($allprof->value == $ok) && ($useractive) && ($confirmed)) {
                                                if (!empty($keyword['description'])) {             
                                                                                
                                                    $this->paginate = [ 
                                                        'contain' => ['Bussinessunits'],                       
                                                        'conditions' => [
                                                                'Rolevents.description LIKE'=> '%'.$keyword['description'].'%',
                                                                'Rolevents.activeflag'=> true,
                                                                'Rolevents.enddate >'=> FrozenTime::now()
                                                                ],             
                                                        'order' => ['Rolevents.description' => 'asc']            
                                                    ];
                                                    $rolevents = $this->paginate($this->Rolevents);  
                                                
                                                } elseif(!empty($keyword['bussinessunit_id'])) {    
                                                    
                                                        $this->paginate = [ 
                                                        'contain' => ['Bussinessunits'],                       
                                                        'conditions' => [
                                                                'Rolevents.bussinessunit_id ='=> $keyword['bussinessunit_id'],
                                                                'Rolevents.activeflag'=> true,
                                                                'Rolevents.enddate >'=> FrozenTime::now()
                                                                ],             
                                                        'order' => ['Rolevents.description' => 'asc']            
                                                    ];
                                                    $rolevents = $this->paginate($this->Rolevents);  

                                                } else {

                                                    $this->paginate = [ 
                                                        'contain' => ['Bussinessunits'],                       
                                                        'conditions' => [                                    
                                                                'Rolevents.activeflag'=> true,
                                                                'Rolevents.enddate >'=> FrozenTime::now()
                                                                ],             
                                                        'order' => ['Rolevents.description' => 'asc']            
                                                    ];

                                                    $rolevents = $this->paginate($this->Rolevents);                                
                                                }
                                                $this->set(compact('rolevents','bussinessunits'));
                                } else {
                                    $this->Flash->error(__('Acesso não autorizado.'));
                                    return $this->redirect(['controller'=>'News','action' => 'home']);    
                                }
                            
                            }
                        } else {
                                
                            $this->Flash->error(__('Acesso Negado.'));
                            return $this->redirect(['controller'=>'News','action' => 'home']);    
                                
                        }

                    }

    /**
     * View method
     *
     * @param string|null $id Rolevent id.
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

        $confirmed = $this->request
        ->getAttribute('identity')        
        ->get('confirmed'); 
        
        $useractive = $this->request
        ->getAttribute('identity')        
        ->get('active'); 

        $userid = $this->request
        ->getAttribute('identity')        
        ->get('id'); 
        
        $ctrl = Configure::read('ctrl._rolevents');
        $act = Configure::read('act._view');
        $ok = Configure::read('answ.alw');

            
        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);   
       // var_dump($ctrl.'-'.$act.'-'.$profileid.'-'.$roleid);
       // exit();

        if (!is_null($allprof)) {                      
                               
                if (($profileid == 10) && ($roleid == 1)) {

                    $rolevent = $this->Rolevents->get($id, [
                        'contain' => [
                                'Agendas', 
                                'Breakingnews', 
                                'Roleventfiles', 
                                'Roleventschannels', 
                                'Roleventsimgs', 
                                'Bussinessunits',
                                'Subscriptions'=>[
                                    'sort' => ['Subscriptions.created' => 'DESC'],
                                    'conditions' => [                                            
                                            'Subscriptions.statusflag =' => 'GERADA_COM_SUCESSO',
                                            'Subscriptions.activeflag =' => true],
                                    ]
                            ],
                    ]);
    
                    $this->set(compact('rolevent'));
    
                } else {       
                   

                    if (($allprof->value == $ok) && ($useractive) && ($confirmed)) {

                    
                            $rolevent = $this->Rolevents->get($id, [
                                'contain' => [
                                        'Agendas', 
                                        'Breakingnews', 
                                        'Roleventfiles', 
                                        'Roleventschannels', 
                                        'Roleventsimgs', 
                                        'Bussinessunits',
                                        'Subscriptions'=>[
                                            'sort' => ['Subscriptions.created' => 'DESC'],
                                            'conditions' => [
                                                    'Subscriptions.user_id =' => $userid,
                                                    'Subscriptions.activeflag =' => true],
                                            ]],
                            ]);
            
                            $this->set(compact('rolevent'));

                        } else {
                            $this->Flash->error(__('Acesso Negado.'));
                            return $this->redirect(['controller'=>'News','action' => 'home']);    
                        }
                }              
                                
            } else {
                $this->Flash->error(__('Acesso Negado.'));
                return $this->redirect(['controller'=>'News','action' => 'home']);    
            }

                $this->set(compact('rolevent'));
                
                    
            
         
        
            $this->set(compact('rolevent'));
            
            
    }

    public function viewfree($id = null)
    {
       
                    $result = $this->Authentication->getResult();
                    
                    if ($result->isValid()) {
                        return $this->redirect(['action' => 'view',$id]);    
                    } else {
                            $rolevent = $this->Rolevents->get($id, [
                                'contain' => [
                                        'Agendas',                                         
                                        'Bussinessunits',
                                                                        ]]);
                            
                            $this->set(compact('rolevent'));
                    
                    }
            
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rolevent = $this->Rolevents->newEmptyEntity();
        if ($this->request->is('post')) {
            $rolevent = $this->Rolevents->patchEntity($rolevent, $this->request->getData());
            if ($this->Rolevents->save($rolevent)) {
                $this->Flash->success(__('The rolevent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rolevent could not be saved. Please, try again.'));
        }

        $bussinessunits = $this->Rolevents->Bussinessunits->find('list',array('conditions'=>array('Bussinessunits.org_id'=>1),'order' => array('description' => 'asc')));

        $this->set(compact('rolevent','bussinessunits'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rolevent id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rolevent = $this->Rolevents->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rolevent = $this->Rolevents->patchEntity($rolevent, $this->request->getData());
            if ($this->Rolevents->save($rolevent)) {
                $this->Flash->success(__('The rolevent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rolevent could not be saved. Please, try again.'));
        }

        $bussinessunits = $this->Rolevents->Bussinessunits->find('list',array('conditions'=>array('Bussinessunits.org_id'=>1),'order' => array('description' => 'asc')));

        $this->set(compact('rolevent','bussinessunits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rolevent id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rolevent = $this->Rolevents->get($id);
        if ($this->Rolevents->delete($rolevent)) {
            $this->Flash->success(__('The rolevent has been deleted.'));
        } else {
            $this->Flash->error(__('The rolevent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
