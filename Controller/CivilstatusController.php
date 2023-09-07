<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Civilstatus Controller
 *
 * @property \App\Model\Table\CivilstatusTable $Civilstatus
 * @method \App\Model\Entity\Civilstatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CivilstatusController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $civilstatus = $this->paginate($this->Civilstatus);

        $this->set(compact('civilstatus'));
    }

    /**
     * View method
     *
     * @param string|null $id Civilstatus id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $civilstatus = $this->Civilstatus->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('civilstatus'));
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

        $civilstatus = $this->Civilstatus->newEmptyEntity();
        if ($this->request->is('post')) {
            $civilstatus = $this->Civilstatus->patchEntity($civilstatus, $this->request->getData());
            if ($this->Civilstatus->save($civilstatus)) {
                $this->Flash->success(__('The civilstatus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The civilstatus could not be saved. Please, try again.'));
        }
        $this->set(compact('civilstatus'));

    } else {
        return $this->redirect(['controller'=>'Users','action' => 'refuse']);
    }
    }

    /**
     * Edit method
     *
     * @param string|null $id Civilstatus id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $civilstatus = $this->Civilstatus->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $civilstatus = $this->Civilstatus->patchEntity($civilstatus, $this->request->getData());
            if ($this->Civilstatus->save($civilstatus)) {
                $this->Flash->success(__('The civilstatus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The civilstatus could not be saved. Please, try again.'));
        }
        $this->set(compact('civilstatus'));
        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Civilstatus id.
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
        $civilstatus = $this->Civilstatus->get($id);
        if ($this->Civilstatus->delete($civilstatus)) {
            $this->Flash->success(__('The civilstatus has been deleted.'));
        } else {
            $this->Flash->error(__('The civilstatus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }
}
