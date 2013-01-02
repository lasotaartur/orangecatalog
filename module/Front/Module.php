<?php

namespace Front;

// Add these import statements:
use Front\Model;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{

    public function onBootstrap() 
    { 
        $translator = new \Zend\I18n\Translator\Translator();
        $translator->setLocale('pl_PL');
        $translator->addTranslationFile(
            'phpArray',
            'resources/languages/pl/Zend_Validate.php',
            'default',
            'pl_PL'
        );
//        $translator->addTranslationFile(
//            locale' => 'de',
//            'content' => '/home/alex/web/www/sob.lan/www/data/langs',
//            'scan' => 'filename',
//            'disableNotices' => f
//        );
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    } 
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
        // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Front\Model\AlbumTable' => function($sm) {
                    $tableGateway = $sm->get('AlbumTableGateway');
                    $table = new Model\AlbumTable($tableGateway);
                    return $table;
                },
                'AlbumTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
                'Front\Model\WebTable' => function($sm) {
                    $tableGateway = $sm->get('WebTableGateway');
                    $table = new Model\WebTable($tableGateway);
                    return $table;
                },
                'WebTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Web());
                    return new TableGateway('web', $dbAdapter, null, $resultSetPrototype);
                },
                'Front\Model\CategoryTable' => function($sm) {
                    $tableGateway = $sm->get('CategoryTableGateway');
                    $table = new Model\CategoryTable($tableGateway);
                    return $table;
                },
                'CategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $category = new Model\Category();
                    $category->setServiceManager($sm);
                    $resultSetPrototype->setArrayObjectPrototype($category);
                    return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
                },
                'Front\Model\TagTable' => function($sm) {
                    $tableGateway = $sm->get('TagTableGateway');
                    $table = new Model\TagTable($tableGateway);
                    return $table;
                },
                'TagTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Tag());
                    return new TableGateway('tag', $dbAdapter, null, $resultSetPrototype);
                },
//                'RequestHelper' => function($sm){
//                   $helper = new \Front\View\Helper\RequestHelper();
//                   $helper->setRequest($sm->get('Request')); 
//                   return $helper;
//                }

                
            ),
        );
    }
    
    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                // the array key here is the name you will call the view helper by in your view scripts
                'request' => function($sm) {
                   $helper = new \Front\View\Helper\RequestHelper();
                   $locator = $sm->getServiceLocator(); // $sm is the view helper manager, so we need to fetch the main service manager
                   $helper->setRequest($locator->get('Request')); 
                   return $helper;
                },
            ),
        );
    }

}