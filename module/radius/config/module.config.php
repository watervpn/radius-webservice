<?php
return array(
    'router' => array(
        'routes' => array(
            'radius.rest.account' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/radius/account[/:account_id]',
                    'defaults' => array(
                        'controller' => 'radius\\V1\\Rest\\Account\\Controller',
                    ),
                ),
            ),
            'radius.rest.test' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/radius/test[/:test_id]',
                    'defaults' => array(
                        'controller' => 'radius\\V1\\Rest\\Test\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'radius.rest.account',
            1 => 'radius.rest.test',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'radius\\V1\\Rest\\Account\\AccountResource' => 'radius\\V1\\Rest\\Account\\AccountResourceFactory',
            'radius\\V1\\Rest\\Test\\TestResource' => 'radius\\V1\\Rest\\Test\\TestResourceFactory',
        ),
    ),
    'zf-rest' => array(
        'radius\\V1\\Rest\\Account\\Controller' => array(
            'listener' => 'radius\\V1\\Rest\\Account\\AccountResource',
            'route_name' => 'radius.rest.account',
            'route_identifier_name' => 'account_id',
            'collection_name' => 'account',
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
            'page_size_param' => '25',
            'entity_class' => 'radius\\V1\\Rest\\Account\\AccountEntity',
            'collection_class' => 'radius\\V1\\Rest\\Account\\AccountCollection',
            'service_name' => 'account',
        ),
        'radius\\V1\\Rest\\Test\\Controller' => array(
            'listener' => 'radius\\V1\\Rest\\Test\\TestResource',
            'route_name' => 'radius.rest.test',
            'route_identifier_name' => 'test_id',
            'collection_name' => 'test',
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
            'entity_class' => 'radius\\V1\\Rest\\Test\\TestEntity',
            'collection_class' => 'radius\\V1\\Rest\\Test\\TestCollection',
            'service_name' => 'test',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'radius\\V1\\Rest\\Account\\Controller' => 'HalJson',
            'radius\\V1\\Rest\\Test\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'radius\\V1\\Rest\\Account\\Controller' => array(
                0 => 'application/vnd.radius.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'radius\\V1\\Rest\\Test\\Controller' => array(
                0 => 'application/vnd.radius.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'radius\\V1\\Rest\\Account\\Controller' => array(
                0 => 'application/vnd.radius.v1+json',
                1 => 'application/json',
            ),
            'radius\\V1\\Rest\\Test\\Controller' => array(
                0 => 'application/vnd.radius.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'radius\\V1\\Rest\\Account\\AccountEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'radius.rest.account',
                'route_identifier_name' => 'account_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'radius\\V1\\Rest\\Account\\AccountCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'radius.rest.account',
                'route_identifier_name' => 'account_id',
                'is_collection' => true,
            ),
            'radius\\V1\\Rest\\Test\\TestEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'radius.rest.test',
                'route_identifier_name' => 'test_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'radius\\V1\\Rest\\Test\\TestCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'radius.rest.test',
                'route_identifier_name' => 'test_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'radius\\V1\\Rest\\Account\\Controller' => array(
            'input_filter' => 'radius\\V1\\Rest\\Account\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'radius\\V1\\Rest\\Account\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'passwd',
                'description' => 'Account user password',
            ),
            1 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'options',
                'description' => 'Options (json) to set radius account etc account status, expire, timeout etc..
$option = array(
    \'status\' => \'active\',
    \'expire\' => \'unixtimestamp\'
);',
            ),
            2 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'status',
            ),
            3 => array(
                'required' => false,
                'validators' => array(),
                'filters' => array(),
                'name' => 'id',
                'description' => 'account id or user name',
                'continue_if_empty' => true,
                'allow_empty' => true,
            ),
        ),
    ),
);
