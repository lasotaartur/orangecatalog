<?php

namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class CategoryController extends AbstractActionController
{
    
    /**
     * 
     * @return type
     */
    public function ajaxgetchildrenselectAction()
    {
        $request = $this->getRequest();
        $categoryOptions = array();
        if ($request->isPost()) {
            $post = $request->getPost(); 
            $categoryOptions = array(0 => '--wybierz--');
            if($post['category'] > 0) {
                $sm = $this->getServiceLocator();
                $categoryTable = $sm->get('Front\Model\CategoryTable');
                $categoryTree = $categoryTable->getTree($post['category']);
                $categoryOptions = array_merge($categoryOptions,
                        array_map(function($category) {
                                    return $category->name;
                                }, $categoryTree)
                );
            }
        }
        $json = new \Zend\View\Model\JsonModel($categoryOptions);
        echo $json->serialize();
        die;
    }

}