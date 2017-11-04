<?php
namespace Openvpn\V1\Rpc\GetClientConfig;

class GetClientConfigControllerFactory
{
    public function __invoke($controllers)
    {
        $services = $controllers->getServiceLocator();
        //TODO: inject worker instead of service
        return new GetClientConfigController($services);
    }
}
