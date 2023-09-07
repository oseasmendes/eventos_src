<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Roleventschannels Controller
 *
 * @property \App\Model\Table\RoleventschannelsTable $Roleventschannels
 * @method \App\Model\Entity\Roleventschannel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoleventschannelsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rolevents'],
        ];
        $roleventschannels = $this->paginate($this->Roleventschannels);

        $this->set(compact('roleventschannels'));
    }

    /**
     * View method
     *
     * @param string|null $id Roleventschannel id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roleventschannel = $this->Roleventschannels->get($id, [
            'contain' => ['Rolevents'],
        ]);

        $this->set(compact('roleventschannel'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roleventschannel = $this->Roleventschannels->newEmptyEntity();
        if ($this->request->is('post')) {
            $roleventschannel = $this->Roleventschannels->patchEntity($roleventschannel, $this->request->getData());
            if ($this->Roleventschannels->save($roleventschannel)) {
                $this->Flash->success(__('The roleventschannel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The roleventschannel could not be saved. Please, try again.'));
        }
        $rolevents = $this->Roleventschannels->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('roleventschannel', 'rolevents'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Roleventschannel id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roleventschannel = $this->Roleventschannels->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roleventschannel = $this->Roleventschannels->patchEntity($roleventschannel, $this->request->getData());
            if ($this->Roleventschannels->save($roleventschannel)) {
                $this->Flash->success(__('The roleventschannel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The roleventschannel could not be saved. Please, try again.'));
        }
        $rolevents = $this->Roleventschannels->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('roleventschannel', 'rolevents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Roleventschannel id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $roleventschannel = $this->Roleventschannels->get($id);
        if ($this->Roleventschannels->delete($roleventschannel)) {
            $this->Flash->success(__('The roleventschannel has been deleted.'));
        } else {
            $this->Flash->error(__('The roleventschannel could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
