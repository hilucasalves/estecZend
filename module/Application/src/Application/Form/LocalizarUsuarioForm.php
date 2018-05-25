<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class LocalizarUsuarioForm extends AbstractForm {

    public function __construct($name = null) {

        parent::__construct('localizarUsuarioForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'form-inline');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'usuario',
            'attributes' => array(
                'id' => 'usuario',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Usuário: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getUsuario(),
            )
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
                'empty_option' => 'Todos',
                'value_options' => $this->getUsuarioTipo(),
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusUsuario',
            'attributes' => array(
                'id' => 'status',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status: ',
                'empty_option' => 'Todos',
                'value_options' => array(
                    'A' => 'Ativo',
                    'I' => 'Inativo',
                ),
            )
        ));

        $this->add(array(
            'type' => 'submit',
            'name' => 'enviar',
            'attributes' => array(
                'class' => 'btn btn-info',
                'value' => 'Localizar'
            ),
        ));
    }

    private function getUsuario() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        $usuarios = $em->getRepository('Application\Entity\Usuario')->findAll();

        foreach ($usuarios as $usuario) {
            $valueOptions[$usuario->__get('idUsuario')] = $usuario->__get('nome');
        }
        return $valueOptions;
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

}
