<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Syscontrols Controller
 *
 * @property \App\Model\Table\SyscontrolsTable $Syscontrols
 * @method \App\Model\Entity\Syscontrol[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SyscontrolsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $syscontrols = $this->paginate($this->Syscontrols);

        $this->set(compact('syscontrols'));
    }

    /**
     * View method
     *
     * @param string|null $id Syscontrol id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $syscontrol = $this->Syscontrols->get($id, [
            'contain' => ['Sysadmins'],
        ]);

        $this->set(compact('syscontrol'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $syscontrol = $this->Syscontrols->newEmptyEntity();
        if ($this->request->is('post')) {
            $syscontrol = $this->Syscontrols->patchEntity($syscontrol, $this->request->getData());
            if ($this->Syscontrols->save($syscontrol)) {
                $this->Flash->success(__('The syscontrol has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The syscontrol could not be saved. Please, try again.'));
        }
        $this->set(compact('syscontrol'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Syscontrol id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $syscontrol = $this->Syscontrols->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $syscontrol = $this->Syscontrols->patchEntity($syscontrol, $this->request->getData());
            if ($this->Syscontrols->save($syscontrol)) {
                $this->Flash->success(__('The syscontrol has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The syscontrol could not be saved. Please, try again.'));
        }
        $this->set(compact('syscontrol'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Syscontrol id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $syscontrol = $this->Syscontrols->get($id);
        if ($this->Syscontrols->delete($syscontrol)) {
            $this->Flash->success(__('The syscontrol has been deleted.'));
        } else {
            $this->Flash->error(__('The syscontrol could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
