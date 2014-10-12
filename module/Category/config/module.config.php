<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Category\Controller\Category' => 'Category\Controller\CategoryController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'category' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/category[/][:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Category\Controller\Category',
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
            'category' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'admin' => array(
            array(
                'label' => 'Kategorien',
                'route' => 'zfcadmin/category',
                'resource' => 'controller/Category\Controller\Category',
                'pages' => array(
                    array(
                        'label' => 'Add',
                        'route' => 'zfcadmin/category',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Edit',
                        'route' => 'zfcadmin/category',
                        'action' => 'edit',
                    ),
                    array(
                        'label' => 'Delete',
                        'route' => 'zfcadmin/category',
                        'action' => 'delete',
                    ),
                ),
            ),
        ),
    ),
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'Category\Controller\Category', 'roles' => array('admin')),
            ),
        ),
    ),
);
