<?php
namespace Openvpn\V1\Rpc\FetchServerStatusJob;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class FetchServerStatusJobController extends AbstractActionController
{
    protected $sm;
    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    public function fetchServerStatusJobAction()
    {
        $data = $this->bodyParams();

        $async = false;
        $worker = $this->sm->get('Lib\Openvpn\Worker\FetchAllServerStatus');
        $op = $worker->run($async);

        return new ViewModel(
            array(
                'status' => 'success',
                'data' => $op
            )
        );
    }
}
