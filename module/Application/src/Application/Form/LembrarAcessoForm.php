<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class LembrarAcessoForm extends AbstractForm
{

    public function __construct($name = null)
    {
        parent::__construct('lembrarAcesso'); //nome formulario

        $this->setInputFilter(new Filter\LembrarAcessoFilter());

        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');


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
