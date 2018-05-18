<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class LocalizarTipoServicoForm extends AbstractForm {

    public function __construct($name = null) {

        parent::__construct('localizarTipoServicoForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'form-inline');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'servico',
            'attributes' => array(
                'id' => 'turma',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Serviço: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getTipoServico(),
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusTipoServico',
            'attributes' => array(
                'id' => 'status',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status: ',
                'empty_option' => 'Todos',
                'value_options' => array(
                             'A' => 'Ativo',
                             'I' => 'Inativo',
                     ),
            )
        ));
        
        $this->add(array(
            'type' => 'submit',
            'name' => 'enviar',
            'attributes' => array(
                'class' => 'btn btn-info',
                'value' => 'Localizar'
            ),
        ));
    }

    private function getTipoServico() {
        $valueOptions = array();
        
        $em = $GLOBALS['entityManager'];
        $tipos = $em->getRepository('Application\Entity\TipoServico')->findAll();

        foreach ($tipos as $tipo) {

            $valueOptions[$tipo->__get('idTipoServico')] = $tipo->__get('nome');
        }
        return $valueOptions;
    }

}
