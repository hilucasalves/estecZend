<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Uaitec\Model\AbstractModel;

/**
 * UsuarioDocumentotipo
 *
 * @ORM\Table(name="loginstatus")
 * @ORM\Entity
 */
class UsuarioLoginStatus extends AbstractModel implements InputFilterAwareInterface {

    protected $inputFilter;

    /**
     * @var integer
     *
     * @ORM\Column(name="idLoginStatus", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $idLoginStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    protected $nome;

    /**
     * (non-PHPdoc)
     * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter ();

            $factory = new InputFactory ();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'idLoginStatus',
                        'required' => true,
                        'filters' => array(
                            array(
                                'name' => 'Int'
                            )
                        )
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'nome',
                        'required' => true,
                        'filters' => array(
                            array(
                                'name' => 'StripTags'
                            ),
                            array(
                                'name' => 'StringTrim'
                            )
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 45
                                )
                            )
                        )
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
