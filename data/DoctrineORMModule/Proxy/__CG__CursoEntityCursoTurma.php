<?php

namespace DoctrineORMModule\Proxy\__CG__\Curso\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CursoTurma extends \Curso\Entity\CursoTurma implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }

    /**
     * {@inheritDoc}
     * @param string $name
     */
    public function __get($name)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__get', array($name));

        return parent::__get($name);
    }

    /**
     * {@inheritDoc}
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__set', array($name, $value));

        return parent::__set($name, $value);
    }



    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'inputFilter', 'idCursoTurma', 'nome', 'dataInicio', 'dataFim', 'horaInicio', 'horaFim', 'vagas', 'status', 'curso', 'horarios');
        }

        return array('__isInitialized__', 'inputFilter', 'idCursoTurma', 'nome', 'dataInicio', 'dataFim', 'horaInicio', 'horaFim', 'vagas', 'status', 'curso', 'horarios');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CursoTurma $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getIdCursoTurma()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getIdCursoTurma();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdCursoTurma', array());

        return parent::getIdCursoTurma();
    }

    /**
     * {@inheritDoc}
     */
    public function setIdCursoTurma($idCursoTurma)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdCursoTurma', array($idCursoTurma));

        return parent::setIdCursoTurma($idCursoTurma);
    }

    /**
     * {@inheritDoc}
     */
    public function getNome()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNome', array());

        return parent::getNome();
    }

    /**
     * {@inheritDoc}
     */
    public function setNome($nome)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNome', array($nome));

        return parent::setNome($nome);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataInicio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDataInicio', array());

        return parent::getDataInicio();
    }

    /**
     * {@inheritDoc}
     */
    public function setDataInicio($dataInicio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDataInicio', array($dataInicio));

        return parent::setDataInicio($dataInicio);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataFim()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDataFim', array());

        return parent::getDataFim();
    }

    /**
     * {@inheritDoc}
     */
    public function setDataFim($dataFim)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDataFim', array($dataFim));

        return parent::setDataFim($dataFim);
    }

    /**
     * {@inheritDoc}
     */
    public function getHoraInicio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHoraInicio', array());

        return parent::getHoraInicio();
    }

    /**
     * {@inheritDoc}
     */
    public function setHoraInicio($horaInicio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHoraInicio', array($horaInicio));

        return parent::setHoraInicio($horaInicio);
    }

    /**
     * {@inheritDoc}
     */
    public function getHoraFim()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHoraFim', array());

        return parent::getHoraFim();
    }

    /**
     * {@inheritDoc}
     */
    public function setHoraFim($horaFim)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHoraFim', array($horaFim));

        return parent::setHoraFim($horaFim);
    }

    /**
     * {@inheritDoc}
     */
    public function getVagas()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVagas', array());

        return parent::getVagas();
    }

    /**
     * {@inheritDoc}
     */
    public function setVagas($vagas)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVagas', array($vagas));

        return parent::setVagas($vagas);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($status));

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getCurso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCurso', array());

        return parent::getCurso();
    }

    /**
     * {@inheritDoc}
     */
    public function setCurso($curso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCurso', array($curso));

        return parent::setCurso($curso);
    }

    /**
     * {@inheritDoc}
     */
    public function setIdCurso($curso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdCurso', array($curso));

        return parent::setIdCurso($curso);
    }

    /**
     * {@inheritDoc}
     */
    public function addHorarios(\Doctrine\Common\Collections\Collection $horarios)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addHorarios', array($horarios));

        return parent::addHorarios($horarios);
    }

    /**
     * {@inheritDoc}
     */
    public function removeHorarios(\Doctrine\Common\Collections\Collection $horarios)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeHorarios', array($horarios));

        return parent::removeHorarios($horarios);
    }

    /**
     * {@inheritDoc}
     */
    public function getHorarios()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHorarios', array());

        return parent::getHorarios();
    }

    /**
     * {@inheritDoc}
     */
    public function getArrayCopy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getArrayCopy', array());

        return parent::getArrayCopy();
    }

    /**
     * {@inheritDoc}
     */
    public function populate($data = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'populate', array($data));

        return parent::populate($data);
    }

}