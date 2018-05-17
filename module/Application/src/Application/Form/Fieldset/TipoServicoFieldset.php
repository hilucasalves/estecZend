<?php

namespace Application\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Application\Entity\TipoServico;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;

class TipoServicoFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('tiposervico');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new TipoServico());

        $this->add(array(
            'name' => 'idTipoServico',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Nome do Serviço:',
            ),
        ));

        $this->add(array(
            'name' => 'descricao',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Descrição do Serviço:',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusTipoServico',
            'attributes' => array(
                'id' => 'statusTipoServico',
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

    public function getInputFilterSpecification() {
        return array(
            'nome' => array(
                'required' => true,
            ),
            'descricao' => array(
                'required' => true,
            )
        );
    }

}
