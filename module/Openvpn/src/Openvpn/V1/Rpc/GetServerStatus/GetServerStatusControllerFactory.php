<?php
namespace Openvpn\V1\Rpc\GetServerStatus;

class GetServerStatusControllerFactory
{
    public function __invoke($controllers)
    {
        $services = $controllers->getServiceLocator();
        return new GetServerStatusController($services);
    }
}
