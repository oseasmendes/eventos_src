<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Roleventsimgs Controller
 *
 * @property \App\Model\Table\RoleventsimgsTable $Roleventsimgs
 * @method \App\Model\Entity\Roleventsimg[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoleventsimgsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Rlevent');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $this->paginate = [
            'contain' => ['Rolevents'],
        ];
        $roleventsimgs = $this->paginate($this->Roleventsimgs);

        $this->set(compact('roleventsimgs'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Roleventsimg id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $roleventsimg = $this->Roleventsimgs->get($id, [
            'contain' => ['Rolevents'],
        ]);

        $this->set(compact('roleventsimg'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $roleventsimg = $this->Roleventsimgs->newEmptyEntity();
        if ($this->request->is('post')) {
            $roleventsimg = $this->Roleventsimgs->patchEntity($roleventsimg, $this->request->getData());
            if ($this->Roleventsimgs->save($roleventsimg)) {
                $this->Flash->success(__('The roleventsimg has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The roleventsimg could not be saved. Please, try again.'));
        }
        $rolevents = $this->Roleventsimgs->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('roleventsimg', 'rolevents'));

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    public function addid($id = null)
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $roleventsimg = $this->Roleventsimgs->newEmptyEntity();
        if ($this->request->is('post')) {
            $roleventsimg = $this->Roleventsimgs->patchEntity($roleventsimg, $this->request->getData());
            $roleventsimg->rolevent_id = (int)$id;
           
            if (!empty($roleventsimg->rolevent_id)) {

               
                
                $reg = $roleventsimg->rolevent_id;
                $caminho = WWW_ROOT.DS.'img'.DS.'rolevents'.DS.$reg;    
               
                                                
                if (!file_exists($caminho)) {
                        mkdir($caminho, 0777, true);
                }
                


                $this->Rlevent->upload($this->request->getData('image'),$id);    
    
                    return $this->redirect(['controller'=>'rolevents','action' => 'view',$id]);


            } else {
                $this->Flash->error(__('A imagem não pode ser salva na pasta informada. Verifique.'));
            }
            
            
        }
        $rolevents = $this->Roleventsimgs->Rolevents->find('list', ['limit' => 2000]);
        $this->set(compact('roleventsimg', 'rolevents'));

        
        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Roleventsimg id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {


        $roleventsimg = $this->Roleventsimgs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $roleventsimg = $this->Roleventsimgs->patchEntity($roleventsimg, $this->request->getData());
            $idroleve = $roleventsimg->rolevent_id;
            if ($this->Roleventsimgs->save($roleventsimg)) {

                
                $this->Flash->success(__('The roleventsimg has been saved.'));

                //return $this->redirect(['action' => 'index']);
                return $this->redirect(['controller'=>'rolevents','action' => 'view',$idroleve]);
            }
            $this->Flash->error(__('The roleventsimg could not be saved. Please, try again.'));
        }
        $rolevents = $this->Roleventsimgs->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('roleventsimg', 'rolevents'));

           
        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Roleventsimg id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $roleid = $this->request
        ->getAttribute('identity')
        ->get('role_id');

        if ($roleid == 1) {

        $this->request->allowMethod(['post', 'delete']);
        $roleventsimg = $this->Roleventsimgs->get($id);
        if ($this->Roleventsimgs->delete($roleventsimg)) {
            $this->Flash->success(__('The roleventsimg has been deleted.'));
        } else {
            $this->Flash->error(__('The roleventsimg could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        } else {
            return $this->redirect(['controller'=>'Users','action' => 'refuse']);
        }
    }
}
