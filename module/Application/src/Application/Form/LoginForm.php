<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class LoginForm extends AbstractForm {

    public function __construct($name = null) {
        
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');


        $this->add(array(
            'type' => 'Text',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'Email',
            ),
        ));

        $this->add(array(
            'type' => 'password',
            'name' => 'senha',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'senha',
                'placeholder' => 'Senha',
            ),
        ));

        $this->add(array(
            'type' => 'submit',
            'name' => 'enviar',
            'attributes' => array(
                'class' => 'btn btn-info',
                'value' => 'Entrar'
            ),
        ));
    }

}
