<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\MailerAwareTrait;
use Cake\Validation\Validator;
//use Cake\Mailer\Mailer;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->allowUnauthenticated(['login','add','home','redefinepassword','accountconfirmation','emailconfirmation']);
    }

    public function initialize(): void
    {
        parent::initialize();
     //   $this->viewBuilder()->setLayout("admin");
     //   $this->loadComponent('Peoplescontacts');
          //$this->loadComponent('Paginator');
          $this->loadComponent('Usr');
          $this->loadComponent('Peopl');
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

       $profileid = $this->request
            ->getAttribute('identity')
            ->get('profile_id');
        
        if (($roleid == 1) && ($profileid == 10)) {
        $this->paginate = [
            'contain' => ['Profiles', 'Roles'],
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        } else {
            return $this->redirect(['action' => 'refuse']);
        }
      
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        
        $user = $this->Users->get($id, [
            'contain' => ['Profiles', 'Roles', 'Peoples', 'Subscriptions'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->role_id = 3;
            $user->profile_id = 6;
            $user->active = 1;
            $user->username = $user->docnumber;


            if ($this->Users->save($user)) {

                $peopleid = $this->Peopl->findpeopleidbydoc($user->docnumber);                
                
                if ($peopleid > 0) {
                    $this->Peopl->updatepeopleuserid($peopleid,$user->id);
                }
                
                  $userarray = array(
                        "name" => $user->name,
                        "email" => $user->email,
                        "username" => $user->username,
                        "hash" => $user->password,
                    );

                    if(!empty($userarray['email'])){                         

                        if (filter_var($userarray['email'], FILTER_VALIDATE_EMAIL)) 
                        {
                            $this->getMailer('Users')->send('accountconfirmation', [$user]);
                            $this->Flash->success(__('Foi enviado um email para confirmação de cadastro em seu endereço de email. Por favor acesse seu email pessoal e clique no link para CONFIRMAR CONTA'));
                        } 
                    }


                $this->Flash->success(__('Usuário Registrado com Sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Usuário não pode ser registrado. Há algum erro no preenchimento ou o Usuário já existe em nossa base de dados.'));
        }
        $profiles = $this->Users->Profiles->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'profiles', 'roles'));
    }

    

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->username = $user->docnumber;
            if ($this->Users->save($user)) {

                $peopleid = $this->Peopl->findpeopleidbydoc($user->docnumber); 
                
                if ($peopleid > 0) {
                    $this->Peopl->updatepeopleuserid($peopleid,$user->id);
                }

                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $profiles = $this->Users->Profiles->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'profiles', 'roles'));
    }

    public function changepassword($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $profiles = $this->Users->Profiles->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'profiles', 'roles'));
    }

    use MailerAwareTrait;

    public function emailconfirmation()
    {      

        if ($this->request->is(['patch', 'post', 'put'])) {

            

          //keyword = $this->request->getQueryParams('email');
          $keyword = $this->request->getData();

        //  var_dump($keyword);
         //   exit;

          if ($user = $this->Usr->findUsermail($keyword['email']))          
          {            
                    $userarray = array(
                        "name" => $user->name,
                        "email" => $user->email,
                        "username" => $user->username,
                        "hash" => $user->password,
                    );

                    if(!empty($userarray['email'])){    

                        /* if (filter_var($userarray['email'], FILTER_VALIDATE_EMAIL)) {
                            $this->getMailer('Users')->send('emailconfirmation', [$userarray]);
                            $this->Flash->success(__('The user has been saved.'));
                        } */

                        if (filter_var($userarray['email'], FILTER_VALIDATE_EMAIL)) {
                            $this->getMailer('Users')->send('emailconfirmation', [$user]);
                            $this->Flash->success(__('Foi enviado um email para seu endereço eletrônico (email). Verifique!.'));
                        } 



                    } else {

                        $this->Flash->error(__('Endereço de Email não localizado'));

                    }                   

            } else {
                    $this->Flash->error(__('Endereço de Email não localizado'));
            }
            
        }
        
    }

    public function redefinepassword()    
    {      
        $keyword = $this->request->getQueryParams('email');         
        $hash = $keyword['h'];
        $email = $keyword['email'];
        $id = intval($keyword['id']);

       
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->getQueryParams([ 'h']) and $this->request->getQueryParams([ 'email'])) {
            var_dump($keyword['email']);
           
            if ($userValid = $this->Usr->findUsermail($keyword['email']))   {
               
                if($hash == $userValid->password) {

                    if ($this->request->is(['patch', 'post', 'put'])) {
                        $user = $this->Users->patchEntity($user, $this->request->getData());
                        //var_dump($user);
                        $user->username = $userValid->username;
                        $user->docnumber = $userValid->docnumber;
                        $user->confirmed = 1;
                        $user->confirmeddate = date("Y-m-d H:i:s"); 
                        $user->active = 1; 

                        if ($this->Users->save($user)) {
                            $this->Flash->success(__('The user has been saved.'));
            
                            return $this->redirect(['action' => 'index']);
                        }
                        $this->Flash->error(__('The user could not be saved. Please, try again.'));

                    }

                } else {
                    $this->Flash->success(__('Senha Inválida.'));
                }

            } else {
                $this->Flash->success(__('Usuário não existe.'));
            }                
                        
        }      
        
    }

    
        public function accountconfirmation($id = null)    
    {      
        $keyword = $this->request->getQueryParams('email');         
        $hash = $keyword['h'];
        $email = $keyword['email'];
        $id = intval($keyword['id']);
        
        
        
       
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
            
        $this->set(compact('user'));

        if ($this->request->getQueryParams([ 'h']) and $this->request->getQueryParams([ 'email'])) 
        {

                    if ($user = $this->Usr->findUsermail($keyword['email']))   
                    {
                            $confirmation = $this->Usr->updateuserconfirmation($user->id); 
                            $this->Flash->success(__('Email have been confirmed. Welcome!'));
                   
                    } else {

                        $this->Flash->error(__('Email address not found'));

                    }                   

            } else {
                $this->Flash->success(__('Usuário não existe.'));        
                        
        }      
        
    }


    
    /**
     * Delete method
     *
     * @param string|null $id User id.
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
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

        } else {
            return $this->redirect(['action' => 'refuse']);
        }
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        //var_dump($result);
        if ($result->isValid()) {
            return $this->redirect(['controller'=> 'News','action'=>'home']);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }

    /*    $result = $this->Authentication->getResult();
    // If the user is logged in send them away.
    if ($result->isValid()) {
        //$target = $this->Authentication->getLoginRedirect() ?? '/home';
        return $this->redirect(['controller'=> 'News','action'=>'home']);
        //return $this->redirect($target);
    }
    if ($this->request->is('post')) {
        $this->Flash->error('Invalid username or password');
    }*/
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'News', 'action' => 'home']);
        }
        
    }

    public function refuse()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            
            $this->Authentication->logout();            
            return $this->redirect(['controller' => 'News', 'action' => 'home']);
        }
    }
}
