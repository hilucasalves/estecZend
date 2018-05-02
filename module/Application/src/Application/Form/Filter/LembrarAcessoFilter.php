<?php

namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Db\Adapter\Adapter;

class LembrarAcessoFilter extends InputFilter
{

    public function __construct()
    {

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'emailAddress',
                ),
            ),
        ));
    }

}
