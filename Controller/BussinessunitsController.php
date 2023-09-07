<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Bussinessunits Controller
 *
 * @property \App\Model\Table\BussinessunitsTable $Bussinessunits
 * @method \App\Model\Entity\Bussinessunit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BussinessunitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orgs'],
        ];
        $bussinessunits = $this->paginate($this->Bussinessunits);

        $this->set(compact('bussinessunits'));
    }

    /**
     * View method
     *
     * @param string|null $id Bussinessunit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bussinessunit = $this->Bussinessunits->get($id, [
            'contain' => ['Orgs', 'Rolevents'],
        ]);

        $this->set(compact('bussinessunit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bussinessunit = $this->Bussinessunits->newEmptyEntity();
        if ($this->request->is('post')) {
            $bussinessunit = $this->Bussinessunits->patchEntity($bussinessunit, $this->request->getData());
            if ($this->Bussinessunits->save($bussinessunit)) {
                $this->Flash->success(__('The bussinessunit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bussinessunit could not be saved. Please, try again.'));
        }
        $orgs = $this->Bussinessunits->Orgs->find('list', ['limit' => 200]);
        $this->set(compact('bussinessunit', 'orgs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bussinessunit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bussinessunit = $this->Bussinessunits->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bussinessunit = $this->Bussinessunits->patchEntity($bussinessunit, $this->request->getData());
            if ($this->Bussinessunits->save($bussinessunit)) {
                $this->Flash->success(__('The bussinessunit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bussinessunit could not be saved. Please, try again.'));
        }
        $orgs = $this->Bussinessunits->Orgs->find('list', ['limit' => 200]);
        $this->set(compact('bussinessunit', 'orgs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bussinessunit id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bussinessunit = $this->Bussinessunits->get($id);
        if ($this->Bussinessunits->delete($bussinessunit)) {
            $this->Flash->success(__('The bussinessunit has been deleted.'));
        } else {
            $this->Flash->error(__('The bussinessunit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
