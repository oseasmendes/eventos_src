<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Paymentmethods Controller
 *
 * @property \App\Model\Table\PaymentmethodsTable $Paymentmethods
 * @method \App\Model\Entity\Paymentmethod[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentmethodsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $paymentmethods = $this->paginate($this->Paymentmethods);

        $this->set(compact('paymentmethods'));
    }

    /**
     * View method
     *
     * @param string|null $id Paymentmethod id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $paymentmethod = $this->Paymentmethods->get($id, [
            'contain' => ['Finentryinvoices'],
        ]);

        $this->set(compact('paymentmethod'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $paymentmethod = $this->Paymentmethods->newEmptyEntity();
        if ($this->request->is('post')) {
            $paymentmethod = $this->Paymentmethods->patchEntity($paymentmethod, $this->request->getData());
            if ($this->Paymentmethods->save($paymentmethod)) {
                $this->Flash->success(__('The paymentmethod has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The paymentmethod could not be saved. Please, try again.'));
        }
        $this->set(compact('paymentmethod'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Paymentmethod id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $paymentmethod = $this->Paymentmethods->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymentmethod = $this->Paymentmethods->patchEntity($paymentmethod, $this->request->getData());
            if ($this->Paymentmethods->save($paymentmethod)) {
                $this->Flash->success(__('The paymentmethod has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The paymentmethod could not be saved. Please, try again.'));
        }
        $this->set(compact('paymentmethod'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Paymentmethod id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $paymentmethod = $this->Paymentmethods->get($id);
        if ($this->Paymentmethods->delete($paymentmethod)) {
            $this->Flash->success(__('The paymentmethod has been deleted.'));
        } else {
            $this->Flash->error(__('The paymentmethod could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
