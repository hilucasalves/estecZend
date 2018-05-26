<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class LocalizarMatriculaForm extends AbstractForm {

    public function __construct($name = null) {

        parent::__construct('localizarMatriculaForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'form-inline');
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'aluno',
            'attributes' => array(
                'id' => 'aluno',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Aluno: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getAluno(),
            )
        ));

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
            'name' => 'statusMatricula',
            'attributes' => array(
                'id' => 'statusMatricula',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status: ',
                'empty_option' => 'Todos',
                'value_options' => array(
                             'C' => 'Cursando',   
                             'A' => 'Aprovado',
                             'R' => 'Reprovado',
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
    
    private function getAluno() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        $alunos = $em->getRepository('Application\Entity\Usuario')->findAll();

        foreach ($alunos as $aluno) {

            $valueOptions[$aluno->__get('idUsuario')] = $aluno->__get('nome');
        }
        return $valueOptions;
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
