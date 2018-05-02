<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class ValidarDocumentoForm extends AbstractForm {

    public function __construct($name = null) {

        parent::__construct('validarDocumento');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');


        $this->add(array(
            'type' => 'Text',
            'name' => 'codVerificador',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'codVerificador',
                'placeholder' => 'Código Verificador',
            ),
        ));

        $this->add(array(
            'type' => 'submit',
            'name' => 'enviar',
            'attributes' => array(
                'class' => 'btn btn-primary',
                'value' => 'Validar Assinatura'
            ),
        ));
    }

}
