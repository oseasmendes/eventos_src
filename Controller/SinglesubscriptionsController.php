<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Singlesubscriptions Controller
 *
 * @property \App\Model\Table\SinglesubscriptionsTable $Singlesubscriptions
 * @method \App\Model\Entity\Singlesubscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SinglesubscriptionsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->allowUnauthenticated(['addid','view']);
    }

    public function initialize(): void
    {
         parent::initialize();   
         $this->viewBuilder()->setLayout("newslight"); 
         $this->loadComponent('Rlevent'); 
         $this->loadComponent('Peopl'); 
         
    }    


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        
        
        
        $keyword = $this->request->getQueryParams('description');


        if (!empty($keyword['description'])) {       
            
            $this->paginate = [
                'contain' => ['Rolevents', 'Bussinessunits', 'Subscriptions', 'Peoples'],
                'conditions' => [
                    'Singlesubscriptions.fullname LIKE'=> '%'.$keyword['description'].'%',
                    ],             
                'order' => [                        
                'Singlesubscriptions.fullname' => 'asc'
                    ]            
            ];

            $singlesubscriptions = $this->paginate($this->Singlesubscriptions);

        } elseif(!empty($keyword['bussinessunit_id'])) {    

            $this->paginate = [ 
                'contain' => ['Rolevents', 'Bussinessunits', 'Subscriptions', 'Peoples'],                       
                'conditions' => [
                        'Singlesubscriptions.bussinessunit_id ='=> $keyword['bussinessunit_id'],                       
                        ],             
                'order' => ['Singlesubscriptions.fullname' => 'asc']            
            ];

            $singlesubscriptions = $this->paginate($this->Singlesubscriptions);


        } else {

            $this->paginate = [
                'contain' => ['Rolevents', 'Bussinessunits', 'Subscriptions', 'Peoples'],
                'conditions' => [
                    'Singlesubscriptions.statusflag LIKE'=> 'GERADA_COM_SUCESSO',
                    ],             
                'order' => [                        
                'Singlesubscriptions.fullname' => 'asc'
                    ]            
            ];

            $singlesubscriptions = $this->paginate($this->Singlesubscriptions);
        }
        
        $rolevents = $this->Singlesubscriptions->Rolevents->find('list', ['limit' => 200]);
        $bussinessunits = $this->Singlesubscriptions->Bussinessunits->find('list',array('conditions'=>array('Bussinessunits.org_id'=>1),'order' => array('Bussinessunits.seq' => 'asc','Bussinessunits.description' => 'asc')));


        $this->set(compact('singlesubscriptions', 'bussinessunits','rolevents'));
    }

    /**
     * View method
     *
     * @param string|null $id Singlesubscription id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $singlesubscription = $this->Singlesubscriptions->get($id, [
            'contain' => ['Rolevents', 'Bussinessunits'],
        ]);

        $this->set(compact('singlesubscription'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $singlesubscription = $this->Singlesubscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $singlesubscription = $this->Singlesubscriptions->patchEntity($singlesubscription, $this->request->getData());
            
            $eventoref = $this->Rlevent->findroleventsbyid($singlesubscription->rolevent_id);
            $singlesubscription->price = $eventoref->price;
            $personref = $this->Peopl->findpeopleidbydoc($singlesubscription->documentnumber);
            $singlesubscription->people_id = $personref;   
            $persondata = $this->Peopl->findallpeoplebypeopleid($personref);
            $singlesubscription->originid = $persondata->originid;
            
            if ($this->Singlesubscriptions->save($singlesubscription)) {
                $this->Flash->success(__('Pré Inscrição Lançada com Sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Pré Inscrição não pode ser salva. Tente novamente.'));
        }
        $rolevents = $this->Singlesubscriptions->Rolevents->find('list', ['limit' => 200]);
        $bussinessunits = $this->Singlesubscriptions->Bussinessunits->find('list', ['limit' => 200]);       
       
        $this->set(compact('singlesubscription', 'rolevents', 'bussinessunits'));
    }

    public function addid($id = null)
    {
        $singlesubscription = $this->Singlesubscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $singlesubscription = $this->Singlesubscriptions->patchEntity($singlesubscription, $this->request->getData());
            $singlesubscription->rolevent_id = $id;
            $singlesubscription->statusflag = "GERADA_COM_SUCESSO";          
            $eventoref = $this->Rlevent->findroleventsbyid($id);
            $singlesubscription->price = $eventoref->price;
            $personref = $this->Peopl->findpeopleidbydoc($singlesubscription->documentnumber);
            $singlesubscription->people_id = $personref;    
            $persondata = $this->Peopl->findallpeoplebypeopleid($personref);
            $singlesubscription->originid = $persondata->originid;    

            if ($this->Singlesubscriptions->save($singlesubscription)) {
                
                $this->Flash->success(__('Pré inscrição realizada com sucesso.'));
                return $this->redirect(['action' => 'view',$singlesubscription->id]);
                
            }
            $this->Flash->error(__('Pré inscrição não pode ser registrada. por favor tente novamente  ou entre em contato com os nossos administradores.'));
        }
        $rolevents = $this->Singlesubscriptions->Rolevents->find('list',array('conditions'=>array('Rolevents.id'=>$id)));
        $bussinessunits = $this->Singlesubscriptions->Bussinessunits->find('list', ['limit' => 200]);       
       
        $this->set(compact('singlesubscription', 'rolevents', 'bussinessunits'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Singlesubscription id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $singlesubscription = $this->Singlesubscriptions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $singlesubscription = $this->Singlesubscriptions->patchEntity($singlesubscription, $this->request->getData());
            $eventoref = $this->Rlevent->findroleventsbyid($singlesubscription->rolevent_id);
            $singlesubscription->price = $eventoref->price;
            if ($this->Singlesubscriptions->save($singlesubscription)) {
                $this->Flash->success(__('Pré Inscrição Registrada com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Pré Inscrição não pode ser salva. Revise os dados e tente novamente.'));
        }
        $rolevents = $this->Singlesubscriptions->Rolevents->find('list', ['limit' => 200]);
        $bussinessunits = $this->Singlesubscriptions->Bussinessunits->find('list', ['limit' => 200]);
        $subscriptions = $this->Singlesubscriptions->Subscriptions->find('list', ['limit' => 200]);
        $people = $this->Singlesubscriptions->People->find('list', ['limit' => 200]);
        $this->set(compact('singlesubscription', 'rolevents', 'bussinessunits', 'subscriptions', 'people'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Singlesubscription id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $singlesubscription = $this->Singlesubscriptions->get($id);
        if ($this->Singlesubscriptions->delete($singlesubscription)) {
            $this->Flash->success(__('The singlesubscription has been deleted.'));
        } else {
            $this->Flash->error(__('The singlesubscription could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
