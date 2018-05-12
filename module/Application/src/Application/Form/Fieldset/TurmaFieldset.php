<?php

namespace Application\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Application\Entity\Turma;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;

class TurmaFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('turma');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Turma());

        $this->add(array(
            'name' => 'idTurma',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'professor',
            'attributes' => array(
                'id' => 'professor',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Professor: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getProfessor(),
            )
        ));

        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Nome da Turma:',
            ),
        ));

        $this->add(array(
            'name' => 'dataInicio',
            'type' => 'Date',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Data Início: ',
            ),
        ));

        $this->add(array(
            'name' => 'dataFim',
            'type' => 'Date',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Data Fim: ',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusTurma',
            'attributes' => array(
                'id' => 'statusTurma',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status: ',
                'value_options' => array(
                    'A' => 'Ativo',
                    'I' => 'Inativo',
                ),
            )
        ));
    }

    private function getProfessor() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        $professores = $em->getRepository('Application\Entity\Usuario')->findAll();

        foreach ($professores as $professor) {

            $valueOptions[$professor->__get('idUsuario')] = $professor->__get('nome');
        }
        return $valueOptions;
    }

    public function getInputFilterSpecification() {
        return array(
            'nome' => array(
                'required' => true,
            )
        );
    }

}
