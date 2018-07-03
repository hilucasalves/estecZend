<?php

namespace Application\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Application\Entity\Atendimento;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;

class AtendimentoFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('atendimento');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Atendimento());

        $this->add(array(
            'name' => 'idAtendimento',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'hidden',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'cliente',
            'attributes' => array(
                'id' => 'cliente',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Cliente: ',
                'empty_option' => 'Selecione',
                'value_options' => $this->getCliente(),
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
                'empty_option' => 'Selecione',
                'value_options' => $this->getTurma(),
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'matricula',
            'attributes' => array(
                'id' => 'matricula',
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
            'name' => 'tipoServico',
            'attributes' => array(
                'id' => 'tipoServico',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Serviço: ',
                'empty_option' => 'Selecione',
                'value_options' => $this->getTipoServico(),
            )
        ));
        
        $this->add(array(
            'name' => 'descricao',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Descrição: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'dataPrevisao',
            'type' => 'Date',
            'attributes' => array(
                'class' => 'form-control',
                'min' => date('Y-m-d'),
                'max' => date('Y-m-d', strtotime('+1 years')),
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Data de Previsão: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'feedback',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Feedback: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'nota',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'number',
                'min' => '1',
                'max' => '100',
                'step' => '1'
            ),
            'options' => array(
                'label' => 'Nota: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'observacao',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Observação: ',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusAtendimento',
            'attributes' => array(
                'id' => 'statusAtendimento',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status: ',
                'value_options' => array(
                    'A' => 'Ativo',
                    'F' => 'Finalizado',
                    'I' => 'Inativo',
                ),
            )
        ));
    }
    
    private function getCliente() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        $usuarioTipo = $em->getRepository('Application\Entity\UsuarioTipo')->find(4);
        
        $clientes = $em->getRepository('Application\Entity\Usuario')->findBy(array('usuarioTipo' => $usuarioTipo, 'statusUsuario' => 'A'));
        
        foreach ($clientes as $cliente) {
            $valueOptions[$cliente->__get('idUsuario')] = $cliente->__get('nome');
        }
        return $valueOptions;
    }

    private function getAluno() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        
        $matriculas = $em->getRepository('Application\Entity\Matricula')->findBy(array('statusMatricula' => 'C'));
        
        foreach ($matriculas as $matricula) {
            $valueOptions[$matricula->__get('idMatricula')] = $matricula->aluno->__get('nome');
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
    
    private function getTipoServico() {
        $valueOptions = array();
        
        $em = $GLOBALS['entityManager'];
        $tipoServicos = $em->getRepository('Application\Entity\TipoServico')->findAll();
        
        foreach ($tipoServicos as $tipoServico) {
            $valueOptions[$tipoServico->__get('idTipoServico')] = $tipoServico->__get('nome');
        }
        return $valueOptions;
    }

    public function getInputFilterSpecification() {
        return array(
            'cliente' => array(
                'required' => true,
            ),
            'statusAtendimento' => array(
                'required' => true,
            ),
            'dataPrevisao' => array(
                'required' => true,
            ),
        );
    }

}
