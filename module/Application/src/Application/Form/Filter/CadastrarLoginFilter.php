<?php

namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Db\Adapter\Adapter;
use Uaitec\Filter\Capitalise;

class CadastrarLoginFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'idLogin',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'Int'
                ),
            ),
        ));


        $this->add(array(
            'name' => 'status',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'Int'
                )
            )
        ));


        $this->add(array(
            'name' => 'nome',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 45
                    )
                )
            )
        ));

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
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'login',
                        'field' => 'email',
                        'adapter' => $adapter = new Adapter(array(
                    'driver' => 'Mysqli',
                    'database' => 'tecnologia',
                    'username' => 'root',
                    'password' => '#InoVacao@2014#'
                        )),
                        'messages' => array(
                            \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'Esse email já foi cadastrado.'
                        ),
                    ),
                )
            ),
        ));

        $this->add(array(
            'name' => 'emailConfirmacao',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'email'
                    )
                )
            )
        ));


        $this->add(array(
            'name' => 'cpf',
            'required' => true,
            'filters' => array(
                array('name' => 'Digits'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\Db\NoRecordExists',
                    'options' => array(
                        'table' => 'login',
                        'field' => 'cpf',
                        'adapter' => $adapter = new Adapter(array(
                    'driver' => 'Mysqli',
                    'database' => 'tecnologia',
                    'username' => 'root',
                    'password' => '#InoVacao@2014#'
                        )),
                        'messages' => array(
                            \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'Esse CPF já foi cadastrado.'
                        ),
                    ),
                )
            )
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
