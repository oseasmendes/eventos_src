<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Rleventimg component
 */
class RleventimgComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function findRoleventImgType($id,$imgtype) {

        $imgs = \Cake\ORM\TableRegistry::getTableLocator()->get('roleventsimgs');

        $img = $imgs
                ->find()
                ->where(['rolevent_id' => $id,'docsystemtype =' => $imgtype])
                ->first();
       

        if (!empty($img)) {
            $idimg = $img->filenameoriginal;
            return $idimg;
        } else {
            $idimg = "";
            return $idimg;
        }      

    }
}
