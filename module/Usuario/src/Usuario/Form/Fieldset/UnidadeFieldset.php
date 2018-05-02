<?php

namespace Usuario\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Usuario\Entity\UsuarioUnidade;
use Zend\Form\Fieldset;

class UnidadeFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {

        parent::__construct('unidade');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new UsuarioUnidade());

        $this->add(array(
            'name' => 'idUnidade',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Nome',
            ),
        ));

        $this->add(array(
            'name' => 'telefone',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'telefone',
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
            'name' => 'dataInauguracao',
            'attributes' => array(
                'type' => 'date',
            ),
            'options' => array(
                'label' => 'Data inauguracao',
            ),
        ));

        $this->add(array(
            'name' => 'longitude',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Longitude',
            ),
        ));

        $this->add(array(
            'name' => 'latitude',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Latitude',
            ),
        ));

        $this->add(array(
            'name' => 'status',
            'type' => 'radio',
            'options' => array(
                'label' => 'Status', //nome campo
                'value_options' => array(
                    'D' => 'Disponível',
                    'P' => 'Privado',
                    'I' => 'Indisponível'
                )
            )
        ));


        $enderecoFieldset = new EnderecoFieldset($objectManager);
        $enderecoFieldset->setUseAsBaseFieldset(true);
        $this->add($enderecoFieldset);
    }

    public function getInputFilterSpecification()
    {
        return array(
            'nome' => array(
                'required' => true
            ),
            'telefone' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'Digits'),
                    array('name' => 'StringTrim'),
                ),
                'longitude' => array(
                    'required' => true,
                )
            )
        );
    }

}
