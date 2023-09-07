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
 * SubscrDoc component
 */
class SubscrDocComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function upload($data,$galeria,$description,$doctype,$fullhash) 
	{
		//	$data = $this->request->getData('image');
		$arrayHash = explode("|",$fullhash);
		
		$subscriptioneventid = $arrayHash[0];
		$subscevent = $arrayHash[1];
		$subscprice = $arrayHash[2];
		$memberuser = $arrayHash[3];
		$membercode = $arrayHash[4];
		$subscpayment = $arrayHash[5];
		$membername = $arrayHash[6];
		$memberdocnumber = $arrayHash[7];
		$subscdate = $arrayHash[8];
		
		

		$name = $data->getClientFilename();
		$type = $data->getClientMediaType();
		$targetPath = WWW_ROOT. 'img'.DS.'vouchers'.DS.$galeria.DS.$name;		
		//$dir = WWW_ROOT.'img'.DS.'vouchers'.DS.$galeria; application/pdf
		if ($type == 'image/jpeg' || $type == 'image/jpg' || $type == 'image/png' || $type == 'application/pdf') {
			if (!empty($name)) {
				if ($data->getSize() > 0 && $data->getError() == 0) {
					$data->moveTo($targetPath); 								
					$articlesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('subscriptionsdocs');
					$article = $articlesTable->newEmptyEntity();							    
					$article->description = "#REF ".$galeria." - ".$description."";
					$article->filenameoriginal = $name;
					$article->filepath = $targetPath;
					$article->filename = $name;
					$article->doctype_id = $doctype;
					//$article->rolevent_id = $galeria;
								//var_dump($filename);
					$article->subscription_id = $galeria;
					$articlesTable->save($article);

								
				}
			}
		}

	
	//	$this->_registry->getController()->Flash->success('The images has been saved.');

	//	return $this->_registry->getController()->redirect(['controller'=>'Rolevents','action' => 'view',$galeria]);	
	}

	
	public function findroleventsbyid($id) {

        $rolevents = \Cake\ORM\TableRegistry::getTableLocator()->get('Rolevents');

        $eve = $rolevents
                ->find()
                ->where(['id' => $id])
                ->first();
     
        return $eve;     

    } 
}
