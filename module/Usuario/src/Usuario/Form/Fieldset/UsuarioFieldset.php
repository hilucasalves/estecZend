<?php

namespace Usuario\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Application\Entity\Usuario;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;

class UsuarioFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {

        parent::__construct('usuario');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Usuario());

        $this->add(array(
            'name' => 'idUsuario',
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
                'label' => 'Nome ',
            ),
        ));
            
        
      $usuarioLoginFieldset = new UsuarioLoginFieldset($objectManager);
        $usuarioLoginFieldset->setUseAsBaseFieldset(true);
        $this->add($usuarioLoginFieldset);

        
      $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'usuarioTipo',
            'attributes' => array(
                
                //'id' => 'comboboxTipo'
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Usuário Tipo',
                'empty_option' => 'Todos',
                'value_options' => $this->getUsuarioTipo(),
            )
        ));
      
      
        $this->add(array(
            'name' => 'uaitec',
            'type' => 'radio',
            'options' => array(
                'label' => 'Status', //nome campo
                'value_options' => array(
                    'S' => 'Sim',
                    'N' => 'Não'
                )
            )
        ));
      
      $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'orgaoLotacao',
            'attributes' => array(
                
                //'id' => 'comboboxTipo'
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Orgão Lotação',
                'empty_option' => 'Todos',
                'value_options' => $this->getOrgao(),
            )
        ));
        
        $this->add(array(
            'name' => 'telefoneCelular',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputNome',
                'placeholder' => 'DDD + n° celular',
            ),
            'options' => array(
                'label' => 'Celular:',
            ),
        ));

        
    }

    public function getInputFilterSpecification()
    {
        return array(
            'nome' => array(
                'required' => true,
               
            ),
            
            
            
           'telefoneCelular' => array(
                'filters' => array(
                    array('name' => 'Digits'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 10,
                            'max' => 11
                        )
                    )
                )
            )
        );
    }
    private function getUsuarioTipo()
    {
        $valueOptions = array();

        $dql = "select s from Usuario\Entity\UsuarioTipo s";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $tipos = $query->getResult();

        foreach ($tipos as $tipo)
        {
            $valueOptions[$tipo->__get('idUsuarioTipo')] = $tipo->__get('nome');
        }
        return $valueOptions;
    }
    private function getOrgao()
    {
        $valueOptions = array();

        $dql = "select o from Usuario\Entity\OrgaoLotacao o";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $OrgaosLotacaos = $query->getResult();

        foreach ($OrgaosLotacaos as $OrgaoLotacao)
        {
            $valueOptions[$OrgaoLotacao->__get('idOrgaoLotacao')] = $OrgaoLotacao->__get('orgaoLotacao');
        }
        return $valueOptions;
    }
    
    
    
    

}
