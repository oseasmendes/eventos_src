<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Subscriptionsconfs Controller
 *
 * @property \App\Model\Table\SubscriptionsconfsTable $Subscriptionsconfs
 * @method \App\Model\Entity\Subscriptionsconf[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscriptionsconfsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $this->paginate = [
            'contain' => ['Subscriptions', 'Users', 'People'],
        ];
        $subscriptionsconfs = $this->paginate($this->Subscriptionsconfs);

        $this->set(compact('subscriptionsconfs'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Subscriptionsconf id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $subscriptionsconf = $this->Subscriptionsconfs->get($id, [
            'contain' => ['Subscriptions', 'Users', 'People'],
        ]);

        $this->set(compact('subscriptionsconf'));

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
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $subscriptionsconf = $this->Subscriptionsconfs->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscriptionsconf = $this->Subscriptionsconfs->patchEntity($subscriptionsconf, $this->request->getData());
            if ($this->Subscriptionsconfs->save($subscriptionsconf)) {
                $this->Flash->success(__('The subscriptionsconf has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriptionsconf could not be saved. Please, try again.'));
        }
        $subscriptions = $this->Subscriptionsconfs->Subscriptions->find('list', ['limit' => 200]);
        $users = $this->Subscriptionsconfs->Users->find('list', ['limit' => 200]);
        $people = $this->Subscriptionsconfs->People->find('list', ['limit' => 200]);
        $this->set(compact('subscriptionsconf', 'subscriptions', 'users', 'people'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Subscriptionsconf id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {


        $subscriptionsconf = $this->Subscriptionsconfs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscriptionsconf = $this->Subscriptionsconfs->patchEntity($subscriptionsconf, $this->request->getData());
            if ($this->Subscriptionsconfs->save($subscriptionsconf)) {
                $this->Flash->success(__('The subscriptionsconf has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriptionsconf could not be saved. Please, try again.'));
        }
        $subscriptions = $this->Subscriptionsconfs->Subscriptions->find('list', ['limit' => 200]);
        $users = $this->Subscriptionsconfs->Users->find('list', ['limit' => 200]);
        $people = $this->Subscriptionsconfs->People->find('list', ['limit' => 200]);
        $this->set(compact('subscriptionsconf', 'subscriptions', 'users', 'people'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscriptionsconf id.
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
        $subscriptionsconf = $this->Subscriptionsconfs->get($id);
        if ($this->Subscriptionsconfs->delete($subscriptionsconf)) {
            $this->Flash->success(__('The subscriptionsconf has been deleted.'));
        } else {
            $this->Flash->error(__('The subscriptionsconf could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        
        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }
}
