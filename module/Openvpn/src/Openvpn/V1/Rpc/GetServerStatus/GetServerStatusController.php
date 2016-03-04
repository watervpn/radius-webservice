<?php
namespace Openvpn\V1\Rpc\GetServerStatus;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class GetServerStatusController extends AbstractActionController
{
    protected $sm;
    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    public function getServerStatusAction()
    {
        $data = $this->bodyParams();

        $serverStatus = $this->sm->get('Lib\Openvpn\Model\ServerStatus');

        if(!isset($data['host'])){
            $entities = $serverStatus->fetchAll();
        }else{
            $entities = $serverStatus->fetch($data['host'])->toArray();
        }

        return new ViewModel(
            $entities
        );
    }
}
