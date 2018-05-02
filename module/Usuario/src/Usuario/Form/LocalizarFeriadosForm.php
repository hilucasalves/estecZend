<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class LocalizarFeriadosForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('localizarFeriasForm'); //nome formulario
        $this->setAttribute('method', 'get');
        $this->setAttribute('class', 'form-inline');

 
        $this->add(array(
            'name' => 'nomeFeriado',
            'attributes' => array(
                'style' => 'width:300px',
            'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Nome do Feriado ',
            ),
        ));

        $this->add(array(
            'name' => 'inicioFeriado',
            'type' => 'Date',
            'options' => array(
                'label' => 'Data início:',
            ),
            'attributes' => array(
                'step' => '1',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'fimFeriado',
            'type' => 'Date',
            'options' => array(
                'label' => 'Data fim:',
            ),
            'attributes' => array(
                'step' => '1',
                'class' => 'form-control'
            )
        ));



        $this->addElement('enviar', 'submit', 'Salvar', array('class' => 'btn btn-success'));
    }


}
