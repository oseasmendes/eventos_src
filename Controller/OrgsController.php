<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Core\Configure;

/**
 * Orgs Controller
 *
 * @property \App\Model\Table\OrgsTable $Orgs
 * @method \App\Model\Entity\Org[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrgsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
     //   $this->viewBuilder()->setLayout("admin");
     //   $this->loadComponent('Peoplescontacts');
          //$this->loadComponent('Paginator');
          $this->loadComponent('Usr');          
          $this->loadComponent('Staff');    
          

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $orgs = $this->paginate($this->Orgs);

        $this->set(compact('orgs'));
    }

    /**
     * View method
     *
     * @param string|null $id Org id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {


        $org = $this->Orgs->get($id, [
            'contain' => ['Bussinessunits'=> [
                'sort' => ['Bussinessunits.seq' => 'asc','Bussinessunits.description' => 'asc'],
                'conditions' => ['Bussinessunits.active =' => true]           
            ]
        
        ],
        ]);

        $this->set(compact('org'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
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
        
        $ctrl = Configure::read('ctrl._orgs');
        $act = Configure::read('act._add');
        $ok = Configure::read('answ.alw');

            
        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);   

        if (!is_null($allprof)) {                      
                               
            if (($profileid == 10) && ($roleid == 1)) {

                $org = $this->Orgs->newEmptyEntity();
                if ($this->request->is('post')) {
                    $org = $this->Orgs->patchEntity($org, $this->request->getData());
                    if ($this->Orgs->save($org)) {
                        $this->Flash->success(__('The org has been saved.'));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('The org could not be saved. Please, try again.'));
                }
                $this->set(compact('org'));

            } else {
                $this->Flash->error(__('Acesso não autorizado.'));
                return $this->redirect(['controller'=>'News','action' => 'home']);                        
            }                                            
        } else {
            $this->Flash->error(__('Acesso Negado.'));
            return $this->redirect(['controller'=>'News','action' => 'home']);                        
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Org id.
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
        
        $ctrl = Configure::read('ctrl._orgs');
        $act = Configure::read('act._edit');
        $ok = Configure::read('answ.alw');

            
        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);   

        if (!is_null($allprof)) {                      
                               
            if (($profileid == 10) && ($roleid == 1)) {

                        $org = $this->Orgs->get($id, [
                            'contain' => [],
                        ]);
                        if ($this->request->is(['patch', 'post', 'put'])) {
                            $org = $this->Orgs->patchEntity($org, $this->request->getData());
                            if ($this->Orgs->save($org)) {
                                $this->Flash->success(__('The org has been saved.'));

                                return $this->redirect(['action' => 'index']);
                            }
                            $this->Flash->error(__('The org could not be saved. Please, try again.'));
                        }
                        $this->set(compact('org'));

            } else {
                        $this->Flash->error(__('Acesso não autorizado.'));
                        return $this->redirect(['action' => 'view', $id]);                        
            }                                            
        } else {
                    $this->Flash->error(__('Acesso Negado.'));
                    return $this->redirect(['action' => 'view', $id]);                        
                    
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Org id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
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
        
        $ctrl = Configure::read('ctrl._orgs');
        $act = Configure::read('act._delete');
        $ok = Configure::read('answ.alw');

            
        $allprof = $this->Staff->mcontrol($ctrl,$act,$profileid,$roleid);   

        if (!is_null($allprof)) {                      
                               
            if (($profileid == 10) && ($roleid == 1)) {

                    $this->request->allowMethod(['post', 'delete']);
                    $org = $this->Orgs->get($id);
                    if ($this->Orgs->delete($org)) {
                        $this->Flash->success(__('The org has been deleted.'));
                    } else {
                        $this->Flash->error(__('The org could not be deleted. Please, try again.'));
                    }

                    return $this->redirect(['action' => 'index']);

            } else {
                    $this->Flash->error(__('Acesso não autorizado.'));
                    return $this->redirect(['action' => 'view', $id]);                        
            }                                            
        } else {
                $this->Flash->error(__('Acesso Negado.'));
                return $this->redirect(['action' => 'view', $id]);                                        
        }
    }
}
