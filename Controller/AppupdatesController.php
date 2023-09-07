<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Appupdates Controller
 *
 * @property \App\Model\Table\AppupdatesTable $Appupdates
 * @method \App\Model\Entity\Appupdate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppupdatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [            
            'conditions' => ['Appupdates.status like '=> 'OPEN'],       
            'order' => [
          'Appupdates.ordem' => 'asc']
        ];

        $appupdates = $this->paginate($this->Appupdates);

        $this->set(compact('appupdates'));
    }

    /**
     * View method
     *
     * @param string|null $id Appupdate id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appupdate = $this->Appupdates->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('appupdate'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appupdate = $this->Appupdates->newEmptyEntity();
        if ($this->request->is('post')) {
            $appupdate = $this->Appupdates->patchEntity($appupdate, $this->request->getData());
            if ($this->Appupdates->save($appupdate)) {
                $this->Flash->success(__('The appupdate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The appupdate could not be saved. Please, try again.'));
        }
        $this->set(compact('appupdate'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Appupdate id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appupdate = $this->Appupdates->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appupdate = $this->Appupdates->patchEntity($appupdate, $this->request->getData());
            if ($this->Appupdates->save($appupdate)) {
                $this->Flash->success(__('The appupdate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The appupdate could not be saved. Please, try again.'));
        }
        $this->set(compact('appupdate'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Appupdate id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appupdate = $this->Appupdates->get($id);
        if ($this->Appupdates->delete($appupdate)) {
            $this->Flash->success(__('The appupdate has been deleted.'));
        } else {
            $this->Flash->error(__('The appupdate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
