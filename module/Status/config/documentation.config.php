<?php
return array(
    'Status\\V1\\Rest\\Status\\Controller' => array(
        'description' => 'Create, manipulate, and retrieve status messages.',
        'collection' => array(
            'description' => 'Manipulate lists of status messages.',
            'GET' => array(
                'description' => 'Retrieve a paginated list of status messages.',
                'response' => '',
            ),
            'POST' => array(
                'description' => 'Create a new status messages.',
            ),
        ),
        'entity' => array(
            'description' => 'Manipulate and retrieve individual status messages.',
            'GET' => array(
                'description' => 'Retrieve a status message.',
            ),
            'PATCH' => array(
                'description' => 'Update a status message.',
            ),
            'PUT' => array(
                'description' => 'Replace a status message.',
            ),
            'DELETE' => array(
                'description' => 'Delete a status message.',
            ),
        ),
    ),
    'Status\\V1\\Rest\\Test\\Controller' => array(
        'description' => 'Create, manipulate, and retrieve status messages.',
        'collection' => array(
            'description' => 'Manipulate lists of status messages.',
        ),
        'entity' => array(
            'description' => 'Manipulate and retrieve individual status messages.',
            'GET' => array(
                'description' => 'Retrieve a status message.',
            ),
            'PATCH' => array(
                'description' => 'Update a status message.',
            ),
            'PUT' => array(
                'description' => 'Replace a status message.',
            ),
            'DELETE' => array(
                'description' => 'Delete a status message.',
            ),
        ),
    ),
);
