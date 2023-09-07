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
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function initialize(): void
    {
         parent::initialize();    
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
        $act = Configure::read('act._view');
        $ok = Configure::read('answ.alw');

            
        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);   
      
        $keyword = $this->request->getQueryParams('description');

        // --- falta fazer os IFs --- parei aqui 20/06

        if (!is_null($allprof)) {                      
                               
                if (($profileid == 10) && ($roleid == 1)) {

                    $this->paginate = [
                        'contain' => ['Bussinessunits'],
                        'order' => [                        
                         'Rolevents.description' => 'asc'
                            ]            
                        ];
                        
                    $rolevents = $this->paginate($this->Rolevents);

                    $this->set(compact('rolevents','bussinessunits'));

                } else {
                    
                    if (($allprof->value == $ok) && ($useractive) && ($confirmed)) {
                        $this->paginate = [ 
                            'contain' => ['Bussinessunits'],                       
                            'conditions' => ['Rolevents.activeflag'=> true,'Rolevents.enddate >'=> FrozenTime::now()],             
                            'order' => ['Rolevents.description' => 'asc']            
                        ];

                       
                        $rolevents = $this->paginate($this->Rolevents);
    
                        $this->set(compact('rolevents','bussinessunits'));
                    } else {
                        return $this->redirect(['controller'=>'Users','action' => 'refuse']);    
                    }
                }
                                
            } else {
                    
                    return $this->redirect(['controller'=>'Users','action' => 'refuse']);
                    
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
                                'Subscriptions'],
                    ]);
    
                    $this->set(compact('rolevent','bussinessunits'));
    
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
            
                            $this->set(compact('rolevent','bussinessunits'));

                        } else {
                            return $this->redirect(['controller'=>'Users','action' => 'refuse']);    
                        }
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
