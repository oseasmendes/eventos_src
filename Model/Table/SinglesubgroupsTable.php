<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Database\FunctionsBuilder;


class SinglesubgroupsTable extends Table
{

    public function subTotalByUnits() {

        $query = $this->getTableLocator()->get('Singlesubscriptions')->find();

        $query = $articles->find();
        $query->select([
            'count' => $query->func()->count('id'),
            'bussinessunit_id' 
        ])
        ->group('bussinessunit_id')
        ->having(['count >' => 0]);   
            
        foreach ($query->all() as $singlesub) {
            debug($singlesub);
        }

        $query->orderAsc($singlesub);

        return $singlesub;
    }

   
}