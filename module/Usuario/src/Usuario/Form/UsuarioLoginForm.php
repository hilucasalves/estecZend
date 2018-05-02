<?php

namespace Usuario\form;

use Uaitec\Form\AbstractForm;

class UsuarioLoginForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('usuarioLogin'); //nome formulario
        $this->setAttribute('method', 'post');

        /* Paramentros 'nome', tipo, 'label' */
        $this->addElement('idLogin', 'hidden', 'idLogin');
        $this->addElement('nome', 'text', 'Nome');
        $this->addElement('email', 'text', 'Email');   
       
        $this->addElement('cpf', 'text', 'CPF');
        $this->addElement('enviar', 'submit', 'Salvar');

        $options = array('value_options' => $this->getLoginStatus());
        $this->addElement('status', 'select', 'Status', array(), $options);
    }

  }
