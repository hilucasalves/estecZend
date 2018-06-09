<?php

namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;

class AlterarSenhaFilter extends InputFilter {

    public function __construct() {
        $this->add(array(
            'name' => 'idUsuario',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'Int'
                ),
            ),
        ));

        $this->add(array(
            'name' => 'senha',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 8
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'senhaConfirmacao',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Alnum',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 8
                    ),
                ),
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'senha'
                    )
                )
            )
        ));
    }

}
