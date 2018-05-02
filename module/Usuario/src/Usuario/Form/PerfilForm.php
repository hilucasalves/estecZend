<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class UsuarioAreaConhecimentoForm extends AbstractForm {

    public function __construct($usuarioTipo, $name = null) {
        parent::__construct('usuarioAreaConhecimento'); //nome formulario
        $this->setAttribute('method', 'post');

       
        $this->addElement('idAreaConhecimento', 'hidden', 'idAreaConhecimento');
        $this->addElement('nome', 'text', 'Nome');
        $this->addElement('status', 'text', 'Status');
               
        $this->addElement('enviar', 'submit', 'Salvar');

    }

}
