<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'File\Controller\File' => 'File\Controller\FileController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'file' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/file[/][:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'File\Controller\File',
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
            'file' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'admin' => array(
            array(
                'label' => 'Dateien',
                'route' => 'zfcadmin/file',
                'resource' => 'controller/File\Controller\File',
                'pages' => array(
                    array(
                        'label' => 'Edit',
                        'route' => 'zfcadmin/file',
                        'action' => 'edit',
                    ),
                    array(
                        'label' => 'Delete',
                        'route' => 'zfcadmin/file',
                        'action' => 'delete',
                    ),
                ),
            ),
        ),
    ),
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'File\Controller\File', 'roles' => array('admin')),
            ),
        ),
    ),
);
