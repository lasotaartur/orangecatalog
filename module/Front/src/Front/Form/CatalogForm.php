<?php

// module/Album/src/Album/Form/AlbumForm.php:

namespace Front\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class CatalogForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('catalogForm');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'www',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Adres strony',
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Tytuł',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Opis',
            ),
        ));
        $this->add(array(
            'name' => 'keywords',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Słowa kluczowe',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'category_parent',
            'options' => array(
                'label' => 'Kategoria',
                'value_options' => array(0 => '---wybierz---')
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_category',
            'options' => array(
                'label' => 'Podkategoria',
                'value_options' => array('' => '---wybierz---')
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'category_parent2',
            'options' => array(
                'label' => 'Kategoria 2',
                'value_options' => array(0 => '---wybierz---')
            ),
            'required' => true
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'id_category2',
            'options' => array(
                'label' => 'Podkategoria 2',
                'value_options' => array(0 => '---wybierz---')
            )
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => '+ Dodaj do katalogu',
                'id' => 'submitButton',
            ),
        ));
    }

}