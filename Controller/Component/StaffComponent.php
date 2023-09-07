<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;

/**
 * Staff component
 */
class StaffComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function fndrsp($cntrl = null,$act = null,$role = null, $profile = null) {

        $Sadms = \Cake\ORM\TableRegistry::getTableLocator()->get('Sysadmins');

       

        $adm = $Sadms
                ->find()
                ->where(['app =' => $app,'control =' => $cntrl,'act =' => $act,'role_id =' => $role,'profile_id =' => $profile])
                ->first();
       

        return $adm;    
    }

    public function mcontrol($control = null, $act = null, $profile = null, $role = null) {

        // $peoples = \Cake\ORM\TableRegistry::getTableLocator()->get('peoples');
        //$peoples = \Cake\ORM\TableRegistry::getTableLocator()->setConfig('Peoples', ['table' => 'peoples']);
        $resps = \Cake\ORM\TableRegistry::getTableLocator()->get('Sysadmins');
        
        $app = Configure::read('app.eventos');

        $responsability = $resps
                ->find()
                ->select()
                ->where([
                        'sysapp_id = '=> $app,
                        'syscontrol_id = '=> $control,                    
                        'profile_id = ' => $profile,
                        'role_id = ' => $role,
                        'sysaction_id = ' => $act,
                        'active is true'])
                ->first();
       
        

        return $responsability;
    }
}
