<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Subscr component
 */
class SubscrComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function findsubscriptbyid($id) {

        if (!empty($id)) {

        $subscripts = \Cake\ORM\TableRegistry::getTableLocator()->get('Subscriptions');

        $subscr = $subscripts
                ->find()
                ->where(['id' => $id])
                ->first();

        // var_dump($user->email);
        //exit;

        return $subscr;

        }    
        
    }

    public function findsubscriptroleventbyid($id) {

        if (!empty($id)) {

        $subscripts = \Cake\ORM\TableRegistry::getTableLocator()->get('Subscriptions');

        $subscr = $subscripts
                ->find()
                ->where(['id' => $id])
                ->first();

        // var_dump($user->email);
        //exit;

        return $subscr->rolevent_id;

        }
              
        
    }
}
