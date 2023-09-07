<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * Peopl component
 */
class PeoplComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function findpeopleidbydoc($personaldoc) {

        // $peoples = \Cake\ORM\TableRegistry::getTableLocator()->get('peoples');
        //$peoples = \Cake\ORM\TableRegistry::getTableLocator()->setConfig('Peoples', ['table' => 'peoples']);
        $peoples = \Cake\ORM\TableRegistry::getTableLocator()->get('Peoples');
        

        $people = $peoples
                ->find()
                ->select(['id','idocnumber'])
                ->where(['idocnumber = ' => $personaldoc])
                ->first();
       

        if (!empty($people)) {
            $iddoc = $people->id;
            return $iddoc;
        } else {
            $iddoc = 0;
            return $iddoc;
        }      

    }

   
    public function findpeoplebyuserid($userid) {

        $peoples = \Cake\ORM\TableRegistry::getTableLocator()->get('Peoples');

        $people = $peoples
                ->find()
                ->select(['id','idocnumber'])
                ->where(['user_id =' => $userid])
                ->first();
       

        if (!empty($people)) {
            $iddoc = $people->id;
            return $iddoc;
        } else {
            $iddoc = 0;
            return $iddoc;
        }
    }

    public function findallpeoplebypeopleid($id) {

        $peoples = \Cake\ORM\TableRegistry::getTableLocator()->get('Peoples');

        $people = $peoples
                ->find()
                ->where(['id =' => $id])
                ->first();
       

        return $people;    
    }

    public function findPeopleOriginidByUserId($userid) {

        $peoples = \Cake\ORM\TableRegistry::getTableLocator()->get('Peoples');

        $people = $peoples
                ->find()
                ->select(['id','idocnumber','originid'])
                ->where(['user_id =' => $userid])
                ->first();
       

        if (!empty($people)) {
            $iddoc = $people->originid;
            return $iddoc;
        } else {
            $iddoc = 0;
            return $iddoc;
        }
    }

    public function updatepeopleuserid($id = null, $userid = null) {
       

        $peoplesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('peoples');
        $people = $peoplesTable->get($id); // Return article with id 12

        $people->user_id = $userid;
        $peoplesTable->save($people);

    }
}
