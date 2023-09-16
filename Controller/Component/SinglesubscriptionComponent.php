<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * Singlesubscription component
 */
class SinglesubscriptionComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function FindSingleSubscriptionById($id) {

        $singlesubscriptions = \Cake\ORM\TableRegistry::getTableLocator()->get('Singlesubscriptions');

        $singlesub = $singlesubscriptions
                ->find()
                ->where(['id =' => $id])
                ->first();
       

        return $singlesub;    
    }
}
