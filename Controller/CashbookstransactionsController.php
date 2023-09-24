<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\Query;
/**
 * Cashbookstransactions Controller
 *
 * @property \App\Model\Table\CashbookstransactionsTable $Cashbookstransactions
 * @method \App\Model\Entity\Cashbookstransaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CashbookstransactionsController extends AppController
{

    public function initialize(): void
    {
         parent::initialize();
         $this->viewBuilder()->setLayout("admin");   
         
    }    


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rolevents', 'Bussinessunits', 'Transactioncodes', 'Finoperations'],
        ];

        
        $cashbookstransactions = $this->paginate($this->Cashbookstransactions);

        $cashins = $this->Cashbookstransactions->find();
        $totalcashin =$cashins->select(
                                        ['sumEntry' => $cashins->func()->sum('Cashbookstransactions.cashinflow'),
                                        'sumOut' => $cashins->func()->sum('Cashbookstransactions.cashoutflow')])->first();
        $sumcashin = $totalcashin->sumEntry;
        $sumcashout = $totalcashin->sumOut;
    

        $this->set(compact('cashbookstransactions','sumcashin','sumcashout'));
    }

    /**
     * View method
     *
     * @param string|null $id Cashbookstransaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cashbookstransaction = $this->Cashbookstransactions->get($id, [
            'contain' => ['Rolevents', 'Bussinessunits', 'Transactioncodes', 'Finoperations'],
        ]);

        $this->set(compact('cashbookstransaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cashbookstransaction = $this->Cashbookstransactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $cashbookstransaction = $this->Cashbookstransactions->patchEntity($cashbookstransaction, $this->request->getData());
            if ($this->Cashbookstransactions->save($cashbookstransaction)) {
                $this->Flash->success(__('The cashbookstransaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cashbookstransaction could not be saved. Please, try again.'));
        }
        $rolevents = $this->Cashbookstransactions->Rolevents->find('list', ['limit' => 200]);
        $bussinessunits = $this->Cashbookstransactions->Bussinessunits->find('list', ['limit' => 200]);
        $transactioncodes = $this->Cashbookstransactions->Transactioncodes->find('list', ['limit' => 200]);
        $finoperations = $this->Cashbookstransactions->Finoperations->find('list', ['limit' => 200]);
        $this->set(compact('cashbookstransaction', 'rolevents', 'bussinessunits', 'transactioncodes', 'finoperations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cashbookstransaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cashbookstransaction = $this->Cashbookstransactions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cashbookstransaction = $this->Cashbookstransactions->patchEntity($cashbookstransaction, $this->request->getData());
            if ($this->Cashbookstransactions->save($cashbookstransaction)) {
                $this->Flash->success(__('The cashbookstransaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cashbookstransaction could not be saved. Please, try again.'));
        }
        $rolevents = $this->Cashbookstransactions->Rolevents->find('list', ['limit' => 200]);
        $bussinessunits = $this->Cashbookstransactions->Bussinessunits->find('list', ['limit' => 200]);
        $transactioncodes = $this->Cashbookstransactions->Transactioncodes->find('list', ['limit' => 200]);
        $finoperations = $this->Cashbookstransactions->Finoperations->find('list', ['limit' => 200]);
        $this->set(compact('cashbookstransaction', 'rolevents', 'bussinessunits', 'transactioncodes', 'finoperations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cashbookstransaction id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cashbookstransaction = $this->Cashbookstransactions->get($id);
        if ($this->Cashbookstransactions->delete($cashbookstransaction)) {
            $this->Flash->success(__('The cashbookstransaction has been deleted.'));
        } else {
            $this->Flash->error(__('The cashbookstransaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
