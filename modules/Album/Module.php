<?php

namespace Album;

use InvalidArgumentException,
    Zend\Module\Manager,
    Zend\Config\Config,
    Zend\Loader\AutoloaderFactory;

class Module
{
    public function init(Manager $moduleManager)
    {
        $this->initAutoloader();
    }

    protected function initAutoloader()
    {
        AutoloaderFactory::factory(array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    public function getConfig($env = null)
    {
        $config = new Config(include __DIR__ . '/configs/module.config.php');
        if (null === $env) {
            return $config;
        }
        if (!isset($config->{$env})) {
            throw new InvalidArgumentException(sprintf(
                'Unknown environment "%s" provided to "%s\\%s"',
                $env,
                __NAMESPACE__,
                __METHOD__
            ));
        }
        return $config->{$env};
    }

}
