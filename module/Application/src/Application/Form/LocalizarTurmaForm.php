<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class LocalizarTurmaForm extends AbstractForm {

    public function __construct($name = null) {

        parent::__construct('localizarTurmaForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'form-inline');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'turma',
            'attributes' => array(
                'id' => 'turma',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Turma: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getTurma(),
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusTurma',
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

    private function getTurma() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        $turmas = $em->getRepository('Application\Entity\Turma')->findAll();

        foreach ($turmas as $turma) {

            $valueOptions[$turma->__get('idTurma')] = $turma->__get('nome');
        }
        return $valueOptions;
    }

}
