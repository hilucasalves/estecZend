<?php

namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{

    public function __construct()
    {

        $this->add(array(
            'name' => 'cpf',
            'required' => true,
            'filters' => array(
                array('name' => 'Digits'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name' => 'senha',
            'required' => false,
             'allow_empty' => TRUE,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Empty',
                    'options' => array(
                        'encoding' => 'UTF-8',
                    )
                )
            )
        ));
    }

}
