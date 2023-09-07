<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Roleventfiles Controller
 *
 * @property \App\Model\Table\RoleventfilesTable $Roleventfiles
 * @method \App\Model\Entity\Roleventfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoleventfilesController extends AppController
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
        $roleventfiles = $this->paginate($this->Roleventfiles);

        $this->set(compact('roleventfiles'));
    }

    /**
     * View method
     *
     * @param string|null $id Roleventfile id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roleventfile = $this->Roleventfiles->get($id, [
            'contain' => ['Rolevents'],
        ]);

        $this->set(compact('roleventfile'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roleventfile = $this->Roleventfiles->newEmptyEntity();
        if ($this->request->is('post')) {
            $roleventfile = $this->Roleventfiles->patchEntity($roleventfile, $this->request->getData());
            if ($this->Roleventfiles->save($roleventfile)) {
                $this->Flash->success(__('The roleventfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The roleventfile could not be saved. Please, try again.'));
        }
        $rolevents = $this->Roleventfiles->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('roleventfile', 'rolevents'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Roleventfile id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roleventfile = $this->Roleventfiles->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roleventfile = $this->Roleventfiles->patchEntity($roleventfile, $this->request->getData());
            if ($this->Roleventfiles->save($roleventfile)) {
                $this->Flash->success(__('The roleventfile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The roleventfile could not be saved. Please, try again.'));
        }
        $rolevents = $this->Roleventfiles->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('roleventfile', 'rolevents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Roleventfile id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $roleventfile = $this->Roleventfiles->get($id);
        if ($this->Roleventfiles->delete($roleventfile)) {
            $this->Flash->success(__('The roleventfile has been deleted.'));
        } else {
            $this->Flash->error(__('The roleventfile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
