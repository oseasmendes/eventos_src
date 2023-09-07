<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Doctypes Controller
 *
 * @property \App\Model\Table\DoctypesTable $Doctypes
 * @method \App\Model\Entity\Doctype[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DoctypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $doctypes = $this->paginate($this->Doctypes);

        $this->set(compact('doctypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Doctype id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $doctype = $this->Doctypes->get($id, [
            'contain' => ['Subscriptionsdocs'],
        ]);

        $this->set(compact('doctype'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $doctype = $this->Doctypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $doctype = $this->Doctypes->patchEntity($doctype, $this->request->getData());
            if ($this->Doctypes->save($doctype)) {
                $this->Flash->success(__('The doctype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The doctype could not be saved. Please, try again.'));
        }
        $this->set(compact('doctype'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Doctype id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $doctype = $this->Doctypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $doctype = $this->Doctypes->patchEntity($doctype, $this->request->getData());
            if ($this->Doctypes->save($doctype)) {
                $this->Flash->success(__('The doctype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The doctype could not be saved. Please, try again.'));
        }
        $this->set(compact('doctype'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Doctype id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $doctype = $this->Doctypes->get($id);
        if ($this->Doctypes->delete($doctype)) {
            $this->Flash->success(__('The doctype has been deleted.'));
        } else {
            $this->Flash->error(__('The doctype could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
