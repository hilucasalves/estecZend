<?php

namespace Usuario\form;

use Uaitec\Form\AbstractForm;

class FeriadoForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('usuarioFeriado'); //nome formulario
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-inline');

        /* Paramentros 'nome', tipo, 'label' */
        $this->addElement('idFeriado', 'hidden', 'idFeriado');

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
            'name' => 'dataFeriado',
            'type' => 'Date',
            'options' => array(
                'label' => 'Data do feriado',
                'format' => 'Y-m-d'
            ),
            'attributes' => array(
                'step' => '1',
                'class' => 'form-control',
                'id' => 'dataFeriado'
            )
        ));


        $this->add(array(
            'name' => 'enviar',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-success'
            ),
            'options' => array(
                'label' => 'Salvar',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipoRegistro',
            'attributes' => array(
                'required' => true,
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Registro Tipo',
                'empty_option' => 'Todos',
                'value_options' => $this->getTipRegistro(),
            )
        ));
    }

    private function getTipRegistro() {
        $valueOptions = array();

        $dql = "select t from Usuario\Entity\TipoRegistro t where t.idTipoRegistro in (2,9)";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $tipos = $query->getResult();

        foreach ($tipos as $tipo) {
            $valueOptions[$tipo->__get('idTipoRegistro')] = $tipo->__get('nome');
        }
        return $valueOptions;
    }

}
