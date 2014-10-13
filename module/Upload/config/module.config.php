<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Upload\Controller\Upload' => 'Upload\Controller\UploadController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'upload' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/upload',
                            'defaults' => array(
                                'controller' => 'Upload\Controller\Upload',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'upload' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'admin' => array(
            array(
                'label' => 'Upload',
                'route' => 'zfcadmin/upload',
                'resource' => 'controller/Upload\Controller\Upload',
            ),
        ),
    ),
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'Upload\Controller\Upload', 'roles' => array('user')),
            ),
        ),
    ),
);
