<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Subscriptionsdocs Controller
 *
 * @property \App\Model\Table\SubscriptionsdocsTable $Subscriptionsdocs
 * @method \App\Model\Entity\Subscriptionsdoc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscriptionsdocsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('SubscrDoc');
        $this->loadComponent('Subscr');
        $this->loadComponent('Peopl');
        $this->loadComponent('Rlevent');       
        $this->loadComponent('Usr');       
        

    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $userid = $this->request
        ->getAttribute('identity')
        ->getIdentifier();

        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {


            $this->paginate = [
                'contain' => ['Subscriptions', 'Doctypes'],
            ];
            $subscriptionsdocs = $this->paginate($this->Subscriptionsdocs);

            $this->set(compact('subscriptionsdocs'));
      
            
        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
   
    }

    /**
     * View method
     *
     * @param string|null $id Subscriptionsdoc id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subscriptionsdoc = $this->Subscriptionsdocs->get($id, [
            'contain' => ['Subscriptions', 'Doctypes'],
        ]);

        $this->set(compact('subscriptionsdoc'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subscriptionsdoc = $this->Subscriptionsdocs->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscriptionsdoc = $this->Subscriptionsdocs->patchEntity($subscriptionsdoc, $this->request->getData());
            if ($this->Subscriptionsdocs->save($subscriptionsdoc)) {
                $this->Flash->success(__('The subscriptionsdoc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriptionsdoc could not be saved. Please, try again.'));
        }
        $subscriptions = $this->Subscriptionsdocs->Subscriptions->find('list', ['limit' => 200]);
        $doctypes = $this->Subscriptionsdocs->Doctypes->find('list', ['limit' => 200]);
        $this->set(compact('subscriptionsdoc', 'subscriptions', 'doctypes'));
    }

    public function addid($id = null)
    {
        $subscriptionsdoc = $this->Subscriptionsdocs->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscriptionsdoc = $this->Subscriptionsdocs->patchEntity($subscriptionsdoc, $this->request->getData());
           
  
                $subscriptionsdoc->subscription_id = (int)$id;
                $roleventid = $this->Subscr->findsubscriptroleventbyid($id);
                
                $subscr = $this->Subscr->findsubscriptbyid($id);                    
                $sub_people_id = (empty($subscr->people_id)) ? 0 : $subscr->people_id;                
                $sub_usr_id = (empty($subscr->user_id)) ? 0 : $subscr->user_id;
                $sub_payment = (empty($subscr->paymentvalue)) ? 0 : $subscr->paymentvalue;
                $sub_date = (empty($subscr->dateissue)) ? getdate()->format('Y-m-d') : $subscr->dateissue;

                $event = $this->Rlevent->findroleventsbyid($roleventid);                
                $ev_name = (empty($event->description)) ? "" : $event->description;                
                $ev_price = (empty($event->price)) ? 0 : $event->price;     

                $usr = $this->Usr->finduserbyId($sub_usr_id);
                $usr_name = (empty($usr->name)) ? "" : $usr->name;
                $usr_doc = (empty($usr->docnumber)) ? "" : $usr->docnumber;

                $fullhash = strval($roleventid)."|".$ev_name."|".strval($ev_price)."|".strval($sub_usr_id)."|".strval($sub_people_id)."|".strval($sub_payment)."|".$usr_name."|".$usr_doc."|".$sub_date;

                $anexo = $this->request->getData('image');
                $filename = $anexo->getClientFilename();
           
                if (!empty($subscriptionsdoc->subscription_id) && (!empty($filename)) && !empty($subscriptionsdoc->doctype_id)) {
              
                    $reg = $subscriptionsdoc->subscription_id;
                    $caminho = WWW_ROOT.DS.'img'.DS.'vouchers'.DS.$reg;    
                   
                                                    
                    if (!file_exists($caminho) ) {
                            mkdir($caminho, 0777, true);
                    }                   
       
                    $this->SubscrDoc->upload($this->request->getData('image'),$id,$subscriptionsdoc->description,$subscriptionsdoc->doctype_id,$fullhash);    
        
                        return $this->redirect(['controller'=>'rolevents','action' => 'view',$roleventid]);
        
                } else {
                    $this->Flash->error(__('Não foi selecionado nenhuma imagem, ou não foi encontrado inscrição anexada, ou Tipo Documento não informado. Verifique.'));
                }

              //  $this->Flash->success(__('The subscriptionsdoc has been saved.'));

                return $this->redirect(['controller'=>'rolevents','action' => 'view',$roleventid]);
          /*  }
            $this->Flash->error(__('The subscriptionsdoc could not be saved. Please, try again.'));
            
            return $this->redirect(['controller'=>'rolevents','action' => 'view',$roleventid]); */
        }
        $subscriptions = $this->Subscriptionsdocs->Subscriptions->find('list',array('conditions'=>array('Subscriptions.id'=>$id)));
        $doctypes = $this->Subscriptionsdocs->Doctypes->find('list', ['limit' => 200]);
        $this->set(compact('subscriptionsdoc', 'subscriptions', 'doctypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subscriptionsdoc id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subscriptionsdoc = $this->Subscriptionsdocs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscriptionsdoc = $this->Subscriptionsdocs->patchEntity($subscriptionsdoc, $this->request->getData());
            if ($this->Subscriptionsdocs->save($subscriptionsdoc)) {
                $this->Flash->success(__('The subscriptionsdoc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriptionsdoc could not be saved. Please, try again.'));
        }
        $subscriptions = $this->Subscriptionsdocs->Subscriptions->find('list', ['limit' => 200]);
        $doctypes = $this->Subscriptionsdocs->Doctypes->find('list', ['limit' => 200]);
        $this->set(compact('subscriptionsdoc', 'subscriptions', 'doctypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscriptionsdoc id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subscriptionsdoc = $this->Subscriptionsdocs->get($id);
        if ($this->Subscriptionsdocs->delete($subscriptionsdoc)) {
            $this->Flash->success(__('The subscriptionsdoc has been deleted.'));
        } else {
            $this->Flash->error(__('The subscriptionsdoc could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
