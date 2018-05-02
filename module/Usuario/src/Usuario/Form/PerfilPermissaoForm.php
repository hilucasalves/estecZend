<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class PerfilPermissaoForm extends AbstractForm
{

    public function __construct($name = null)
    {
        parent::__construct('perfilPermissao');
        $this->setAttribute('method', 'post');


        $this->addElement('idPerfilPermissao', 'hidden', 'idPerfilPermissao');
        $this->addElement('usuarioTipo', 'hidden', 'usuarioTipo');
        $this->addElement('recurso', 'hidden', 'recurso');
        $this->add(array(
            'name' => 'permitido',
            'type' => 'radio',
            'options' => array(
                'label' => 'Permitir acesso?',
                'value_options' => array(
                    '0' => 'Não',
                    '1' => 'Sim',
                )
            )
        ));

        $this->addElement('enviar', 'submit', 'Salvar');
    }

}
