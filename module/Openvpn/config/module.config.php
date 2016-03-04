<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => 'Openvpn\\V1\\Rpc\\GetClientConfig\\GetClientConfigControllerFactory',
            'Openvpn\\V1\\Rpc\\GetServerStatus\\Controller' => 'Openvpn\\V1\\Rpc\\GetServerStatus\\GetServerStatusControllerFactory',
            'Openvpn\\V1\\Rpc\\FetchServerStatusJob\\Controller' => 'Openvpn\\V1\\Rpc\\FetchServerStatusJob\\FetchServerStatusJobControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'openvpn.rpc.get-client-config' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/openvpn/getClientConfig',
                    'defaults' => array(
                        'controller' => 'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller',
                        'action' => 'getClientConfig',
                    ),
                ),
            ),
            'openvpn.rpc.get-server-status' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/openvpn/getServerStatus',
                    'defaults' => array(
                        'controller' => 'Openvpn\\V1\\Rpc\\GetServerStatus\\Controller',
                        'action' => 'getServerStatus',
                    ),
                ),
            ),
            'openvpn.rpc.fetch-server-status-job' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/openvpn/fetchServerStatusJob',
                    'defaults' => array(
                        'controller' => 'Openvpn\\V1\\Rpc\\FetchServerStatusJob\\Controller',
                        'action' => 'fetchServerStatusJob',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'openvpn.rpc.get-client-config',
            1 => 'openvpn.rpc.get-server-status',
            2 => 'openvpn.rpc.fetch-server-status-job',
        ),
    ),
    'zf-rpc' => array(
        'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => array(
            'service_name' => 'getClientConfig',
            'http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'route_name' => 'openvpn.rpc.get-client-config',
        ),
        'Openvpn\\V1\\Rpc\\GetServerStatus\\Controller' => array(
            'service_name' => 'getServerStatus',
            'http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'route_name' => 'openvpn.rpc.get-server-status',
        ),
        'Openvpn\\V1\\Rpc\\FetchServerStatusJob\\Controller' => array(
            'service_name' => 'fetchServerStatusJob',
            'http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'route_name' => 'openvpn.rpc.fetch-server-status-job',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => 'Json',
            'Openvpn\\V1\\Rpc\\GetServerStatus\\Controller' => 'Json',
            'Openvpn\\V1\\Rpc\\FetchServerStatusJob\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => array(
                0 => 'application/vnd.openvpn.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Openvpn\\V1\\Rpc\\GetServerStatus\\Controller' => array(
                0 => 'application/vnd.openvpn.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Openvpn\\V1\\Rpc\\FetchServerStatusJob\\Controller' => array(
                0 => 'application/vnd.openvpn.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => array(
                0 => 'application/vnd.openvpn.v1+json',
                1 => 'application/json',
            ),
            'Openvpn\\V1\\Rpc\\GetServerStatus\\Controller' => array(
                0 => 'application/vnd.openvpn.v1+json',
                1 => 'application/json',
            ),
            'Openvpn\\V1\\Rpc\\FetchServerStatusJob\\Controller' => array(
                0 => 'application/vnd.openvpn.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => array(
            'input_filter' => 'Openvpn\\V1\\Rpc\\GetClientConfig\\Validator',
        ),
        'Openvpn\\V1\\Rpc\\GetServerStatus\\Controller' => array(
            'input_filter' => 'Openvpn\\V1\\Rpc\\GetServerStatus\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Openvpn\\V1\\Rpc\\GetClientConfig\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'account',
                'description' => 'accountid',
                'error_message' => 'Account parameter is required',
                'continue_if_empty' => false,
            ),
            1 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'server',
                'description' => 'vpn server location',
                'error_message' => 'Server parameter is required',
                'continue_if_empty' => false,
            ),
        ),
        'Openvpn\\V1\\Rpc\\GetServerStatus\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'host',
                'description' => 'host or server name
example ca1, us1, jp2',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => array(
                'actions' => array(
                    'getClientConfig' => array(
                        'GET' => true,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ),
                ),
            ),
            'Openvpn\\V1\\Rpc\\FetchServerStatusJob\\Controller' => array(
                'actions' => array(
                    'fetchServerStatusJob' => array(
                        'GET' => true,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ),
                ),
            ),
            'Openvpn\\V1\\Rpc\\GetServerStatus\\Controller' => array(
                'actions' => array(
                    'getServerStatus' => array(
                        'GET' => true,
                        'POST' => true,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ),
                ),
            ),
        ),
    ),
);
