<?php

// module/Album/config/module.config.php:
return array(
    'controllers' => array(
        'invokables' => array(
            'Front\Controller\Index' => 'Front\Controller\IndexController',
            'Front\Controller\Album' => 'Front\Controller\AlbumController',
            'Front\Controller\Web' => 'Front\Controller\WebController',
            'Front\Controller\Category' => 'Front\Controller\CategoryController',
            'Front\Controller\Page' => 'Front\Controller\PageController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Album',
                        'action'     => 'index',
                    ),
                ),
            ),
            'index' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/index[/:action][/:id][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'web' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/web[/:action][/:categoryUrl][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'categoryUrl' => '[a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Web',
                    ),
                ),
            ),
            'webShow' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/web[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Web',
                    ),
                ),
            ),
            'page' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/page[/:action][/:id][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Page',
                        'action'     => 'index',
                    ),
                ),
            ),
            'category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/category[/:action][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Front\Controller\Category'
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml'
        ),
        'template_path_stack' => array(
            'front' => __DIR__ . '/../view',
        ),
        'helper_map' => array(
            'Zend\Form\View\HelperLoader',
            'RequestHelper' => '\Front\View\Helper\RequestHelper',
        ),
    ),
    'translator' => array(
        'locale' => 'pl_PL',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
);