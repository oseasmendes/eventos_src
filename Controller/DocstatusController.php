<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Docstatus Controller
 *
 * @property \App\Model\Table\DocstatusTable $Docstatus
 * @method \App\Model\Entity\Docstatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocstatusController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $docstatus = $this->paginate($this->Docstatus);

        $this->set(compact('docstatus'));
    }

    /**
     * View method
     *
     * @param string|null $id Docstatus id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $docstatus = $this->Docstatus->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('docstatus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $docstatus = $this->Docstatus->newEmptyEntity();
        if ($this->request->is('post')) {
            $docstatus = $this->Docstatus->patchEntity($docstatus, $this->request->getData());
            if ($this->Docstatus->save($docstatus)) {
                $this->Flash->success(__('The docstatus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The docstatus could not be saved. Please, try again.'));
        }
        $this->set(compact('docstatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Docstatus id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $docstatus = $this->Docstatus->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $docstatus = $this->Docstatus->patchEntity($docstatus, $this->request->getData());
            if ($this->Docstatus->save($docstatus)) {
                $this->Flash->success(__('The docstatus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The docstatus could not be saved. Please, try again.'));
        }
        $this->set(compact('docstatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Docstatus id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $docstatus = $this->Docstatus->get($id);
        if ($this->Docstatus->delete($docstatus)) {
            $this->Flash->success(__('The docstatus has been deleted.'));
        } else {
            $this->Flash->error(__('The docstatus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
