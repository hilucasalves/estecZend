<?php

namespace Application\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Application\Entity\Usuario;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;

class UsuarioFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('usuario');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Usuario());

        $this->add(array(
            'name' => 'idUsuario',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'usuarioTipo',
            'attributes' => array(
                'id' => 'usuarioTipo',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Tipo de Usuário: ',
                'empty_option' => 'Selecione',
                'value_options' => $this->getUsuarioTipo(),
            )
        ));

        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Nome: ',
            ),
        ));

        $this->add(array(
            'name' => 'dataNascimento',
            'type' => 'Date',
            'attributes' => array(
                'class' => 'form-control',
                'min' => '1900-01-01',
                'max' => date('Y-m-d'),
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Data de Nascimento: ',
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'email',
            ),
            'options' => array(
                'label' => 'E-mail: ',
            ),
        ));

        $this->add(array(
            'name' => 'telefoneFixo',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Telefone Fixo: ',
            ),
        ));

        $this->add(array(
            'name' => 'telefoneCelular',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Telefone Celular: ',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusUsuario',
            'attributes' => array(
                'id' => 'statusUsuario',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status: ',
                'value_options' => array(
                    'A' => 'Ativo',
                    'I' => 'Inativo',
                ),
            )
        ));
    }

    private function getUsuarioTipo() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        $usuarios = $em->getRepository('Application\Entity\UsuarioTipo')->findAll();

        foreach ($usuarios as $usuario) {
            $valueOptions[$usuario->__get('idUsuarioTipo')] = $usuario->__get('nome');
        }
        return $valueOptions;
    }

    public function getInputFilterSpecification() {
        return array(
            'nome' => array(
                'required' => true,
            ),
            'dataNascimento' => array(
                'required' => true,
            ),
            'email' => array(
                'required' => true,
            ),
            'usuarioTipo' => array(
                'required' => true,
            ),
        );
    }

}
