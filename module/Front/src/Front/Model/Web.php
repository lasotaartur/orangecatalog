<?php

namespace Front\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Web implements InputFilterAwareInterface
{

    public $id;
    public $www;
    public $title;
    public $description;
    public $keywords;
    public $email;
    public $data;
    
    protected $inputFilter;
    private $fields = array(
        'id',
        'www',
        'title',
        'description',
        'keywords',
        'email',
        'id_category',
        'id_category2',
        'data'
    );

    public function exchangeArray($data)
    {
        foreach ($this->fields as $field) {
            $this->$field = (isset($data[$field])) ? $data[$field] : null;
        }
    }

    /**
     * Pobiera dane z argumentow encji w postaci tablicy
     * @return array
     */
    public function getDataArray()
    {
        $data = array();
        foreach ($this->fields as $field) {
            $data[$field] = (isset($this->$field)) ? $this->$field : null;
        }
        return $data;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
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
                        'name' => 'www',
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
                            array(
                                'name' => 'Zend\Validator\Hostname'
                            )
                        ),
                    )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'title',
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
                                    'max' => 255,
                                ),
                            ),
                        ),
                    )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'description',
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
                                    'max' => 500,
                                ),
                            ),
                        ),
                    )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'keywords',
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
                                    'max' => 255,
                                ),
                            ),
                        ),
                    )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'email',
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
                            array(
                                'name' => 'Zend\Validator\EmailAddress'
                            )
                        ),
                    )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'id_category',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
                    )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'id_category2',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
                    )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}