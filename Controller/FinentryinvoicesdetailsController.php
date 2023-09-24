<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Finentryinvoicesdetails Controller
 *
 * @property \App\Model\Table\FinentryinvoicesdetailsTable $Finentryinvoicesdetails
 * @method \App\Model\Entity\Finentryinvoicesdetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FinentryinvoicesdetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Finentryinvoices', 'Items'],
        ];
        $finentryinvoicesdetails = $this->paginate($this->Finentryinvoicesdetails);

        $this->set(compact('finentryinvoicesdetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Finentryinvoicesdetail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $finentryinvoicesdetail = $this->Finentryinvoicesdetails->get($id, [
            'contain' => ['Finentryinvoices', 'Items'],
        ]);

        $this->set(compact('finentryinvoicesdetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $finentryinvoicesdetail = $this->Finentryinvoicesdetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $finentryinvoicesdetail = $this->Finentryinvoicesdetails->patchEntity($finentryinvoicesdetail, $this->request->getData());
            if ($this->Finentryinvoicesdetails->save($finentryinvoicesdetail)) {
                $this->Flash->success(__('The finentryinvoicesdetail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finentryinvoicesdetail could not be saved. Please, try again.'));
        }
        $finentryinvoices = $this->Finentryinvoicesdetails->Finentryinvoices->find('list', ['limit' => 200]);
        $items = $this->Finentryinvoicesdetails->Items->find('list', ['limit' => 200]);
        $this->set(compact('finentryinvoicesdetail', 'finentryinvoices', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Finentryinvoicesdetail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $finentryinvoicesdetail = $this->Finentryinvoicesdetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $finentryinvoicesdetail = $this->Finentryinvoicesdetails->patchEntity($finentryinvoicesdetail, $this->request->getData());
            if ($this->Finentryinvoicesdetails->save($finentryinvoicesdetail)) {
                $this->Flash->success(__('The finentryinvoicesdetail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finentryinvoicesdetail could not be saved. Please, try again.'));
        }
        $finentryinvoices = $this->Finentryinvoicesdetails->Finentryinvoices->find('list', ['limit' => 200]);
        $items = $this->Finentryinvoicesdetails->Items->find('list', ['limit' => 200]);
        $this->set(compact('finentryinvoicesdetail', 'finentryinvoices', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Finentryinvoicesdetail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $finentryinvoicesdetail = $this->Finentryinvoicesdetails->get($id);
        if ($this->Finentryinvoicesdetails->delete($finentryinvoicesdetail)) {
            $this->Flash->success(__('The finentryinvoicesdetail has been deleted.'));
        } else {
            $this->Flash->error(__('The finentryinvoicesdetail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
