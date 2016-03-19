<?php
namespace Openvpn\V1\Rpc\SetClientParam;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class SetClientParamController extends AbstractActionController
{
    protected $sm;
    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    public function setClientParamAction()
    {
        // get pass in params
        $data = $this->bodyParams();

        if( isset($data['account']) && isset($data['key']) && isset($data['value']) ){
            // service
            $service = $this->sm->get('Lib\Openvpn\Service\ClientConfig');
            $model = $service->setParam($data['account'], $data['key'], $data['value']);

            // view
            return new ViewModel(
                $model->toArray()
            );
        }

    }
}
