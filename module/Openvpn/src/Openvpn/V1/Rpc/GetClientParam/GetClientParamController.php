<?php
namespace Openvpn\V1\Rpc\GetClientParam;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class GetClientParamController extends AbstractActionController
{
    protected $sm;
    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    public function getClientParamAction()
    {
        // get pass in params
        $data = $this->bodyParams();

        if(isset($data['account'])){
            // service
            $service = $this->sm->get('Lib\Openvpn\Service\ClientConfig');
            $model = $service->getParam($data['account']);

            // view
            return new ViewModel(
                $model->toArray()
            );
        }

        //return new ApiProblem(422, 'Missing require field [account]');

    }
}
