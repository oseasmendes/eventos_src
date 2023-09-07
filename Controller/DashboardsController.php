<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Dashboards Controller
 *
 * @property \App\Model\Table\Dashboards $Dashboards
 * @method \App\Model\Entity\Dashboards[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardsController extends AppController
{

    public function initialize(): void {
        parent::initialize();

        $this->viewBuilder()->setLayout("admin");
    }

    public function index(){

    }

}