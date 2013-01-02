<?php

namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Front\Model\Web,
    Front\Form\CatalogForm;

class WebController extends AbstractActionController {

    public function indexAction() {
        $sm = $this->getServiceLocator();
        $categoryTable = $sm->get('Front\Model\CategoryTable');
        
        $categoryList = $categoryTable->fetchAll(
                array('url' => $this->params()->fromRoute('categoryUrl')), array(array('sort' => 'name', 'order' => 'ASC')));
        /* @var $category \Front\Model\Category */
        $category = $categoryList->current();

        /* @var $webTable \Front\Model\WebTable  */
        $webTable = $sm->get('Front\Model\WebTable');
        $webs = $webTable->fetchAll(array('id_category' => $category->id));

        $matches = $this->getEvent()->getRouteMatch();
        $page = $matches->getParam('page', 1);

        $paginator = new \Zend\Paginator\Paginator(new
                        \Zend\Paginator\Adapter\Iterator($webs)
        );

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(2);

        return array(
            'url' => '/web/index/' . $this->params()->fromRoute('categoryUrl'),
            'categoryTree' => $categoryTable->getTree(),
            'categorySelected' => $category,
            'paginator' => $paginator
        );
    }
    
    public function showAction() {
        $id = $this->params()->fromRoute('id');
        $sm = $this->getServiceLocator();
        $webTable = $sm->get('Front\Model\WebTable');
        return array(
            'web' => $webTable->getWeb($id)
        );
    }

    public function ajaxaddAction() {
        $view = new ViewModel();
        $form = new CatalogForm();

        $sm = $this->getServiceLocator();
        $categoryTable = $sm->get('Front\Model\CategoryTable');
        $categoryTree = $categoryTable->getTree();

        $categoryOptions = array_merge(
                $form->get('category_parent')->getValueOptions(), array_map(function($category) {
                            return $category->name;
                        }, $categoryTree)
        );
        $form->get('category_parent')->setValueOptions($categoryOptions);
        $form->get('category_parent2')->setValueOptions($categoryOptions);



        $request = $this->getRequest();
        if ($request->isPost()) {
            $web = new Web();
            $form->setInputFilter($web->getInputFilter());
            $form->setData($request->getPost());

            $idCategoryParent = $form->get('category_parent')->getValue();
            $idCategoryParent2 = $form->get('category_parent2')->getValue();

            if ($idCategoryParent > 0) {
                $categoryTree = $categoryTable->getTree($idCategoryParent);
                $categoryOptions = array_merge(
                        $form->get('id_category')->getValueOptions(), array_map(function($category) {
                                    return $category->name;
                                }, $categoryTree)
                );
                $form->get('id_category')->setValueOptions($categoryOptions);
//                $form->get('subcategory')->setOptions(array('required' => true));
            }

            if ($idCategoryParent2 > 0) {
                $categoryTree = $categoryTable->getTree($idCategoryParent2);
                $categoryOptions = array_merge(
                        $form->get('id_category2')->getValueOptions(), array_map(function($category) {
                                    return $category->name;
                                }, $categoryTree)
                );
                $form->get('id_category2')->setValueOptions($categoryOptions);
//                $form->get('subcategory2')->setOptions(array('required' => true));
            }

            if ($form->isValid()) {
                $sm = $this->getServiceLocator();
                $web->exchangeArray($form->getData());
                $web->data = date('Y-m-d H:i:s');
                $sm->get('Front\Model\WebTable')->saveWeb($web);

                $view->result = true;
            }
        }

        $view->form = $form;
        $view->setTerminal(true);
        return $view;
    }

    public function ajaxgetmetatagsAction() {
        $meta = array();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $dom = new \Front\Model\Common\Dom();
            $meta = $dom->getMetaTagsByUrl($post['url']);
        }

        $json = new \Zend\View\Model\JsonModel($meta);
        echo $json->serialize();
        die;
    }

}