<?php
namespace Openvpn\V1\Rpc\SetClientParam;

class SetClientParamControllerFactory
{
    public function __invoke($controllers)
    {
        $services = $controllers->getServiceLocator();
        return new SetClientParamController($services);
    }
}
