<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\Query;


/**
 * Finreceivables Controller
 *
 * @property \App\Model\Table\FinreceivablesTable $Finreceivables
 * @method \App\Model\Entity\Finreceivable[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FinreceivablesController extends AppController
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
            'contain' => ['Bussinessunits', 'Rolevents', 'Finoperations', 'Paymentmethods', 'Docstatus', 'Peoples', 'Users'],
        ];
        $finreceivables = $this->paginate($this->Finreceivables);

        $this->set(compact('finreceivables'));
    }

    /**
     * View method
     *
     * @param string|null $id Finreceivable id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $finreceivable = $this->Finreceivables->get($id, [
            'contain' => ['Bussinessunits', 'Rolevents', 'Finoperations', 'Paymentmethods', 'Docstatus', 'People', 'Users', 'Finreceivablesdetails'],
        ]);

        $this->set(compact('finreceivable'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $finreceivable = $this->Finreceivables->newEmptyEntity();
        if ($this->request->is('post')) {
            $finreceivable = $this->Finreceivables->patchEntity($finreceivable, $this->request->getData());
            if ($this->Finreceivables->save($finreceivable)) {


                $cashbook = $this->Cashbookstransactions->newEmptyEntity();

                $cashbook->rolevent_id =  $finreceivable->rolevent_id;
                $cashbook->bussinessunit_id =  $finreceivable->bussinessunit_id;
                $cashbook->finoperation_id =  $finreceivable->finoperation_id;                
                $cashbook->date =  $finreceivable->receivabledate;
                $cashbook->documentreference = $finreceivable->reference;
                $cashbook->transactionid = $finreceivable->id;
                $cashbook->originalinvoiceamount = $finreceivable->totalamount;
                $cashbook->cashinflow = $finreceivable->totalamount;    
                $cashbook->cashoutflow = 0;    
                $cashbook->description =  $finreceivable->shortdescription;  
                $cashbook->transactiontype = "E";
                $this->Cashbookstransactions->save($cashbook);        




                $this->Flash->success(__('The finreceivable has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finreceivable could not be saved. Please, try again.'));
        }
        $bussinessunits = $this->Finreceivables->Bussinessunits->find('list', ['limit' => 200]);
        $rolevents = $this->Finreceivables->Rolevents->find('list', ['limit' => 200]);
        $finoperations = $this->Finreceivables->Finoperations->find('list',array('conditions'=>array('Finoperations.entryout LIKE '=>'E'),
                                                            'order' => array('Finoperations.description' => 'asc')));
        $paymentmethods = $this->Finreceivables->Paymentmethods->find('list',array('conditions'=>array('Paymentmethods.entryout LIKE '=>'E'),
                                                                'order' => array('Paymentmethods.description' => 'asc')));
        $docstatus = $this->Finreceivables->Docstatus->find('list', ['limit' => 200]);
        $people = $this->Finreceivables->Peoples->find('list', ['limit' => 200]);
        $users = $this->Finreceivables->Users->find('list', ['limit' => 200]);
        $this->set(compact('finreceivable', 'bussinessunits', 'rolevents', 'finoperations', 'paymentmethods', 'docstatus', 'people', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Finreceivable id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $finreceivable = $this->Finreceivables->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $finreceivable = $this->Finreceivables->patchEntity($finreceivable, $this->request->getData());
            if ($this->Finreceivables->save($finreceivable)) {

                $query = $this->Cashbookstransactions->find('all', [
                    'conditions' => ['Cashbookstransactions.transactionid' => $id ],  
                ]);
                $row = $query->first();

                $cashbookTable = TableRegistry::getTableLocator()->get('Cashbookstransactions');
                $cashbook = $cashbookTable->get($row->id);

                $cashbook->rolevent_id =  $finreceivable->rolevent_id;
                $cashbook->bussinessunit_id =  $finreceivable->bussinessunit_id;
                $cashbook->finoperation_id =  $finreceivable->finoperation_id;                
                $cashbook->date =  $finreceivable->receivabledate;
                $cashbook->documentreference = $finreceivable->reference;
                $cashbook->transactionid = $finreceivable->id;
                $cashbook->originalinvoiceamount = $finreceivable->amount;
                $cashbook->cashinflow = $finreceivable->amount;    
                $cashbook->cashoutflow = 0;    
                $cashbook->description =  $finreceivable->shortdescription;  
                $cashbook->transactiontype = "E";
                $this->Cashbookstransactions->save($cashbook);        


                $this->Flash->success(__('The finreceivable has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finreceivable could not be saved. Please, try again.'));
        }
        $bussinessunits = $this->Finreceivables->Bussinessunits->find('list', ['limit' => 200]);
        $rolevents = $this->Finreceivables->Rolevents->find('list', ['limit' => 200]);

        $finoperations = $this->Finreceivables->Finoperations->find('list',array('conditions'=>array('Finoperations.entryout LIKE '=>'E'),
                                                            'order' => array('Finoperations.description' => 'asc')));
        $paymentmethods = $this->Finreceivables->Paymentmethods->find('list',array('conditions'=>array('Paymentmethods.entryout LIKE '=>'E'),
                                                                'order' => array('Paymentmethods.description' => 'asc')));
        
        
        $docstatus = $this->Finreceivables->Docstatus->find('list', ['limit' => 200]);
        $people = $this->Finreceivables->Peoples->find('list', ['limit' => 200]);
        $users = $this->Finreceivables->Users->find('list', ['limit' => 200]);
        $this->set(compact('finreceivable', 'bussinessunits', 'rolevents', 'finoperations', 'paymentmethods', 'docstatus', 'people', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Finreceivable id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $finreceivable = $this->Finreceivables->get($id);
        if ($this->Finreceivables->delete($finreceivable)) {

            $query = $this->Cashbookstransactions->find('all', [
                'conditions' => ['Cashbookstransactions.transactionid' => $id ],  
            ]);
            $row = $query->first();

            $cashbookTable = TableRegistry::getTableLocator()->get('Cashbookstransactions');
            $cashbook = $cashbookTable->get($row->id);

            $cashbook->rolevent_id =  $finreceivable->rolevent_id;
            $cashbook->bussinessunit_id =  $finreceivable->bussinessunit_id;
            $cashbook->finoperation_id =  $finreceivable->finoperation_id;                
            $cashbook->date =  $finreceivable->receivabledate;
            $cashbook->documentreference = $finreceivable->reference;
            $cashbook->transactionid = $finreceivable->id;
            $cashbook->originalinvoiceamount = $finreceivable->amount;
            $cashbook->cashinflow = $finreceivable->amount;    
            $cashbook->cashoutflow = 0;    
            $cashbook->description =  $finreceivable->shortdescription;  
            $cashbook->transactiontype = "E";
            $this->Cashbookstransactions->delete($cashbook);        


            $this->Flash->success(__('The finreceivable has been deleted.'));
        } else {
            $this->Flash->error(__('The finreceivable could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
