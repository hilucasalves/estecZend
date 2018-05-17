<?php

namespace Util\Service;

use Application\Model\Dao\Usuario\UsuarioDao;

use Application\Model\Usuario\Tipo;

use Application\Model\Dao\Usuario\TipoDao;

use Application\Model\Usuario\Permissao;

use Util\Filter\Accents;

use Zend\Permissions\Acl\Resource\GenericResource;

use Zend\Permissions\Acl\Role\GenericRole;

use Application\Model\Resource\Resource;

use Zend\Permissions\Acl\Acl;

use Application\Model\Usuario\Login;

use Util\Authentication\DoctrineAdapter;

use Zend\ServiceManager\ServiceManager;

use Zend\ServiceManager\ServiceManagerAwareInterface;

use Zend\Authentication\AuthenticationService;

class Auth extends AuthenticationService implements ServiceManagerAwareInterface {
	
	protected $serviceManager;
	protected $entityManager;

	public function __construct($entityManager = null) {
		if($entityManager !== null)
			$this->entityManager = $entityManager;
		parent::__construct();
	}
	
	public function autenticar(Login $login) {
		$authAdapter = new \Util\Authentication\DoctrineAdapter($this->entityManager);
		$authAdapter->setCredentialColumn(Login::CREDENTIAL_COLUMN);
		$authAdapter->setIdentityColumn(Login::IDENTITY_COLUMN);
		$authAdapter->setEntityName('Application\Model\Usuario\Login');
		//Seta usuário e senha
		$authAdapter->setCredential($login->getSenha(Login::CRIPTO));
		$authAdapter->setIdentity($login->getLogin());
		
		$result = $authAdapter->authenticate();
		if ($result->isValid()) {
				
			$object = $authAdapter->getResultRowObject(DoctrineAdapter::RETURN_TYPE_NATIVE);
			$usuario = $this->getUsuarioDao()->findOneByLogin($object->getCodigo());
				
			if($usuario->getTipo()->getCodigo() == 1) {
				if($usuario->getCadastrovalidado() == 0)
					return -5;
			}
				
			$usuario->getTipo()->setAcl($this->buildAcl($usuario));
			$this->persistIdentity($usuario);
		}
		return $result->getCode();
	}
	
	public function authorize($moduleName, $controllerName, $actionName) {
			
		$acl = null;
		if($this->hasIdentity()) {
			$identity = $this->getIdentity();

			$user = $this->getUsuarioDao()->findOnBy(UsuarioDao::CODIGO, $identity->getCodigo());
			$tipo = $user->getTipo();
			
			if($tipo->getAcl() != null) {
				$acl = $identity->getTipo()->getAcl();
			} else {
				$acl = $this->buildAcl($user);
			} 
			
		} else {
			$tipo = $this->getTipoDao()->findTipoPublico();
			$acl = $this->buildPublicAcl($tipo);
		}
		
		if($acl === null)
			return false;
		
		if(!$acl instanceof \Zend\Permissions\Acl\Acl)
			return false;
		
		//Se para o recurso solicitado não houve privilégio indicado o acesso será liberado
		if($acl->hasResource($controllerName))	
			return $acl->isAllowed($tipo->getCodigo(), $controllerName, $actionName);
		
		return false;
	}
	
	public function buildAcl(\Application\Model\Usuario\Usuario $model) {
		$acl = new Acl();

		$role = $model->getTipo()->getCodigo();
		$acl->addRole(new GenericRole($role)); //seta o tipo de usuario
		
		$permissoes = $model->getTipo()->getPermissoes();
		foreach ($permissoes as $permi) {
			$resource = $permi->getAction()->getResurso()->getNome();
			
			//Testa se o recurso já foi inserido
			if(!$acl->hasResource($resource))
				$acl->addResource(new GenericResource($resource));
			
			if($permi->getPrivilegio())
				$acl->allow($role, $resource, $permi->getAction()->getNome());
			else $acl->deny($role, $resource, $permi->getAction()->getNome());
		}
		return $acl;
	}
	
	private function buildPublicAcl(Tipo $tipo) {
		
		$role = $tipo->getCodigo();
		
		$acl = new Acl();
		$acl->addRole(new GenericRole($role));
		
		$permissoes = $tipo->getPermissoes();
		foreach ($permissoes as $permi) {
			$action = $permi->getAction();
			$resource = $action->getResurso()->getNome();
				
			//Testa se o recurso já foi inserido
			if(!$acl->hasResource($resource))
				$acl->addResource(new GenericResource($resource));
				
			if($permi->getPrivilegio())
				$acl->allow($role, $resource, $permi->getAction()->getNome());
			else $acl->deny($role, $resource, $permi->getAction()->getNome());
		}
		return $acl;
	}
	
	public function persistIdentity($dados) {
		if ($this->hasIdentity())
			$this->clearIdentity();
		
		$this->getStorage()->write($dados);
	}
	
	/**
	 * 
	 * @return \Application\Model\Usuario\Usuario
	 */
	public function getIdentity() {
		$storage = $this->getStorage();
	
		if ($storage->isEmpty())
			return null;
		
		return $storage->read();
	}
	
	/**
	 * Clears the identity from persistent storage
	 *
	 * @return void
	 */
	public function clearIdentity() {
		$this->getStorage()->clear();
	}
	
	/**
	 * 
	 * @return \Application\Model\Dao\Login\LoginDao
	 */
	public function getLoginDao() {
		$dao = $this->getService('ModelFactory')->factory('Application\Model\Login\Login');
		return $dao;
	}
	
	/**
	 * @return \Application\Model\Dao\Usuario\UsuarioDao
	 */
	public function getUsuarioDao() {
		$dao = $this->getService('ModelFactory')->factory('Application\Model\Usuario\Usuario');
		return $dao;
	}
	
	/**
	 * @return \Application\Model\Dao\Resource\Resource
	 */
	public function getResourceDao() {
		$dao = $this->getService('ModelFactory')->factory('Application\Model\Resource\Resource');
		return $dao;
	}
	
	/**
	 * @return \Application\Model\Dao\Usuario\TipoDao
	 */
	public function getTipoDao() {
		$dao = $this->getService('ModelFactory')->factory('Application\Model\Usuario\Tipo');
		return $dao;
	}
	
	public function logout() {
		$this->clearIdentity();
		return true;
	}
	
	public function setServiceManager(ServiceManager $serviceManager) {
		$this->serviceManager = $serviceManager;
	}
	
	public function getServiceManager() {
		return $this->serviceManager;
	}
	
	public function getService($serviceName) {
		return $this->getServiceManager()->get($serviceName);
	}
}