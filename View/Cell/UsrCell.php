<?php
declare(strict_types=1);

namespace App\View\Cell;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;

use Cake\View\Cell;

/**
 * Usr cell
 */
class UsrCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
    }

    use LocatorAwareTrait;
    public function getusernamebyid($id) {        
        $urs = $this->getTableLocator()->get('users');        
        $ur = $urs->find()                
                ->where(['id' => $id]);
                //->first();

        if ($ur->count()) {           
                foreach ($ur->all() as $user) 
                {
                    $name = $user->name;
                } 
        } else {
            $name = "";
        }                    
        $this->set('name', $name);       
    }

    public function getuseremailbyid($id) {        
        $urs = $this->getTableLocator()->get('users');        
        $ur = $urs->find()                
                ->where(['id' => $id]);
                //->first();

        if ($ur->count()) {           
                foreach ($ur->all() as $user) 
                {
                    $name = $user->name;
                } 
        } else {
            $name = "";
        }                    
        $this->set('name', $name);       
    }
}
