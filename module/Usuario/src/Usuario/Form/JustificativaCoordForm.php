<?php

namespace Usuario\form;

use Uaitec\Form\AbstractForm;

class JustificativaCoordForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('justificativaForm'); //nome formulario
        $this->setAttribute('method', 'post');

        /* Paramentros 'nome', tipo, 'label' */
        $this->addElement('idUsuarioRegistro', 'hidden', 'idUsuarioRegistro');

        $this->add(array(
            'name' => 'descricao',           
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control',
                 'required' => true
            ),
            'options' => array(
                'label' => 'Descrição',                
            ),
        ));

        $this->add(array(
            'name' => 'enviar',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-danger'
            ),
            'options' => array(
                'label' => 'Salvar',
            ),
        ));
    }

}
