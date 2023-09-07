<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Sysactions Controller
 *
 * @property \App\Model\Table\SysactionsTable $Sysactions
 * @method \App\Model\Entity\Sysaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SysactionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $sysactions = $this->paginate($this->Sysactions);

        $this->set(compact('sysactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Sysaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sysaction = $this->Sysactions->get($id, [
            'contain' => ['Sysadmins'],
        ]);

        $this->set(compact('sysaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sysaction = $this->Sysactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $sysaction = $this->Sysactions->patchEntity($sysaction, $this->request->getData());
            if ($this->Sysactions->save($sysaction)) {
                $this->Flash->success(__('The sysaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sysaction could not be saved. Please, try again.'));
        }
        $this->set(compact('sysaction'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sysaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sysaction = $this->Sysactions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sysaction = $this->Sysactions->patchEntity($sysaction, $this->request->getData());
            if ($this->Sysactions->save($sysaction)) {
                $this->Flash->success(__('The sysaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sysaction could not be saved. Please, try again.'));
        }
        $this->set(compact('sysaction'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sysaction id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sysaction = $this->Sysactions->get($id);
        if ($this->Sysactions->delete($sysaction)) {
            $this->Flash->success(__('The sysaction has been deleted.'));
        } else {
            $this->Flash->error(__('The sysaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
