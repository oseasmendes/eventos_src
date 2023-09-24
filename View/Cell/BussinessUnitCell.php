<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;


/**
 * BussinessUnit cell
 */
class BussinessUnitCell extends Cell
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

    public function getname($id) {        
        $bussinessunits = $this->getTableLocator()->get('Bussinessunits');        
        $bussinessunit = $bussinessunits->find()                
                ->where(['id' => $id])
                ->first();

        $name = $bussinessunit->description;
                            
        $this->set('name', $name);       
    }
}
