<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\Query;
/**
 * Finentryinvoices Controller
 *
 * @property \App\Model\Table\FinentryinvoicesTable $Finentryinvoices
 * @method \App\Model\Entity\Finentryinvoice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FinentryinvoicesController extends AppController
{


    public function initialize(): void
    {
         parent::initialize();
       $this->viewBuilder()->setLayout("admin");    
         $this->loadModel('Cashbookstransactions'); 
        
        
         
    }    

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rolevents', 'Paymentmethods', 'Bussinessunits', 'Finoperations', 'Docstatus', 'Suppliers', 'Users'],
        ];
        $finentryinvoices = $this->paginate($this->Finentryinvoices);

        $this->set(compact('finentryinvoices'));
    }

    /**
     * View method
     *
     * @param string|null $id Finentryinvoice id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $finentryinvoice = $this->Finentryinvoices->get($id, [
            'contain' => ['Rolevents', 'Paymentmethods', 'Bussinessunits', 'Finoperations', 'Docstatus', 'Suppliers', 'Users', 'Finentryinvoicesdetails'],
        ]);

        $this->set(compact('finentryinvoice'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $finentryinvoice = $this->Finentryinvoices->newEmptyEntity();
        if ($this->request->is('post')) {
            $finentryinvoice = $this->Finentryinvoices->patchEntity($finentryinvoice, $this->request->getData());
            if ($this->Finentryinvoices->save($finentryinvoice)) {

                $cashbook = $this->Cashbookstransactions->newEmptyEntity();

                $cashbook->rolevent_id =  $finentryinvoice->rolevent_id;
                $cashbook->bussinessunit_id =  $finentryinvoice->bussinessunit_id;
                $cashbook->finoperation_id =  $finentryinvoice->finoperation_id;                
                $cashbook->date =  $finentryinvoice->entrydate;
                $cashbook->documentreference = $finentryinvoice->number;
                $cashbook->transactionid = $finentryinvoice->id;
                $cashbook->transactioncode_id = 2;
                $cashbook->originalinvoiceamount = $finentryinvoice->totalamount;
                $cashbook->cashoutflow = ($finentryinvoice->totalamount)*-1;    
                $cashbook->cashinflow = 0;    
                $cashbook->description = $finentryinvoice->shortdescription;    
                
                $cashbook->transactiontype = "S";
                $this->Cashbookstransactions->save($cashbook);                

                $this->Flash->success(__('The finentryinvoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finentryinvoice could not be saved. Please, try again.'));
        }
        $rolevents = $this->Finentryinvoices->Rolevents->find('list', ['limit' => 200]);        
        $bussinessunits = $this->Finentryinvoices->Bussinessunits->find('list', ['limit' => 200]);       
        
        $finoperations = $this->Finentryinvoices->Finoperations->find('list',array('conditions'=>array('Finoperations.entryout LIKE '=>'S'),
                                                            'order' => array('Finoperations.description' => 'asc')));
        $paymentmethods = $this->Finentryinvoices->Paymentmethods->find('list',array('conditions'=>array('Paymentmethods.entryout LIKE '=>'S'),
                                                                'order' => array('Paymentmethods.description' => 'asc')));        

        $docstatus = $this->Finentryinvoices->Docstatus->find('list', ['limit' => 200]);
        $suppliers = $this->Finentryinvoices->Suppliers->find('list', ['limit' => 200]);
        $users = $this->Finentryinvoices->Users->find('list', ['limit' => 200]);
        $this->set(compact('finentryinvoice', 'rolevents', 'paymentmethods', 'bussinessunits', 'finoperations', 'docstatus', 'suppliers', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Finentryinvoice id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $finentryinvoice = $this->Finentryinvoices->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $finentryinvoice = $this->Finentryinvoices->patchEntity($finentryinvoice, $this->request->getData());
            if ($this->Finentryinvoices->save($finentryinvoice)) {

                $query = $this->Cashbookstransactions->find('all', [
                    'conditions' => ['Cashbookstransactions.transactionid' => $id ],  
                ]);
                $row = $query->first();
                
                $cashbookTable = TableRegistry::getTableLocator()->get('Cashbookstransactions');
                $cashbook = $cashbookTable->get($row->id);

                $cashbook->rolevent_id =  $finentryinvoice->rolevent_id;
                $cashbook->bussinessunit_id =  $finentryinvoice->bussinessunit_id;
                $cashbook->finoperation_id =  $finentryinvoice->finoperation_id;                
                $cashbook->date =  $finentryinvoice->entrydate;
                $cashbook->documentreference = $finentryinvoice->number;
                $cashbook->transactionid = $finentryinvoice->id;
                $cashbook->originalinvoiceamount = $finentryinvoice->amount;
                $cashbook->transactioncode_id = 2;
                $cashbook->cashoutflow = ($finentryinvoice->amount)*-1;    
                $cashbook->cashinflow = 0;    
                $cashbook->description = $finentryinvoice->shortdescription;    
                
                $cashbook->transactiontype = "S";
                $this->Cashbookstransactions->save($cashbook);                


                $this->Flash->success(__('The finentryinvoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finentryinvoice could not be saved. Please, try again.'));
        }
        $rolevents = $this->Finentryinvoices->Rolevents->find('list', ['limit' => 200]);        
        $bussinessunits = $this->Finentryinvoices->Bussinessunits->find('list', ['limit' => 200]);

        $finoperations = $this->Finentryinvoices->Finoperations->find('list',array('conditions'=>array('Finoperations.entryout LIKE '=>'S'),
                                                            'order' => array('Finoperations.description' => 'asc')));
        $paymentmethods = $this->Finentryinvoices->Paymentmethods->find('list',array('conditions'=>array('Paymentmethods.entryout LIKE '=>'S'),
                                                                'order' => array('Paymentmethods.description' => 'asc')));
        
        $docstatus = $this->Finentryinvoices->Docstatus->find('list', ['limit' => 200]);
        $suppliers = $this->Finentryinvoices->Suppliers->find('list', ['limit' => 200]);
        $users = $this->Finentryinvoices->Users->find('list', ['limit' => 200]);
        $this->set(compact('finentryinvoice', 'rolevents', 'paymentmethods', 'bussinessunits', 'finoperations', 'docstatus', 'suppliers', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Finentryinvoice id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $finentryinvoice = $this->Finentryinvoices->get($id);
        if ($this->Finentryinvoices->delete($finentryinvoice)) {

            $query = $this->Cashbookstransactions->find('all', [
                'conditions' => ['Cashbookstransactions.transactionid' => $id ],  
            ]);
            $row = $query->first();
            
            $cashbookTable = TableRegistry::getTableLocator()->get('Cashbookstransactions');
            $cashbook = $cashbookTable->get($row->id);

            $cashbook->rolevent_id =  $finentryinvoice->rolevent_id;
            $cashbook->bussinessunit_id =  $finentryinvoice->bussinessunit_id;
            $cashbook->finoperation_id =  $finentryinvoice->finoperation_id;                
            $cashbook->date =  $finentryinvoice->entrydate;
            $cashbook->documentreference = $finentryinvoice->number;
            $cashbook->transactionid = $finentryinvoice->id;
            $cashbook->originalinvoiceamount = $finentryinvoice->amount;
            $cashbook->transactioncode_id = 12;
            $cashbook->cashoutflow = 0;
            $cashbook->cashinflow = $finentryinvoice->amount;       
            $cashbook->description = $finentryinvoice->shortdescription;    
            
            $cashbook->transactiontype = "S";
            $this->Cashbookstransactions->delete($cashbook);                



            $this->Flash->success(__('The finentryinvoice has been deleted.'));
        } else {
            $this->Flash->error(__('The finentryinvoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
