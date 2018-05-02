<?php

namespace Usuario\form;

use Uaitec\Form\AbstractForm;

class FechaMesForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('FechaMesForm'); //nome formulario
        $this->setAttribute('method', 'post');

        /* Paramentros 'nome', tipo, 'label' */
        $this->addElement('idFechamentoMesBolsista', 'hidden', 'idFechamentoMesBolsista');

        $this->add(array(
            'name' => 'notaTecnica',           
            'attributes' => array(
                'type' => 'textarea',              
                'class' => 'form-control',
                'required' => true
                
            ),
            'options' => array(
                'label' => 'Nota Técnica: ',                
                
            ),
        ));
        
        

        $this->add(array(
            'name' => 'enviar',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-danger'
            ),
            'options' => array(
                'label' => 'Salvar',
            ),
        ));

    }    
   

}
