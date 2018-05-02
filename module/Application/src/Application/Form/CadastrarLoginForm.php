<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class CadastrarLoginForm extends AbstractForm
{

    public function __construct($name = null)
    {
        parent::__construct('login'); //nome formulario

        $this->setInputFilter(new Filter\CadastrarLoginFilter());

        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');

        /* Paramentros 'nome', tipo, 'label' */
        $this->addElement('idLogin', 'hidden', 'idLogin');

        $this->add(array(
            'type' => 'Text',
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputNome',
                'size' => '60',
                'placeholder' => 'Primeiro nome',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputEmail',
                'size' => '60',
                'placeholder' => 'Email',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'emailConfirmacao',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputEmailConf',
                'size' => '60',
                'placeholder' => 'Confirmação email',
            ),
        ));


        $this->add(array(
            'type' => 'Password',
            'name' => 'senha',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputSenha',
                'size' => '60',
                'placeholder' => 'Senha',
            ),
        ));

        $this->add(array(
            'type' => 'Password',
            'name' => 'senhaConfirmacao',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputSenhaConf',
                'size' => '60',
                'placeholder' => 'Confirmação senha',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'cpf',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputCpf',
                'size' => '60',
                'placeholder' => 'CPF',
            ),
        ));


        $this->add(array(
            'name' => 'status',
            'attributes' => array(
                'type' => 'hidden',
                'value' => '3',
            ),
        ));

        $this->add(array(
            'type' => 'Csrf',
            'name' => 'csrf',
        ));



        $this->add(array(
            'type' => 'submit',
            'name' => 'enviar',
            'attributes' => array(
                'class' => 'btn btn-danger',
                'value' => 'Enviar'
            ),
        ));
    }

}
