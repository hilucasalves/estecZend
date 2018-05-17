<?php

namespace Uaitec\Controller;

use Uaitec\Model\AbstractModel;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

abstract class AbstractCrudController extends AbstractActionController
{

    protected $formClass;
    protected $modelClass;
    protected $route;
    protected $title;
    protected $modelDao;
    protected $modelDaoNamespace;
    protected $label = array(
        'add' => 'Add',
        'edit' => 'Edit',
        'view' => 'View',
        'yes' => 'Yes',
        'no' => 'No'
    );

    public function indexAction()
    {

        $urlAdd = $this->url()->fromRoute($this->route, array('action' => 'add'));
        $urlEdit = $this->url()->fromRoute($this->route, array('action' => 'edit'));
        $urlView = $this->url()->fromRoute($this->route, array('action' => 'view'));
        $urlDelete = $this->url()->fromRoute($this->route, array('action' => 'delete'));
        $urlHomepage = $this->url()->fromRoute('home');

        $placeHolder = $this->getSm()->get('viewhelpermanager')->get('Placeholder');
        $placeHolder('url')->edit = $urlEdit;
        $placeHolder('url')->delete = $urlDelete;
        $placeHolder('url')->view = $urlView;
        $placeHolder('url')->add = $urlAdd;

        $em = $GLOBALS['entityManager'];

        $result = $em->getRepository($this->modelClass)->findby(array(), array('dataAtualizacao' => 'DESC'));

        //Configura o paginador 
        $pageAdapter = new ArrayAdapter($result);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));

        return new ViewModel(array(
            'paginator' => $paginator,
            'title' => $this->setAndGetTitle(),
            'urlAdd' => $urlAdd,
            'urlHomepage' => $urlHomepage,
        ));
    }

    public function viewAction()
    {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key))
        {
            return $this->redirect()->toRoute($this->route);
        }

        $em = $GLOBALS['entityManager'];
        $model = $em->getRepository($this->modelClass)->find($key);

        return array(
            'model' => $model,
            'title' => $this->setAndGetTitle(),
            'urlView' => $this->back()
        );
    }

    public function addAction()
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass();

        $formClass = $this->formClass;
        $form = new $formClass();

        $form->get('enviar')->setValue($this->label['add']);
        $form->bind($model);

        $urlAction = $this->url()->fromRoute($this->route, array('action' => 'add'));

        return $this->save($model, $form, $urlAction, null);
    }

    public function editAction()
    {
        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key))
        {
            return $this->redirect()->toRoute($this->route, array(
                        'action' => 'add'
            ));
        }


        $model = $this->getModel($key);

        $formClass = $this->formClass;
        $form = new $formClass();
        $form->bind($model);

        $form->get('enviar')->setValue($this->label['add']);

        $urlAction = $this->url()->fromRoute($this->route, array(
            'action' => 'edit',
            'key' => $key
                )
        );

        return $this->save($model, $form, $urlAction, $key);
    }

    protected function save(AbstractModel $model, $form, $urlAction, $key)
    {
        $request = $this->getRequest();

        if ($request->isPost())
        {
            //$form->setInputFilter($model->getInputFilter());
            $form->setData($request->getPost());

            //var_dump($urlAction);
            //exit();

            if ($form->isValid())
            {

                if (method_exists($model, 'exchangeArray'))
                {

                    $model->exchangeArray($form->getData());
                } else
                {
                    $model->getArrayCopy($form->getData());
                }


                $em = $GLOBALS['entityManager'];
                $em->persist($model);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');

                return $this->redirect()->toRoute($this->route);
            }
            $this->flashMessenger()->addErrorMessage('Erro. Não foi possível cadastrar!');
            //return $this->redirect()->toRoute($this->route);
        }

        return array(
            'key' => $key,
            'form' => $form,
            'urlAction' => $urlAction,
            'title' => $this->setAndGetTitle(),
            'urlView' => $this->back(),
        );
    }

    public function deleteAction()
    {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key))
        {
            return $this->redirect()->toRoute($this->route);
        }


        $model = $this->getModel($key);


        $request = $this->getRequest();
        if ($request->isPost())
        {
            $del = $request->getPost('del', $this->label['no']);

            if ($del == $this->label['yes'])
            {

                try
                {
                    $em = $GLOBALS['entityManager'];
                    $em->remove($this->getModel($key));
                    $em->flush();
                } catch (\Exception $e)
                {
                    $this->flashMessenger()->addErrorMessage('Erro. Não foi possível excluir!' . "<br>Código: " . $e->getCode() . "<br>Mensagem: " . $e->getMessage());
                    return $this->redirect()->toRoute($this->route);
                }
            }

            return $this->redirect()->toRoute($this->route);
        }

        $urlAction = $this->url()->fromRoute($this->route, array('action' => 'delete'));

        return array(
            'form' => $this->getDeleteForm($key),
            //Não sei porque a variavel se chama $urlAciton
            'urlAction' => $urlAciton,
            'title' => $this->setAndGetTitle(),
            'model' => $model
        );
    }

    public function getDeleteForm($key)
    {
        $form = new Form();

        $form->add(array(
            'name' => 'del',
            'attributes' => array(
                'type' => 'submit',
                'value' => $this->label['yes'],
                'id' => 'del',
                'class' => 'btn btn-primary'
            ),
        ));

        $form->add(array(
            'name' => 'return',
            'attributes' => array(
                'type' => 'submit',
                'value' => $this->label['no'],
                'id' => 'return',
                'class' => 'btn btn-warning'
            ),
        ));

        return $form;
    }

    ///// Retorna usuario autenticado
    protected $authService;

    public function getAuthService()
    {

        return $this->authService;
    }

    public function usuarioAutenticado()
    {
        $sessionStorage = new Session('login');
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity())
        {
            $em = $GLOBALS['entityManager'];
            $usuario = $em->getRepository('Usuario\Entity\Usuario')->findOneBy(array('login' => $this->getAuthService()->getIdentity()->idLogin));

            return array(
                'nome' => $this->getAuthService()->getIdentity()->nome,
                'idLogin' => $this->getAuthService()->getIdentity()->idLogin,
                'usuario' => $usuario
            );
        } else
        {
            return false;
        }
    }

    protected function getModel($key)
    {
        $em = $GLOBALS['entityManager'];
        return $em->getRepository($this->modelClass)->find($key);
    }

    protected function getSm()
    {
        return $this->getEvent()->getApplication()->getServiceManager();
    }

    protected function setAndGetTitle()
    {

        $headTitle = $this->getSm()->get('viewhelpermanager')->get('HeadTitle');
        $headTitle($this->title);

        return $this->title;
    }

    protected function back()
    {

        $urlView = $this->url()->fromRoute($this->route);

        return $urlView;
    }

}
