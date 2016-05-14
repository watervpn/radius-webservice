<?php
namespace Openvpn\V1\Rpc\FetchServerStatusJob;

class FetchServerStatusJobControllerFactory
{
    public function __invoke($controllers)
    {
        $services = $controllers->getServiceLocator();
        return new FetchServerStatusJobController($services);
    }
}
