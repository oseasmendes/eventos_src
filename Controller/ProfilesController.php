<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Profiles Controller
 *
 * @property \App\Model\Table\ProfilesTable $Profiles
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfilesController extends AppController
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

        $profiles = $this->paginate($this->Profiles);

        $this->set(compact('profiles'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Profile id.
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


        $profile = $this->Profiles->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('profile'));

        
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

        $profile = $this->Profiles->newEmptyEntity();

                if ($this->request->is('post')) {
                    $profile = $this->Profiles->patchEntity($profile, $this->request->getData());
                    if ($this->Profiles->save($profile)) {
                        $this->Flash->success(__('The profile has been saved.'));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('The profile could not be saved. Please, try again.'));
                }
                $this->set(compact('profile'));
            
        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Profile id.
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

        if (($roleid == 1) && ($profileid == 10))  {

        $profile = $this->Profiles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $profile = $this->Profiles->patchEntity($profile, $this->request->getData());
            if ($this->Profiles->save($profile)) {
                $this->Flash->success(__('The profile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The profile could not be saved. Please, try again.'));
        }
        $this->set(compact('profile'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Profile id.
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
        $profile = $this->Profiles->get($id);
        if ($this->Profiles->delete($profile)) {
            $this->Flash->success(__('The profile has been deleted.'));
        } else {
            $this->Flash->error(__('The profile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }
}
