<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Sysadmins Controller
 *
 * @property \App\Model\Table\SysadminsTable $Sysadmins
 * @method \App\Model\Entity\Sysadmin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SysadminsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles', 'Profiles', 'Sysactions', 'Syscontrols', 'Sysapps'],
        ];
        $sysadmins = $this->paginate($this->Sysadmins);

        $this->set(compact('sysadmins'));
    }

    /**
     * View method
     *
     * @param string|null $id Sysadmin id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sysadmin = $this->Sysadmins->get($id, [
            'contain' => ['Roles', 'Profiles', 'Sysactions', 'Syscontrols', 'Sysapps'],
        ]);

        $this->set(compact('sysadmin'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sysadmin = $this->Sysadmins->newEmptyEntity();
        if ($this->request->is('post')) {
            $sysadmin = $this->Sysadmins->patchEntity($sysadmin, $this->request->getData());
            if ($this->Sysadmins->save($sysadmin)) {
                $this->Flash->success(__('The sysadmin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sysadmin could not be saved. Please, try again.'));
        }
        $roles = $this->Sysadmins->Roles->find('list', ['limit' => 200]);
        $profiles = $this->Sysadmins->Profiles->find('list', ['limit' => 200]);
        $sysactions = $this->Sysadmins->Sysactions->find('list', ['limit' => 200]);
        $syscontrols = $this->Sysadmins->Syscontrols->find('list', ['limit' => 200]);
        $sysapps = $this->Sysadmins->Sysapps->find('list', ['limit' => 200]);
        $this->set(compact('sysadmin', 'roles', 'profiles', 'sysactions', 'syscontrols', 'sysapps'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sysadmin id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sysadmin = $this->Sysadmins->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sysadmin = $this->Sysadmins->patchEntity($sysadmin, $this->request->getData());
            if ($this->Sysadmins->save($sysadmin)) {
                $this->Flash->success(__('The sysadmin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sysadmin could not be saved. Please, try again.'));
        }
        $roles = $this->Sysadmins->Roles->find('list', ['limit' => 200]);
        $profiles = $this->Sysadmins->Profiles->find('list', ['limit' => 200]);
        $sysactions = $this->Sysadmins->Sysactions->find('list', ['limit' => 200]);
        $syscontrols = $this->Sysadmins->Syscontrols->find('list', ['limit' => 200]);
        $sysapps = $this->Sysadmins->Sysapps->find('list', ['limit' => 200]);
        $this->set(compact('sysadmin', 'roles', 'profiles', 'sysactions', 'syscontrols', 'sysapps'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sysadmin id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sysadmin = $this->Sysadmins->get($id);
        if ($this->Sysadmins->delete($sysadmin)) {
            $this->Flash->success(__('The sysadmin has been deleted.'));
        } else {
            $this->Flash->error(__('The sysadmin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
