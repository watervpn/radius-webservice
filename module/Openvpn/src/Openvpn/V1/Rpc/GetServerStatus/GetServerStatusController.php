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
        // get pass in params
        $data = $this->bodyParams();
        $host = (isset($data['host'])) ? $data['host'] : null;

        // service
        $service = $this->sm->get('Lib\Openvpn\Service\ServerStatus');
        $model   = $service->getServerStatus($host);

        // view
        return new ViewModel(
            $model->toArray()
        );
    }
}
