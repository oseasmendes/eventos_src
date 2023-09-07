<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Sysapps Controller
 *
 * @property \App\Model\Table\SysappsTable $Sysapps
 * @method \App\Model\Entity\Sysapp[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SysappsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $sysapps = $this->paginate($this->Sysapps);

        $this->set(compact('sysapps'));
    }

    /**
     * View method
     *
     * @param string|null $id Sysapp id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sysapp = $this->Sysapps->get($id, [
            'contain' => ['Sysadmins'],
        ]);

        $this->set(compact('sysapp'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sysapp = $this->Sysapps->newEmptyEntity();
        if ($this->request->is('post')) {
            $sysapp = $this->Sysapps->patchEntity($sysapp, $this->request->getData());
            if ($this->Sysapps->save($sysapp)) {
                $this->Flash->success(__('The sysapp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sysapp could not be saved. Please, try again.'));
        }
        $this->set(compact('sysapp'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sysapp id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sysapp = $this->Sysapps->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sysapp = $this->Sysapps->patchEntity($sysapp, $this->request->getData());
            if ($this->Sysapps->save($sysapp)) {
                $this->Flash->success(__('The sysapp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sysapp could not be saved. Please, try again.'));
        }
        $this->set(compact('sysapp'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sysapp id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sysapp = $this->Sysapps->get($id);
        if ($this->Sysapps->delete($sysapp)) {
            $this->Flash->success(__('The sysapp has been deleted.'));
        } else {
            $this->Flash->error(__('The sysapp could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
