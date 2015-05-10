<?php
return array(
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'Status\\V1' => 'status',
            ),
        ),
    ),
    'db' => array(
        'adapters' => array(
            'Db\\Radius_test' => array(),
        ),
    ),
);
