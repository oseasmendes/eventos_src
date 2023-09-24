<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Transactioncodes Controller
 *
 * @property \App\Model\Table\TransactioncodesTable $Transactioncodes
 * @method \App\Model\Entity\Transactioncode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactioncodesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $transactioncodes = $this->paginate($this->Transactioncodes);

        $this->set(compact('transactioncodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Transactioncode id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transactioncode = $this->Transactioncodes->get($id, [
            'contain' => ['Cashbookstransactions'],
        ]);

        $this->set(compact('transactioncode'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transactioncode = $this->Transactioncodes->newEmptyEntity();
        if ($this->request->is('post')) {
            $transactioncode = $this->Transactioncodes->patchEntity($transactioncode, $this->request->getData());
            if ($this->Transactioncodes->save($transactioncode)) {
                $this->Flash->success(__('The transactioncode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transactioncode could not be saved. Please, try again.'));
        }
        $this->set(compact('transactioncode'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transactioncode id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transactioncode = $this->Transactioncodes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transactioncode = $this->Transactioncodes->patchEntity($transactioncode, $this->request->getData());
            if ($this->Transactioncodes->save($transactioncode)) {
                $this->Flash->success(__('The transactioncode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transactioncode could not be saved. Please, try again.'));
        }
        $this->set(compact('transactioncode'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transactioncode id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transactioncode = $this->Transactioncodes->get($id);
        if ($this->Transactioncodes->delete($transactioncode)) {
            $this->Flash->success(__('The transactioncode has been deleted.'));
        } else {
            $this->Flash->error(__('The transactioncode could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
