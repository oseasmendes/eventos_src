<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Unitsfederations Controller
 *
 * @property \App\Model\Table\UnitsfederationsTable $Unitsfederations
 * @method \App\Model\Entity\Unitsfederation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UnitsfederationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $unitsfederations = $this->paginate($this->Unitsfederations);

        $this->set(compact('unitsfederations'));
    }

    /**
     * View method
     *
     * @param string|null $id Unitsfederation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $unitsfederation = $this->Unitsfederations->get($id, [
            'contain' => ['Cities'],
        ]);

        $this->set(compact('unitsfederation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $unitsfederation = $this->Unitsfederations->newEmptyEntity();
        if ($this->request->is('post')) {
            $unitsfederation = $this->Unitsfederations->patchEntity($unitsfederation, $this->request->getData());
            if ($this->Unitsfederations->save($unitsfederation)) {
                $this->Flash->success(__('The unitsfederation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unitsfederation could not be saved. Please, try again.'));
        }
        $this->set(compact('unitsfederation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Unitsfederation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $unitsfederation = $this->Unitsfederations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $unitsfederation = $this->Unitsfederations->patchEntity($unitsfederation, $this->request->getData());
            if ($this->Unitsfederations->save($unitsfederation)) {
                $this->Flash->success(__('The unitsfederation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unitsfederation could not be saved. Please, try again.'));
        }
        $this->set(compact('unitsfederation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Unitsfederation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $unitsfederation = $this->Unitsfederations->get($id);
        if ($this->Unitsfederations->delete($unitsfederation)) {
            $this->Flash->success(__('The unitsfederation has been deleted.'));
        } else {
            $this->Flash->error(__('The unitsfederation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
