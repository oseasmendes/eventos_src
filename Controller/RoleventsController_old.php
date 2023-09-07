<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Core\Configure;

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
    //   $this->viewBuilder()->setLayout("admin");
    //   $this->loadComponent('Peoplescontacts');
         //$this->loadComponent('Paginator');         
         $this->loadComponent('Staff'); 
         
    }    


    public function index()
    {
        $rolevents = $this->paginate($this->Rolevents);

        $this->set(compact('rolevents'));
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

        $useractive = $this->request
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
         
     
       if (!is_null($allprof)) {

        if (($allprof->value == $ok) && ($useractive == true) && ($confirmed == true)) {

            

            $rolevent = $this->Rolevents->get($id, [
                'contain' => [
                        'Subscriptions'=>[
                        'sort' => ['Subscriptions.created' => 'DESC'],
                        'conditions' => [
                                'Subscriptions.user_id =' => $userid,
                                'Subscriptions.activeflag =' => true],
                        ],
                        'Roleventsimgs'],
            ]);

         //   var_dump($rolevent);
         //   exit();

            $this->set(compact('rolevent','subscription','roleventsimg',$rolevent));           

              

            } else {
                
                 $rolevent = $this->Rolevents->get($id, [
                    'contain' => ['Subscriptions'=>[
                        'sort' => ['Subscriptions.created' => 'DESC'],
                        'conditions' => ['Subscriptions.activeflag =' => true],
                    ],'Roleventsimgs'],
                ]);

               // var_dump($rolevent);
                //exit();

                $this->set(compact('rolevent','subscription','roleventsimg',$rolevent));           

                
            }    

        }        
       
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

        if ($roleid == 1) {

        $rolevent = $this->Rolevents->newEmptyEntity();
        if ($this->request->is('post')) {
            $rolevent = $this->Rolevents->patchEntity($rolevent, $this->request->getData());
            if ($this->Rolevents->save($rolevent)) {

                $reg = $rolevent->id;
                $caminho = WWW_ROOT.DS.'img'.DS.'rolevents'.DS.$reg;    
               
                                                
                if (!file_exists($caminho)) {
                        mkdir($caminho, 0777, true);
                }

                $this->Flash->success(__('The rolevent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rolevent could not be saved. Please, try again.'));
        }
        $this->set(compact('rolevent'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
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

        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $rolevent = $this->Rolevents->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rolevent = $this->Rolevents->patchEntity($rolevent, $this->request->getData());
            if ($this->Rolevents->save($rolevent)) {

                $reg = $id;
                $caminho = WWW_ROOT.DS.'img'.DS.'rolevents'.DS.$reg;    
               
                                                
                if (!file_exists($caminho)) {
                        mkdir($caminho, 0777, true);
                }

                $this->Flash->success(__('The rolevent has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rolevent could not be saved. Please, try again.'));
        }
        $this->set(compact('rolevent'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
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

        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {


        $this->request->allowMethod(['post', 'delete']);
        $rolevent = $this->Rolevents->get($id);
        if ($this->Rolevents->delete($rolevent)) {
            $this->Flash->success(__('The rolevent has been deleted.'));
        } else {
            $this->Flash->error(__('The rolevent could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

 
}
