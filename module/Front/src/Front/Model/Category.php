<?php

namespace Front\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class Category extends Common\Orm\EntityAbstract implements InputFilterAwareInterface, ServiceManagerAwareInterface {

    public $id;
    public $name;
    public $idParent;
    public $url;
    public $children = array();
    private $countWeb = null;
    protected $inputFilter;
    protected $serviceManager;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->idParent = (isset($data['idParent'])) ? $data['idParent'] : null;
        $this->url = (isset($data['url'])) ? $data['url'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
                    )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'name',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100,
                                ),
                            ),
                        ),
                    )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'idParent',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
                    )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'url',
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        )
                    )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getIdParent() {
        return $this->idParent;
    }

    public function setIdParent($idParent) {
        $this->idParent = $idParent;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getChildren() {
        return $this->children;
    }

    public function setChildren($children) {
        $this->children = $children;
    }

    public function getCountWeb() {
        if ($this->countWeb == null) {
            $sm = $this->getServiceManager();
            $webTable = $sm->get('Front\Model\WebTable');
            $webs = $webTable->fetchAll(array('id_category' => $this->id));
            $this->countWeb = count($webs);
        }
        return $this->countWeb;
    }

    public function setCountWeb($countWeb) {
        $this->countWeb = $countWeb;
    }

    public function setServiceManager(ServiceManager $serviceManager) {

        $this->serviceManager = $serviceManager;

        return $this;
    }

    public function getServiceManager() {

        return $this->serviceManager;
    }

}