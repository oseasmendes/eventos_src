<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Subscriptionsflows Controller
 *
 * @property \App\Model\Table\SubscriptionsflowsTable $Subscriptionsflows
 * @method \App\Model\Entity\Subscriptionsflow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscriptionsflowsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Subscriptions'],
        ];
        $subscriptionsflows = $this->paginate($this->Subscriptionsflows);

        $this->set(compact('subscriptionsflows'));
    }

    /**
     * View method
     *
     * @param string|null $id Subscriptionsflow id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subscriptionsflow = $this->Subscriptionsflows->get($id, [
            'contain' => ['Subscriptions'],
        ]);

        $this->set(compact('subscriptionsflow'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subscriptionsflow = $this->Subscriptionsflows->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscriptionsflow = $this->Subscriptionsflows->patchEntity($subscriptionsflow, $this->request->getData());
            if ($this->Subscriptionsflows->save($subscriptionsflow)) {
                $this->Flash->success(__('The subscriptionsflow has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriptionsflow could not be saved. Please, try again.'));
        }
        $subscriptions = $this->Subscriptionsflows->Subscriptions->find('list', ['limit' => 200]);
        $this->set(compact('subscriptionsflow', 'subscriptions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subscriptionsflow id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subscriptionsflow = $this->Subscriptionsflows->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscriptionsflow = $this->Subscriptionsflows->patchEntity($subscriptionsflow, $this->request->getData());
            if ($this->Subscriptionsflows->save($subscriptionsflow)) {
                $this->Flash->success(__('The subscriptionsflow has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriptionsflow could not be saved. Please, try again.'));
        }
        $subscriptions = $this->Subscriptionsflows->Subscriptions->find('list', ['limit' => 200]);
        $this->set(compact('subscriptionsflow', 'subscriptions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscriptionsflow id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subscriptionsflow = $this->Subscriptionsflows->get($id);
        if ($this->Subscriptionsflows->delete($subscriptionsflow)) {
            $this->Flash->success(__('The subscriptionsflow has been deleted.'));
        } else {
            $this->Flash->error(__('The subscriptionsflow could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
