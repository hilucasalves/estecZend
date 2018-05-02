<?php

namespace Usuario\form;

use Uaitec\Form\AbstractForm;

class UsuarioTipoForm extends AbstractForm
{

    public function __construct($name = null)
    {
        parent::__construct('usuarioTipo'); //nome formulario
        $this->setAttribute('method', 'post');

        /* Paramentros 'nome', tipo, 'label' */
        $this->addElement('idUsuarioTipo', 'hidden', 'idUsuarioTipo');

        $this->addElement('nome', 'text', 'Nome');
        $this->addElement('enviar', 'submit', 'Salvar');
    

    }

}
