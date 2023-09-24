<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Itemtypes Controller
 *
 * @property \App\Model\Table\ItemtypesTable $Itemtypes
 * @method \App\Model\Entity\Itemtype[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemtypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $itemtypes = $this->paginate($this->Itemtypes);

        $this->set(compact('itemtypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Itemtype id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemtype = $this->Itemtypes->get($id, [
            'contain' => ['Items'],
        ]);

        $this->set(compact('itemtype'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemtype = $this->Itemtypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $itemtype = $this->Itemtypes->patchEntity($itemtype, $this->request->getData());
            if ($this->Itemtypes->save($itemtype)) {
                $this->Flash->success(__('The itemtype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The itemtype could not be saved. Please, try again.'));
        }
        $this->set(compact('itemtype'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Itemtype id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemtype = $this->Itemtypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemtype = $this->Itemtypes->patchEntity($itemtype, $this->request->getData());
            if ($this->Itemtypes->save($itemtype)) {
                $this->Flash->success(__('The itemtype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The itemtype could not be saved. Please, try again.'));
        }
        $this->set(compact('itemtype'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Itemtype id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemtype = $this->Itemtypes->get($id);
        if ($this->Itemtypes->delete($itemtype)) {
            $this->Flash->success(__('The itemtype has been deleted.'));
        } else {
            $this->Flash->error(__('The itemtype could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
