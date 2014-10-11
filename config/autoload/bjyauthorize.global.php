<?php

return array(
    'bjyauthorize' => array(
        'default_role' => 'guest',
        'identity_provider' => 'BjyAuthorize\Provider\Identity\ZfcUserZendDb',
        'role_providers' => array(
            'BjyAuthorize\Provider\Role\ZendDb' => array(
                'table' => 'user_role',
                'identifier_field_name' => 'id',
                'role_id_field' => 'role_id',
                'parent_role_field' => 'parent_id',
            ),
        ),
        // resource providers provide a list of resources that will be tracked
        // in the ACL. like roles, they can be hierarchical
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'pants' => array(),
            ),
        ),
        /* rules can be specified here with the format:
         * array(roles (array), resource, [privilege (array|string), assertion])
         * assertions will be loaded using the service manager and must implement
         * Zend\Acl\Assertion\AssertionInterface.
         * *if you use assertions, define them using the service manager!*
         */
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    // allow guests and users (and admins, through inheritance)
                    // the "wear" privilege on the resource "pants"
                    array(array('guest', 'user'), 'pants', 'wear')
                ),
                // Don't mix allow/deny rules if you are using role inheritance.
                // There are some weird bugs.
                'deny' => array(
                // ...
                ),
            ),
        ),
        /* 
         * We use only the controller guard. controller rules are specified in the
         * corresponding module-config.
         */
        'guards' => array(
            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all controllers and actions.
             */
            'BjyAuthorize\Guard\Controller' => array(),
        ),
    ),
);
