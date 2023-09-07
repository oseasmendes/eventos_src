<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Orgs Controller
 *
 * @property \App\Model\Table\OrgsTable $Orgs
 * @method \App\Model\Entity\Org[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrgsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $orgs = $this->paginate($this->Orgs);

        $this->set(compact('orgs'));
    }

    /**
     * View method
     *
     * @param string|null $id Org id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {


        $org = $this->Orgs->get($id, [
            'contain' => ['Bussinessunits'=> [
                'sort' => ['Bussinessunits.seq' => 'asc','Bussinessunits.description' => 'asc'],
                'conditions' => ['Bussinessunits.active =' => true]           
            ]
        
        ],
        ]);

        $this->set(compact('org'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $org = $this->Orgs->newEmptyEntity();
        if ($this->request->is('post')) {
            $org = $this->Orgs->patchEntity($org, $this->request->getData());
            if ($this->Orgs->save($org)) {
                $this->Flash->success(__('The org has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The org could not be saved. Please, try again.'));
        }
        $this->set(compact('org'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Org id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $org = $this->Orgs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $org = $this->Orgs->patchEntity($org, $this->request->getData());
            if ($this->Orgs->save($org)) {
                $this->Flash->success(__('The org has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The org could not be saved. Please, try again.'));
        }
        $this->set(compact('org'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Org id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $org = $this->Orgs->get($id);
        if ($this->Orgs->delete($org)) {
            $this->Flash->success(__('The org has been deleted.'));
        } else {
            $this->Flash->error(__('The org could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
