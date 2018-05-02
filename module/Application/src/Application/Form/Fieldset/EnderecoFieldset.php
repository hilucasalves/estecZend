<?php

namespace Application\Form\Fieldset;

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
            ),
        ));


        $this->add(array(
            'name' => 'tipoLogradouro',
            'type' => 'select',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Tipo', //nome campo
                'value_options' => array(
                    '1' => 'Rua',
                    '2' => 'Avenida',
                    '3' => 'Praça'
                ),
            )
        ));

        $this->add(array(
            'name' => 'bairro',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Bairro',
            ),
        ));

        $this->add(array(
            'name' => 'cidade',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Cidade',
            ),
        ));

        $this->add(array(
            'name' => 'estado',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Estado',
            ),
        ));

        $this->add(array(
            'name' => 'cep',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'CEP',
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
                'required' => true
            ),
        );
    }

}
