<?php
return array(
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'radius\\V1' => 'status',
            ),
        ),
    ),
    'db' => array(
        'adapters' => array(
            'Db\\Radius_Prod' => array(),
            'Db\\Radius_Dev' => array(),
        ),
    ),
);
