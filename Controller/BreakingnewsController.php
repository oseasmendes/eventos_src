<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Breakingnews Controller
 *
 * @property \App\Model\Table\BreakingnewsTable $Breakingnews
 * @method \App\Model\Entity\Breakingnews[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BreakingnewsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [   
             'conditions' => ['Breakingnews.activeflag = '=> true],                  
             'order' => ['Breakingnews.expirationdate' => 'asc']
       ];

        $breakingnews = $this->paginate($this->Breakingnews);

        $this->set(compact('breakingnews'));
    }

    /**
     * View method
     *
     * @param string|null $id Breakingnews id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $breakingnews = $this->Breakingnews->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('breakingnews'));
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

        $breakingnews = $this->Breakingnews->newEmptyEntity();
        if ($this->request->is('post')) {
            $breakingnews = $this->Breakingnews->patchEntity($breakingnews, $this->request->getData());
            if ($this->Breakingnews->save($breakingnews)) {
                $this->Flash->success(__('The breakingnews has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The breakingnews could not be saved. Please, try again.'));
        }
        $rolevents = $this->Breakingnews->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('breakingnews','rolevents'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Breakingnews id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {


        $breakingnews = $this->Breakingnews->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $breakingnews = $this->Breakingnews->patchEntity($breakingnews, $this->request->getData());
            if ($this->Breakingnews->save($breakingnews)) {
                $this->Flash->success(__('The breakingnews has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error(__('The breakingnews could not be saved. Please, try again.'));
        }
        
        $rolevents = $this->Breakingnews->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('breakingnews', 'rolevents'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Breakingnews id.
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
        $breakingnews = $this->Breakingnews->get($id);
        if ($this->Breakingnews->delete($breakingnews)) {
            $this->Flash->success(__('The breakingnews has been deleted.'));
        } else {
            $this->Flash->error(__('The breakingnews could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);    
        
        } else {
        return $this->redirect(['controller'=>'Users','action' => 'refuse']);
    }
    }

    

}
