<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class UsuarioForm extends AbstractForm
{

    public function __construct($name = null)
    {

        parent::__construct('usuarioForm');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'idUsuario',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'usuarioTipo',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputNome',
                'placeholder' => 'Nome Completo',
            ),
        ));


        $this->add(array(
            'name' => 'telefoneCelular',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputNome',
            ),
            'options' => array(
                'label' => 'Celular:',
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
