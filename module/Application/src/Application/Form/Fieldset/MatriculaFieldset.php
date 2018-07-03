<?php

namespace Application\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Application\Entity\Matricula;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;

class MatriculaFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('matricula');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Matricula());

        $this->add(array(
            'name' => 'idMatricula',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'hidden',
            ),
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
                'empty_option' => 'Selecione',
                'value_options' => $this->getTurma(),
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'aluno',
            'attributes' => array(
                'id' => 'aluno',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Aluno: ',
                'empty_option' => 'Selecione',
                'value_options' => $this->getAluno(),
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
                'value_options' => array(
                    'C' => 'Cursando',
                    'A' => 'Aprovado',
                    'R' => 'Reprovado',
                    'I' => 'Inativo',
                ),
            )
        ));
    }

    private function getAluno() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        $usuarioTipo = $em->getRepository('Application\Entity\UsuarioTipo')->find(3);
        
        $alunos = $em->getRepository('Application\Entity\Usuario')->findBy(array('usuarioTipo' => $usuarioTipo, 'statusUsuario' => 'A'));

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

    public function getInputFilterSpecification() {
        return array(
            'aluno' => array(
                'required' => true,
            ),
            'turma' => array(
                'required' => true,
            ),
            'statusMatricula' => array(
                'required' => true,
            ),
        );
    }

}
