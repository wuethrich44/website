<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Subject\Controller\Subject' => 'Subject\Controller\SubjectController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'subject' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/subject[/][:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Subject\Controller\Subject',
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
            'subject' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'admin' => array(
            array(
                'label' => 'Module',
                'route' => 'zfcadmin/subject',
                'resource' => 'controller/Subject\Controller\Subject',
                'pages' => array(
                    array(
                        'label' => 'Add',
                        'route' => 'zfcadmin/subject',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Edit',
                        'route' => 'zfcadmin/subject',
                        'action' => 'edit',
                    ),
                    array(
                        'label' => 'Delete',
                        'route' => 'zfcadmin/subject',
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
