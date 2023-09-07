<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
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

        $profileid = $this->request
            ->getAttribute('identity')
            ->get('profile_id');
        
        if (($roleid == 1) && ($profileid == 10)) {

        $roles = $this->paginate($this->Roles);

        $this->set(compact('roles'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
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
        
        if (($roleid == 1) && ($profileid == 10)) {


        $role = $this->Roles->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('role'));

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

        $profileid = $this->request
            ->getAttribute('identity')
            ->get('profile_id');
        
        if (($roleid == 1) && ($profileid == 10)) {


        $role = $this->Roles->newEmptyEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $this->set(compact('role'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
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
        
        if (($roleid == 1) && ($profileid == 10)) {

        $role = $this->Roles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $this->set(compact('role'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
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
        
        if (($roleid == 1) && ($profileid == 10)) {

        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);
        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }
}
