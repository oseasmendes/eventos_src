<?php
declare(strict_types=1);

namespace App\View\Cell;
//use Cake\ORM\TableRegistry;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;


use Cake\View\Cell;

/**
 * Roleventimage cell
 */
class RoleventimageCell extends Cell
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
    public function getimagename($roleventid,$typeimg) {

       
        $imgs = $this->getTableLocator()->get('Roleventsimgs');
        
        //$imgs = Cake\ORM\Locator\LocatorAwareTrait::getTableLocator()->get('Roleventsimgs');


        $img = $imgs->find()                
                ->where(['rolevent_id' => $roleventid,'docsystemtype LIKE ' => $typeimg ]);
                //->first();

       

        if ($img->count()) {
           
                foreach ($img->all() as $im) 
                {
                    $fil = $im->filename;
                }

                $Root_Path = "http://".$_SERVER['SERVER_NAME']."/eventos";
                                    //$pathurl = WWW_ROOT.'img'.DS.'projetosprodutos'.DS.$projetosprodutosimg->projetosproduto->id;
                                
                $newpath = $Root_Path.'/img'.'/rolevents/'.$roleventid; 
                $pathimage = $newpath.'/'.$fil;  

              //  var_dump($pathimage);
              //  exit;
        
                $this->set('pathimage', $pathimage);
                //return $name; 
        } else {
            $Root_Path = "http://".$_SERVER['SERVER_NAME']."/eventos";
            $newpath = $Root_Path.'/img/logoadbelem.png'; 
            $pathimage = $newpath;  

            //var_dump($pathimage);
            //exit;

            $this->set('pathimage', $pathimage);
        }      
        

        

        
    }
}
