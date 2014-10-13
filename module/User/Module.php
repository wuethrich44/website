<?php

namespace User;

use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\EventManager\EventInterface;
use Zend\Filter\PregReplace;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface
{

    public function onBootstrap(EventInterface $e)
    {
        $events = $e->getApplication()->getEventManager()->getSharedManager();
        $config = $e->getApplication()->getServiceManager()->get('Config');

        $onlyHsluEmail = $config['user_registration']['only_hslu_email'];

        // Modify RegisterForm
        $events->attach('ZfcUser\Form\Register', 'init',
            function($e) use ($onlyHsluEmail) {
            $form = $e->getTarget();
            if ($form->has('username')) {
                $form->get('username')->setAttribute('class', 'form-control');
            }
            if ($form->has('display_name')) {
                $form->get('display_name')->setAttribute('class', 'form-control');
            }
            $form->get('email')->setAttribute('class', 'form-control');
            $form->get('password')->setAttribute('class', 'form-control');
            $form->get('passwordVerify')->setAttribute('class', 'form-control');
            $form->get('submit')->setAttribute('class', 'btn btn-default');

            if ($onlyHsluEmail) {
                $form->remove('email');
                $email = new \Zend\Form\Element\Text('email',
                    array('label' => 'Email', 'add-on-append' => '@stud.hslu.ch'));
                $form->add($email, array('priority' => 1));
            }
        });

        $events->attach('ZfcUser\Form\RegisterFilter', 'init',
            function($e) use ($onlyHsluEmail) {
            $filter = $e->getTarget();
            if ($onlyHsluEmail) {
                // Attach @stud.hslu.ch at the end of the email
                $filter->get('email')->getFilterChain()->attach(new PregReplace(array(
                    'pattern' => '/$/',
                    'replacement' => '@stud.hslu.ch',
                )));
            }
        });

        // Modify ChangePasswordForm
        $events->attach('ZfcUser\Form\ChangePassword', 'init',
            function($e) {
            $form = $e->getTarget();
            $form->get('submit')->setAttribute('class', 'btn btn-default');
        });

        // Modify ChangeEmailForm
        $events->attach('ZfcUser\Form\ChangeEmail', 'init',
            function($e) {
            $form   = $e->getTarget();
            $button = new \Zend\Form\Element\Button('Submit',
                array('label' => 'Submit'));
            $button->setAttribute('type', 'submit');
            $form->add($button);
        });
    }

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
}
