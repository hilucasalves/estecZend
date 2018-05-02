<?php

namespace Usuario\Form\Fieldset;

use Zend\Form\Fieldset;
use Usuario\Entity\UsuarioLogin;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UsuarioLoginFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('login');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new UsuarioLogin());

        $this->add(array(
            'name' => 'idLogin',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
         
         $this->add(array(
            'type' => 'Text',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputEmail',
                'placeholder' => 'Email',
            ),
        ));
         $this->add(array(
            'type' => 'Text',
            'name' => 'cpf',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputCpf',
                'placeholder' => 'CPF',
            ),
        ));
       
         $this->add(array(
            'type' => 'password',
            'name' => 'senha',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'inputSenha',
                'placeholder' => 'SENHA',
            ),
        ));
       
          
      $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'status',
            'attributes' => array(
                //'id' => 'comboboxTipo'
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Login Status',
                'empty_option' => 'Todos',
                'value_options' => $this->getLoginStatus(),
            )
        ));

    }
    
    public function getInputFilterSpecification()
    {
        return array(
            'cpf' => array(
                'required' => true,
                
            ),
              'senha' => array(
                'required' => false,
                'allow_empty' => true,  
            ),
              'email' => array(
                'required' => true
            ),
            
     
        );
    }
    private function getLoginStatus() {
        $valueOptions = array();

        $dql = "select s from Usuario\Entity\UsuarioLoginStatus s";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $status = $query->getResult();

        foreach ($status as $sta) {
            $valueOptions[$sta->__get('idLoginStatus')] = $sta->__get('nome');
        }
        return $valueOptions;
    }

}
