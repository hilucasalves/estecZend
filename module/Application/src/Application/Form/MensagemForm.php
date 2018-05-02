<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class MensagemForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('mensagem'); //nome formulario
        $this->setInputFilter(new Filter\MensagemFilter());
        

        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
         $this->setAttribute('enctype', 'multipart/form-data');

        $this->addElement('idFaleConosco', 'hidden', 'idFaleConosco');
        
        $this->add(array(
            'type' => 'textarea',
            'name' => 'mensagemusuario',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputMensagemUsuario',
                'rows' => 5,
                'cols' => '59',
                'placeholder' => 'Mensagem...',
            ),
        ));
       $this->add(array(
            'type' => 'Text',
            'name' => 'cpf',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputCpf',
                'size' => '11',
                'placeholder' => 'Insira seu CPF aqui',
                'maxlength' => '11',
            ),
        ));
  
    }

}
