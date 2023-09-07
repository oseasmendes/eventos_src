<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Agendas Controller
 *
 * @property \App\Model\Table\AgendasTable $Agendas
 * @method \App\Model\Entity\Agenda[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgendasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('news');

        $this->paginate = [
            'contain' => ['Rolevents'],
            'conditions' => ['originagendaid <> '=> 0],       
            'order' => [
          'Agendas.dateevent' => 'asc']
        ];
        $agendas = $this->paginate($this->Agendas);

        $this->set(compact('agendas'));
    }

    /**
     * View method
     *
     * @param string|null $id Agenda id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $agenda = $this->Agendas->get($id, [
            'contain' => ['Rolevents'],
        ]);

        $this->set(compact('agenda'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $agenda = $this->Agendas->newEmptyEntity();
        if ($this->request->is('post')) {
            $agenda = $this->Agendas->patchEntity($agenda, $this->request->getData());
            if ($this->Agendas->save($agenda)) {
                $this->Flash->success(__('The agenda has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The agenda could not be saved. Please, try again.'));
        }
        $rolevents = $this->Agendas->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('agenda', 'rolevents'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Agenda id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $agenda = $this->Agendas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $agenda = $this->Agendas->patchEntity($agenda, $this->request->getData());
            if ($this->Agendas->save($agenda)) {
                $this->Flash->success(__('The agenda has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The agenda could not be saved. Please, try again.'));
        }
        $rolevents = $this->Agendas->Rolevents->find('list', ['limit' => 200]);
        $this->set(compact('agenda', 'rolevents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Agenda id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $agenda = $this->Agendas->get($id);
        if ($this->Agendas->delete($agenda)) {
            $this->Flash->success(__('The agenda has been deleted.'));
        } else {
            $this->Flash->error(__('The agenda could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->allowUnauthenticated(['view', 'index']);
    }
}
