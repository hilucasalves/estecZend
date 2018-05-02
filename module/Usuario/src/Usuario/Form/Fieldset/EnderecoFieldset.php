<?php

namespace Usuario\Form\Fieldset;

use Zend\Form\Fieldset;
use Usuario\Entity\UsuarioEndereco;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EnderecoFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('endereco');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new UsuarioEndereco());

        $this->add(array(
            'name' => 'idEndereco',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'logradouro',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Logradouro',
                'id' => 'logradouro'
            ),
        ));


        $this->add(array(
            'name' => 'tipoLogradouro',
            'type' => 'select',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'tipoLogradouro',
            ),
            'options' => array(
                'label' => 'Tipo', //nome campo
                'empty_option' => 'Selecione',
                'value_options' => array(
                    '1' => 'Rua',
                    '2' => 'Avenida',
                    '3' => 'Praça',
                    '4' => 'Estrada',
                    '5' => 'Beco',
                    '6' => 'Travessa',
                    '7' => 'Outros'
                ),
            )
        ));

        $this->add(array(
            'name' => 'bairro',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Bairro',
                'id' => 'bairro'
            ),
        ));

        $this->add(array(
            'name' => 'cidade',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Cidade',
                'id' => 'cidade',
                'readonly' => 'readonly'
            ),
        ));

        $this->add(array(
            'name' => 'estado',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Estado',
                'id' => 'estado',
                'readonly' => 'readonly'
            ),
        ));

        $this->add(array(
            'name' => 'cep',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'CEP',
                'id' => 'cep'
            ),
        ));

        $this->add(array(
            'name' => 'numero',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Número',
            ),
        ));

        $this->add(array(
            'name' => 'complemento',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Complemento',
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'logradouro' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'Uaitec\Filter\Capitalise'),
                ),
            ),
            'complemento' => array(
                'required' => false
            ),
            'bairro' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'Uaitec\Filter\Capitalise'),
                ),
            ),
            'cidade' => array(
                'required' => true
            ),
            'estado' => array(
                'required' => true
            ),
        );
    }

}
