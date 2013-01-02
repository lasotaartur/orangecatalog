<?php

namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {       

        $form = new \Front\Form\CatalogForm();
        $sm = $this->getServiceLocator();
        $categoryTable = $sm->get('Front\Model\CategoryTable');
        $categoryTree = $categoryTable->getTree();
        
        $categoryOptions = array_merge(
                $form->get('category_parent')->getValueOptions(), 
                array_map(function($category){return $category->name;}, $categoryTree)
        );
        $form->get('category_parent')->setValueOptions($categoryOptions);
        $form->get('category_parent2')->setValueOptions($categoryOptions);
        $indexColumnsCount = 4;
        $categoryTreeParts = array_chunk($categoryTree, ceil(count($categoryTree)/$indexColumnsCount));

        return array(
            'form' => $form,
            'tags' => $sm->get('Front\Model\TagTable')->fetchAll(),
            'categoryTreeParts' => $categoryTreeParts
        );
    }
    
    
    public function formAction() {
        $view = new ViewModel();
        $view->setTerminate(true);
        return $view;
    }

}