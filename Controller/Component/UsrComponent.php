<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;



/**
 * Users component
 */
class UsrComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function findUsermail($email) {

        if (!empty($email)) {

        $users = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');

        $user = $users
                ->find()
                ->where(['email like ' => $email])
                ->first();

        // var_dump($user->email);
        //exit;

        return $user;

        }
              
        
    }

    public function finduserbyId($id) {

        $usrs = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');

        $usr = $usrs
                ->find()
                ->where(['id' => $id])
                ->first();
     
            return $usr;     

    }
    
     public function updateuserconfirmation($userid = null) {
       

        $usersTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->get($userid); // Return article with id 12

        $user->confirmed = true;
        $user->confirmeddate = date('Y-m-d H:i:s', time()); ;
         
        $usersTable->save($user);

    }
}
