<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => 'Openvpn\\V1\\Rpc\\GetClientConfig\\GetClientConfigControllerFactory',
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
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'openvpn.rpc.get-client-config',
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
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => array(
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
        ),
    ),
    'zf-content-validation' => array(
        'Openvpn\\V1\\Rpc\\GetClientConfig\\Controller' => array(
            'input_filter' => 'Openvpn\\V1\\Rpc\\GetClientConfig\\Validator',
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
    ),
);
