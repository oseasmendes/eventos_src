<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Conditions Controller
 *
 * @property \App\Model\Table\ConditionsTable $Conditions
 * @method \App\Model\Entity\Condition[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConditionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $conditions = $this->paginate($this->Conditions);

        $this->set(compact('conditions'));
    }

    /**
     * View method
     *
     * @param string|null $id Condition id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $condition = $this->Conditions->get($id, [
            'contain' => ['Peoples'],
        ]);

        $this->set(compact('condition'));
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


        $condition = $this->Conditions->newEmptyEntity();
        if ($this->request->is('post')) {
            $condition = $this->Conditions->patchEntity($condition, $this->request->getData());
            if ($this->Conditions->save($condition)) {
                $this->Flash->success(__('The condition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The condition could not be saved. Please, try again.'));
        }
        $this->set(compact('condition'));

            
        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Condition id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {


        $condition = $this->Conditions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $condition = $this->Conditions->patchEntity($condition, $this->request->getData());
            if ($this->Conditions->save($condition)) {
                $this->Flash->success(__('The condition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The condition could not be saved. Please, try again.'));
        }
        $this->set(compact('condition'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Condition id.
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
        $condition = $this->Conditions->get($id);
        if ($this->Conditions->delete($condition)) {
            $this->Flash->success(__('The condition has been deleted.'));
        } else {
            $this->Flash->error(__('The condition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }
}
