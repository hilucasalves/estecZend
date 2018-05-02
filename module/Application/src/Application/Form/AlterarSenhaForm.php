<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class AlterarSenhaForm extends AbstractForm
{

    public function __construct($name = null)
    {
        parent::__construct('alterarSenha'); //nome formulario

        $this->setInputFilter(new Filter\AlterarSenhaFilter());

        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');

        /* Paramentros 'nome', tipo, 'label' */
        $this->addElement('idLogin', 'hidden', 'idLogin');

        $this->add(array(
            'type' => 'Password',
            'name' => 'senha',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputSenha',
                'placeholder' => 'Senha',
            ),
        ));

        $this->add(array(
            'type' => 'Password',
            'name' => 'senhaConfirmacao',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputSenhaConf',
                'placeholder' => 'Confirmação senha',
            ),
        ));


        $this->add(array(
            'type' => 'submit',
            'name' => 'enviar',
            'attributes' => array(
                'class' => 'btn btn-primary',
                'value' => 'Enviar'
            ),
        ));
    }

}
