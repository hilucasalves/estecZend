<?php

namespace DoctrineORMModule\Proxy\__CG__\Curso\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Curso extends \Curso\Entity\Curso implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'idCurso', 'tipo', 'universidade', 'entidadeGestora', 'subCategoria', 'cursoPai', 'cursoFilhos', 'nome', 'descricao', 'status', 'formato', 'link', 'icoImagem', 'pasta', 'inscricaoOnline', 'dataAtualizacao', 'turma', 'grades');
        }

        return array('__isInitialized__', 'idCurso', 'tipo', 'universidade', 'entidadeGestora', 'subCategoria', 'cursoPai', 'cursoFilhos', 'nome', 'descricao', 'status', 'formato', 'link', 'icoImagem', 'pasta', 'inscricaoOnline', 'dataAtualizacao', 'turma', 'grades');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Curso $proxy) {
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
    public function getIdCurso()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getIdCurso();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdCurso', array());

        return parent::getIdCurso();
    }

    /**
     * {@inheritDoc}
     */
    public function setIdCurso($idCurso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdCurso', array($idCurso));

        return parent::setIdCurso($idCurso);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipo', array());

        return parent::getTipo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipo($tipo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipo', array($tipo));

        return parent::setTipo($tipo);
    }

    /**
     * {@inheritDoc}
     */
    public function getUniversidade()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUniversidade', array());

        return parent::getUniversidade();
    }

    /**
     * {@inheritDoc}
     */
    public function setUniversidade($universidade)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUniversidade', array($universidade));

        return parent::setUniversidade($universidade);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntidadeGestora()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEntidadeGestora', array());

        return parent::getEntidadeGestora();
    }

    /**
     * {@inheritDoc}
     */
    public function setEntidadeGestora($entidadeGestora)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEntidadeGestora', array($entidadeGestora));

        return parent::setEntidadeGestora($entidadeGestora);
    }

    /**
     * {@inheritDoc}
     */
    public function getCursoPai()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCursoPai', array());

        return parent::getCursoPai();
    }

    /**
     * {@inheritDoc}
     */
    public function setCursoPai($cursoPai)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCursoPai', array($cursoPai));

        return parent::setCursoPai($cursoPai);
    }

    /**
     * {@inheritDoc}
     */
    public function getSubCategoria()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubCategoria', array());

        return parent::getSubCategoria();
    }

    /**
     * {@inheritDoc}
     */
    public function setSubCategoria($subCategoria)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSubCategoria', array($subCategoria));

        return parent::setSubCategoria($subCategoria);
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
    public function getDescricao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescricao', array());

        return parent::getDescricao();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescricao($descricao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescricao', array($descricao));

        return parent::setDescricao($descricao);
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
    public function getFormato()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFormato', array());

        return parent::getFormato();
    }

    /**
     * {@inheritDoc}
     */
    public function setFormato($formato)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFormato', array($formato));

        return parent::setFormato($formato);
    }

    /**
     * {@inheritDoc}
     */
    public function getLink()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLink', array());

        return parent::getLink();
    }

    /**
     * {@inheritDoc}
     */
    public function setLink($link)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLink', array($link));

        return parent::setLink($link);
    }

    /**
     * {@inheritDoc}
     */
    public function getIcoImagem()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIcoImagem', array());

        return parent::getIcoImagem();
    }

    /**
     * {@inheritDoc}
     */
    public function setIcoImagem($icoImagem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIcoImagem', array($icoImagem));

        return parent::setIcoImagem($icoImagem);
    }

    /**
     * {@inheritDoc}
     */
    public function getPasta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPasta', array());

        return parent::getPasta();
    }

    /**
     * {@inheritDoc}
     */
    public function setPasta($pasta)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPasta', array($pasta));

        return parent::setPasta($pasta);
    }

    /**
     * {@inheritDoc}
     */
    public function getInscricaoOnline()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInscricaoOnline', array());

        return parent::getInscricaoOnline();
    }

    /**
     * {@inheritDoc}
     */
    public function setInscricaoOnline($inscricaoOnline)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInscricaoOnline', array($inscricaoOnline));

        return parent::setInscricaoOnline($inscricaoOnline);
    }

    /**
     * {@inheritDoc}
     */
    public function addGrades(\Doctrine\Common\Collections\Collection $grades)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addGrades', array($grades));

        return parent::addGrades($grades);
    }

    /**
     * {@inheritDoc}
     */
    public function removeGrades(\Doctrine\Common\Collections\Collection $grades)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeGrades', array($grades));

        return parent::removeGrades($grades);
    }

    /**
     * {@inheritDoc}
     */
    public function getGrades()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGrades', array());

        return parent::getGrades();
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