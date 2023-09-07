<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
/**
 * Peoples Controller
 *
 * @property \App\Model\Table\PeoplesTable $Peoples
 * @method \App\Model\Entity\People[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NewsController extends AppController
{

    public function initialize() : void 
    {
            parent::initialize(); 
            $this->loadModel('Rolevents');
            $this->loadModel('Breakingnews');
            $this->loadModel('Orgs');
            $this->loadModel('Bussinessunits');

    }



    public function home() {
        $this->viewBuilder()->setLayout('news');
        
        
        $roleve = $this->Rolevents->find('all')
        ->where(['activeflag'=> true,'eventexpirationdate >'=> FrozenTime::now()])
        ->order(['Rolevents.id DESC']);


     

      //  var_dump($rolevents);
      //  exit;                                    
        
        $roleventlist = $this->Rolevents->find('list')
                            ->where(['activeflag'=> true,'subscriptionrequired'=> true])
                            ->order(['Rolevents.id DESC'])
                            ->limit('8');

        $breakingnews = $this->Breakingnews->find()
                                    ->where(['activeflag'=> true,'expirationdate >'=> FrozenTime::now()])
                                    ->order(['Breakingnews.expirationdate']);
        
                                 
        // correto
        //$this->set('rolevents',$this->paginate($rolevents,['limit'=>'3']));

        $this->set('rolevents',$this->paginate($roleve,['limit'=>'15']));

        $this->set('breakingnews',$this->paginate($breakingnews,['limit'=>'200']));

        $this->set('roleventlist',$roleventlist);
    }

    public function about() {
      $this->viewBuilder()->setLayout('news');
      
      
      $org = $this->Orgs->find('all')      
      ->order(['Orgs.id DESC']);
                   
      
      $orglist = $this->Orgs->find('list')                          
                          ->order(['Orgs.id DESC'])
                          ->limit('8');

      $bussinessunits = $this->Bussinessunits->find()
                                  //->where(['activeflag'=> true])
                                  ->order(['Bussinessunits.seq ASC','Bussinessunits.description ASC']);
      
                               
      // correto
      //$this->set('rolevents',$this->paginate($rolevents,['limit'=>'3']));

      $this->set('orgs',$this->paginate($org,['limit'=>'3']));

      $this->set('bussinessunits',$this->paginate($bussinessunits,['limit'=>'200']));

      $this->set('orglist',$orglist);
  }

  public function beforeFilter(\Cake\Event\EventInterface $event)
  {
      parent::beforeFilter($event);
      // Configure the login action to not require authentication, preventing
      // the infinite redirect loop issue
      $this->Authentication->allowUnauthenticated(['home', 'about']);
  }
    

}