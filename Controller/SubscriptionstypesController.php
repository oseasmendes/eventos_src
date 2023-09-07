<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Subscriptionstypes Controller
 *
 * @property \App\Model\Table\SubscriptionstypesTable $Subscriptionstypes
 * @method \App\Model\Entity\Subscriptionstype[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscriptionstypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $subscriptionstypes = $this->paginate($this->Subscriptionstypes);

        $this->set(compact('subscriptionstypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Subscriptionstype id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subscriptionstype = $this->Subscriptionstypes->get($id, [
            'contain' => ['Subscriptions'],
        ]);

        $this->set(compact('subscriptionstype'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subscriptionstype = $this->Subscriptionstypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscriptionstype = $this->Subscriptionstypes->patchEntity($subscriptionstype, $this->request->getData());
            if ($this->Subscriptionstypes->save($subscriptionstype)) {
                $this->Flash->success(__('The subscriptionstype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriptionstype could not be saved. Please, try again.'));
        }
        $this->set(compact('subscriptionstype'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subscriptionstype id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subscriptionstype = $this->Subscriptionstypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscriptionstype = $this->Subscriptionstypes->patchEntity($subscriptionstype, $this->request->getData());
            if ($this->Subscriptionstypes->save($subscriptionstype)) {
                $this->Flash->success(__('The subscriptionstype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriptionstype could not be saved. Please, try again.'));
        }
        $this->set(compact('subscriptionstype'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscriptionstype id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subscriptionstype = $this->Subscriptionstypes->get($id);
        if ($this->Subscriptionstypes->delete($subscriptionstype)) {
            $this->Flash->success(__('The subscriptionstype has been deleted.'));
        } else {
            $this->Flash->error(__('The subscriptionstype could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
