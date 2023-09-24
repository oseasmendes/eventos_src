<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Finoperations Controller
 *
 * @property \App\Model\Table\FinoperationsTable $Finoperations
 * @method \App\Model\Entity\Finoperation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FinoperationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $finoperations = $this->paginate($this->Finoperations);

        $this->set(compact('finoperations'));
    }

    /**
     * View method
     *
     * @param string|null $id Finoperation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $finoperation = $this->Finoperations->get($id, [
            'contain' => ['Finentryinvoices'],
        ]);

        $this->set(compact('finoperation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $finoperation = $this->Finoperations->newEmptyEntity();
        if ($this->request->is('post')) {
            $finoperation = $this->Finoperations->patchEntity($finoperation, $this->request->getData());
            if ($this->Finoperations->save($finoperation)) {
                $this->Flash->success(__('The finoperation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finoperation could not be saved. Please, try again.'));
        }
        $this->set(compact('finoperation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Finoperation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $finoperation = $this->Finoperations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $finoperation = $this->Finoperations->patchEntity($finoperation, $this->request->getData());
            if ($this->Finoperations->save($finoperation)) {
                $this->Flash->success(__('The finoperation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finoperation could not be saved. Please, try again.'));
        }
        $this->set(compact('finoperation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Finoperation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $finoperation = $this->Finoperations->get($id);
        if ($this->Finoperations->delete($finoperation)) {
            $this->Flash->success(__('The finoperation has been deleted.'));
        } else {
            $this->Flash->error(__('The finoperation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
