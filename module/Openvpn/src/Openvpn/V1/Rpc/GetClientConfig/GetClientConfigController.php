<?php
namespace Openvpn\V1\Rpc\GetClientConfig;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class GetClientConfigController extends AbstractActionController
{
    protected $sm;
    public function __construct($sm)
    {
        $this->sm = $sm;
    }
    public function getClientConfigAction()
    {
        //https://groups.google.com/a/zend.com/forum/#!topic/apigility-users/V2t1GYVQR-c
        //$event = $this->getEvent();
        //$worker = $this->sm->get('Lib\Openvpn\Worker\GetClientConfig');
        $service = $this->sm->get('Lib\Openvpn\Service\ClientConfig');
        $data    = $this->bodyParams();

        if(isset($data['account']) && isset($data['server'])){
            $config = $service->getConfig($data['account'], $data['server']);

            return new ViewModel(
                array('config'=> $config)
            );
            //return new ApiProblem( self::ENTITY_ALREADY_EXIST, "Account: {$data->id} already exist!");
        }
    }
}
