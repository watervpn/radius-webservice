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
        // get pass in params
        $data    = $this->bodyParams();
        $async   = (isset($data['async'])) ? $data['async'] : false;

        // service
        $service = $this->sm->get('Lib\Openvpn\Service\ServerStatus');
        $op      = $service->fetchServerStatusJob($async);

        $response = [];
        $response ['status'] = 'success';
        if(!$async){
            $response ['responses'] = $op;
        }
        // view
        return new ViewModel(
            $response
        );
    }
}
