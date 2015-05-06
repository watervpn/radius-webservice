<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Status\\V1\\Rpc\\Ping\\Controller' => 'Status\\V1\\Rpc\\Ping\\PingControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'status.rpc.ping' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/test/ping',
                    'defaults' => array(
                        'controller' => 'Status\\V1\\Rpc\\Ping\\Controller',
                        'action' => 'ping',
                    ),
                ),
            ),
            'status.rest.status' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/status[/:status_id]',
                    'defaults' => array(
                        'controller' => 'Status\\V1\\Rest\\Status\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'status.rpc.ping',
            1 => 'status.rest.status',
        ),
    ),
    'zf-rpc' => array(
        'Status\\V1\\Rpc\\Ping\\Controller' => array(
            'service_name' => 'Ping',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'status.rpc.ping',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Status\\V1\\Rpc\\Ping\\Controller' => 'Json',
            'Status\\V1\\Rest\\Status\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Status\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Status\\V1\\Rest\\Status\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Status\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
            ),
            'Status\\V1\\Rest\\Status\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Status\\V1\\Rpc\\Ping\\Controller' => array(
            'input_filter' => 'Status\\V1\\Rpc\\Ping\\Validator',
        ),
        'Status\\V1\\Rest\\Status\\Controller' => array(
            'input_filter' => 'Status\\V1\\Rest\\Status\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Status\\V1\\Rpc\\Ping\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'ack',
                'description' => 'Acknowledge the request with a timestamp',
            ),
        ),
        'Status\\V1\\Rest\\Status\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Regex',
                        'options' => array(
                            'pattern' => '/^(mwop|andi|zeev)$/',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'user',
                'description' => 'The user submitting the status message',
                'error_message' => 'You must provide a valid user.',
            ),
            1 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Digits',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'timestamp',
                'description' => 'The timestamp when the status message was last modified.',
                'error_message' => 'You must provide a timestamp.',
            ),
            2 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '140',
                        ),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Zend\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                ),
                'name' => 'message',
                'description' => 'A status message of no more than 140 characters',
                'error_message' => 'A status message must contain between 1 and 140 characters',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Status\\V1\\Rest\\Status\\StatusResource' => 'Status\\V1\\Rest\\Status\\StatusResourceFactory',
        ),
    ),
    'zf-rest' => array(
        'Status\\V1\\Rest\\Status\\Controller' => array(
            'listener' => 'Status\\V1\\Rest\\Status\\StatusResource',
            'route_name' => 'status.rest.status',
            'route_identifier_name' => 'status_id',
            'collection_name' => 'status',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'StatusLib\\Entity',
            'collection_class' => 'StatusLib\\Collection',
            'service_name' => 'Status',
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Status\\V1\\Rest\\Status\\StatusEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'status.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Status\\V1\\Rest\\Status\\StatusCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'status.rest.status',
                'route_identifier_name' => 'status_id',
                'is_collection' => true,
            ),
            'StatusLib\\Entity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'status.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'StatusLib\\Collection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'status.rest.status',
                'route_identifier_name' => 'status_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Status\\V1\\Rest\\Status\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
        ),
    ),
);
