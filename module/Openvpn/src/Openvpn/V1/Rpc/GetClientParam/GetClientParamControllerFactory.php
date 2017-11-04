<?php
namespace Openvpn\V1\Rpc\GetClientParam;

class GetClientParamControllerFactory
{
    public function __invoke($controllers)
    {
        $services = $controllers->getServiceLocator();
        return new GetClientParamController($services);
    }
}
