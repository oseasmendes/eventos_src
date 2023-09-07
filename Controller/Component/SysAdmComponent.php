<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * SysAdm component
 */
class SysAdmComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    
    public function mastercontrol($control, $act, $profile, $role) {

        // $peoples = \Cake\ORM\TableRegistry::getTableLocator()->get('peoples');
        //$peoples = \Cake\ORM\TableRegistry::getTableLocator()->setConfig('Peoples', ['table' => 'peoples']);
        $resps = \Cake\ORM\TableRegistry::getTableLocator()->get('Sysadmins');
        
        $app = 'EVENT';

        $responsability = $resps
                ->find()
                ->select()
                ->where([
                    'app LIKE '=> $app,
                    'reference LIKE '=> $control,
                    'register = '=> $act,                    
                    'profile_id = ' => $profile,
                        'role_id = ' => $role,
                        'active is true'])
                ->first();
       

        return $responsability;
             

    }

}
