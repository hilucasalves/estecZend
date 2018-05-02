<?php

namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;

class MensagemFilter extends InputFilter
{

    public function __construct()
    {

        $this->add(array(
            'name' => 'mensagemusuario',
            'required' => false,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1
                        
                    )
                )
            )
        ));
       
    }

}
