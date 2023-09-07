<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Exception\InternalErrorException;
use Cake\Utility\Text;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Rlevent component
 */
class RleventComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $max_files = 3;

	public function upload($data,$galeria) 
	{
		//	$data = $this->request->getData('image');

		$name = $data->getClientFilename();
		$type = $data->getClientMediaType();
		$targetPath = WWW_ROOT. 'img'.DS.'rolevents'.DS.$galeria.DS.$name;		
		//$dir = WWW_ROOT.'img'.DS.'vouchers'.DS.$galeria;
		if ($type == 'image/jpeg' || $type == 'image/jpg' || $type == 'image/png') {
			if (!empty($name)) {
				if ($data->getSize() > 0 && $data->getError() == 0) {
					$data->moveTo($targetPath); 								
					$articlesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('roleventsimgs');
					$article = $articlesTable->newEmptyEntity();							    
					$article->description = 'ARQUIVO IMPORTADO EVENTO: #'.$galeria;
					$article->filenameoriginal = $name;
					$article->filepath = $targetPath;
					$article->filename = $name;
					//$article->rolevent_id = $galeria;
								//var_dump($filename);
					$article->rolevent_id = $galeria;
					$articlesTable->save($article);

								
				}
			}
		}

	
		$this->_registry->getController()->Flash->success('The images has been saved.');

		return $this->_registry->getController()->redirect(['controller'=>'Rolevents','action' => 'view',$galeria]);	
	}

	public function findroleventsbyid($id) {

        $rolevents = \Cake\ORM\TableRegistry::getTableLocator()->get('rolevents');

        $eve = $rolevents
                ->find()
                ->where(['id' => $id])
                ->first();
     
        return $eve;     

    }
}
