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
            'radius_prod' => array(),
            'webserver_prod' => array(),
        ),
    ),
);
