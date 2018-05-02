<?php

namespace Usuario\form;

use Uaitec\Form\AbstractForm;

class UsuarioFeriasForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('usuarioFerias'); //nome formulario
        $this->setAttribute('method', 'post');

        /* Paramentros 'nome', tipo, 'label' */
        $this->addElement('idUsuarioFerias', 'hidden', 'idUsuarioFerias');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'usuario',
            'attributes' => array(               
                 'id' => 'comboboxTipo'
                
            ),
            'options' => array(
                'label' => 'Usuario: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getUsuarios(),
            )
        ));

        $this->add(array(
            'name' => 'inicioFerias',
            'type' => 'Date',
            'options' => array(
                'label' => 'Data Início',
                'format' => 'Y-m-d'
            ),
            'attributes' => array(
                'step' => '1',
                'class' => 'form-control',
                'id' => 'inicioFerias'
            )
        ));

        $this->add(array(
            'name' => 'fimFerias',
            'type' => 'Date',
            'options' => array(
                'label' => 'Data Fim ',
                'format' => 'Y-m-d'
            ),
            'attributes' => array(
                'step' => '1',
                'class' => 'form-control',
                'id' => 'fimFerias'
            )
        ));

             $this->add(array(
            'name' => 'enviar',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-success'
            ),
            'options' => array(
                'label' => 'Salvar',
            ),
        ));
    }

    private function getUsuarios() {
        $valueOptions = array();

        $dql = "select u from Usuario\Entity\Usuario u WHERE u.statusUsuario = 'A' order by u.nome";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $usuarios = $query->getResult();


        foreach ($usuarios as $usuario) {

            $valueOptions[$usuario->__get('idUsuario')] = $usuario->__get('nome');
        }
        return $valueOptions;
    }

}
