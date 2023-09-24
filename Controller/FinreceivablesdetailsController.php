<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Finreceivablesdetails Controller
 *
 * @property \App\Model\Table\FinreceivablesdetailsTable $Finreceivablesdetails
 * @method \App\Model\Entity\Finreceivablesdetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FinreceivablesdetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Finreceivables', 'Items'],
        ];
        $finreceivablesdetails = $this->paginate($this->Finreceivablesdetails);

        $this->set(compact('finreceivablesdetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Finreceivablesdetail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $finreceivablesdetail = $this->Finreceivablesdetails->get($id, [
            'contain' => ['Finreceivables', 'Items'],
        ]);

        $this->set(compact('finreceivablesdetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $finreceivablesdetail = $this->Finreceivablesdetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $finreceivablesdetail = $this->Finreceivablesdetails->patchEntity($finreceivablesdetail, $this->request->getData());
            if ($this->Finreceivablesdetails->save($finreceivablesdetail)) {
                $this->Flash->success(__('The finreceivablesdetail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finreceivablesdetail could not be saved. Please, try again.'));
        }
        $finreceivables = $this->Finreceivablesdetails->Finreceivables->find('list', ['limit' => 200]);
        $items = $this->Finreceivablesdetails->Items->find('list', ['limit' => 200]);
        $this->set(compact('finreceivablesdetail', 'finreceivables', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Finreceivablesdetail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $finreceivablesdetail = $this->Finreceivablesdetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $finreceivablesdetail = $this->Finreceivablesdetails->patchEntity($finreceivablesdetail, $this->request->getData());
            if ($this->Finreceivablesdetails->save($finreceivablesdetail)) {
                $this->Flash->success(__('The finreceivablesdetail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finreceivablesdetail could not be saved. Please, try again.'));
        }
        $finreceivables = $this->Finreceivablesdetails->Finreceivables->find('list', ['limit' => 200]);
        $items = $this->Finreceivablesdetails->Items->find('list', ['limit' => 200]);
        $this->set(compact('finreceivablesdetail', 'finreceivables', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Finreceivablesdetail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $finreceivablesdetail = $this->Finreceivablesdetails->get($id);
        if ($this->Finreceivablesdetails->delete($finreceivablesdetail)) {
            $this->Flash->success(__('The finreceivablesdetail has been deleted.'));
        } else {
            $this->Flash->error(__('The finreceivablesdetail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
