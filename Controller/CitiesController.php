<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Unitsfederations'],
        ];
        $cities = $this->paginate($this->Cities);

        $this->set(compact('cities'));
    }

    /**
     * View method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $city = $this->Cities->get($id, [
            'contain' => ['Unitsfederations'],
        ]);

        $this->set(compact('city'));
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


        $city = $this->Cities->newEmptyEntity();
        if ($this->request->is('post')) {
            $city = $this->Cities->patchEntity($city, $this->request->getData());
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The city could not be saved. Please, try again.'));
        }
        $unitsfederations = $this->Cities->Unitsfederations->find('list', ['limit' => 200]);
        $this->set(compact('city', 'unitsfederations'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id City id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $city = $this->Cities->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $city = $this->Cities->patchEntity($city, $this->request->getData());
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('The city has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The city could not be saved. Please, try again.'));
        }
        $unitsfederations = $this->Cities->Unitsfederations->find('list', ['limit' => 200]);
        $this->set(compact('city', 'unitsfederations'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id City id.
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
        $city = $this->Cities->get($id);
        if ($this->Cities->delete($city)) {
            $this->Flash->success(__('The city has been deleted.'));
        } else {
            $this->Flash->error(__('The city could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }
}
