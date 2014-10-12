<?php

namespace Authorization;

class Module
{

    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap($e)
    {
        $sm = $e->getApplication()->getServiceManager();

        $authorize = $sm->get('BjyAuthorizeServiceAuthorize');
        $acl       = $authorize->getAcl();
        $role      = $authorize->getIdentity();

        \Zend\View\Helper\Navigation::setDefaultAcl($acl);
        \Zend\View\Helper\Navigation::setDefaultRole($role);
    }
}
