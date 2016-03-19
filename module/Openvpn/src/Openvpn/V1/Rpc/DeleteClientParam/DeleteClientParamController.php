<?php
namespace Openvpn\V1\Rpc\DeleteClientParam;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;
use ZF\ApiProblem\ApiProblem;

class DeleteClientParamController extends AbstractActionController
{
    protected $sm;
    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    public function deleteClientParamAction()
    {
        // get pass in params
        $data = $this->bodyParams();

        if( isset($data['account']) && isset($data['key']) ){
            try{
                // service
                $service = $this->sm->get('Lib\Openvpn\Service\ClientConfig');
                $response = $service->deleteParam($data['account'], $data['key']);
            }catch(\Exception $e){
                $this->getResponse()->setStatusCode(405);
                $response =  new ApiProblem(405, 'Param key:['.$data['key'].'] has already deleted.');
            }

            // view
            return new ViewModel(
                $response->toArray()
            );
        }

    }
}
