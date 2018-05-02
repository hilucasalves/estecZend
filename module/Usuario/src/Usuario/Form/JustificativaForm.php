<?php

namespace Usuario\form;

use Uaitec\Form\AbstractForm;

class JustificativaForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('usuarioAbono'); //nome formulario
        $this->setAttribute('method', 'post');

        /* Paramentros 'nome', tipo, 'label' */
        $this->addElement('idUsuarioRegistro', 'hidden', 'idUsuarioRegistro');

        $this->add(array(
            'name' => 'descricao',           
            'attributes' => array(
                'type' => 'textarea',              
                'class' => 'form-control',
                'required' => true
                
            ),
            'options' => array(
                'label' => 'Justificativa: ',                
                
            ),
        ));
        

        $this->add(array(
            'name' => 'entrada',
            'type' => 'Time',
            'options' => array(
                'label' => 'Hora de entrada',
                'format' => 'H:i'
            ),
            'attributes' => array(
                'min' => '00:00',
                'max' => '23:59',
                'class' => 'form-control'
            ),
        ));

        $this->add(array(
            'name' => 'saida',
            'type' => 'Time',
            'options' => array(
                'label' => 'Hora de saída',
                'format' => 'H:i'
            ),
            'attributes' => array(
                'min' => '00:00',
                'max' => '23:59',
                'class' => 'form-control'
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
    
    private function getTipRegistro()
    {
        $valueOptions = array();

        $dql = "select t from Usuario\Entity\TipoRegistro t where t.idTipoRegistro in (1,4,8)";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $tipos = $query->getResult();

        foreach ($tipos as $tipo)
        {
            $valueOptions[$tipo->__get('idTipoRegistro')] = $tipo->__get('nome');
        }
        return $valueOptions;
    }

}
