<?php
namespace Openvpn\V1\Rpc\DeleteClientParam;

class DeleteClientParamControllerFactory
{
    public function __invoke($controllers)
    {
        $services = $controllers->getServiceLocator();
        return new DeleteClientParamController($services);
    }
}
