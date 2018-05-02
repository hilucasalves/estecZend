<?php

namespace Usuario\Controller;

use Uaitec\Controller\AbstractCrudController;
use Usuario\Form\UsuarioForm;
use Usuario\Entity\Usuario;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class DocumentosController extends AbstractCrudController {

    public function indexAction() {

        $em = $GLOBALS['entityManager'];

        $usuarioLogado = $em->getRepository('Usuario\Entity\Usuario')->find($this->usuarioAutenticado()['usuario']->idUsuario);


        $sql = $em->createQueryBuilder();
        $sql->select('d', 'ad', 'u', 'ut')
                ->from('Usuario\Entity\AssinaturasDocumento', 'ad')
                ->innerJoin('ad.usuario', 'u')
                ->innerJoin('u.usuarioTipo', 'ut')
                ->innerJoin('ad.documento', 'd');

        $sql->andWhere('u.idUsuario = :usuario');
        $sql->setParameter('usuario', $usuarioLogado->idUsuario);
        $sql->AddOrderBy('d.dataInsercao', 'DESC');
        $result = $sql->getQuery()->getResult();

        $arrayAssinatura = array();

        foreach ($result as $assinatura) {
          
            $assinaturas = $em->getRepository('Usuario\Entity\AssinaturasDocumento')->findBy(array('documento' => $assinatura->documento));
            array_push($arrayAssinatura, $assinaturas);
        }


        return array(
            'documentos' => $result,
            'assinaturas' => $arrayAssinatura,
        );
    }

    public function viewAction() {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute($this->route);
        }

        $em = $GLOBALS['entityManager'];
        // Busca pelo login
        $model = $em->getRepository('Usuario\Entity\Usuario')->find($this->usuarioAutenticado()['usuario']->idUsuario);

        return array(
            'model' => $model
        );
    }

    public function deleteFeriadoAction() {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute($this->route);
        }

        $em = $GLOBALS['entityManager'];
        $model = $em->getRepository('Usuario\Entity\Feriados')->find($key);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', $this->label['no']);

            if ($del == $this->label['yes']) {

                $usuariosRegistros = $em->getRepository('Usuario\Entity\UsuarioRegistro')->findBy(array('dataInsercao' => $model->dataFeriado));

                foreach ($usuariosRegistros as $usuarioRegistro) {
                    $em->remove($usuarioRegistro);
                    $em->flush();
                }

                $em->remove($model);
                $em->flush();
            } else {
                return $this->redirect()->toUrl('/usuario/usuario/gerenciar-feriado');
            }
            $this->flashMessenger()->addSuccessMessage('Removido com sucesso!');
            return $this->redirect()->toUrl('/usuario/usuario/gerenciar-feriados');
        }

        return array(
            'form' => $this->getDeleteForm($key),
            'model' => $model
        );
    }

    private function getIpUsuario() {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public function addAction() {

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form = new UsuarioForm($objectManager);
        $model = new Usuario();
        $form->get('enviar')->setValue($this->label['add']);
        $form->bind($model);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {

                $bcrypt = new \Zend\Crypt\Password\Bcrypt();
                $model->login->senha = '123456';
                $model->login->__set('senha', $bcrypt->create($model->login->senha));
                $model->login->__set('nome', $model->nome);
                $objectManager->persist($model);
                $objectManager->flush();
                $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');

                return $this->redirect()->toRoute($this->route);
            }
            $this->flashMessenger()->addErrorMessage('Erro. N�o foi poss�vel cadastrar!');
        }
        return array(
            'form' => $form,
            'title' => $this->setAndGetTitle(),
            'urlView' => $this->back(),
        );
    }

    public function localizarUsuarioAction() {



        $em = $GLOBALS['entityManager'];

        $form = new \Usuario\Form\LocalizarUsuariosForm();
        $form->get('enviar')->setValue('Localizar');

        $filtro = new \Zend\Filter\Digits();
        $data = $this->getRequest()->getQuery();
        $cpf = $filtro->filter($data['cpf']);
        $email = $data['email'];
        $usuario = $data['usuario'];
        $orgaoLotacao = $data['orgaoLotacao'];

        if ($_REQUEST) {

            $result = array();

            if ($data['orgaoLotacao'] || $data['email'] || $data['cpf'] || $data['usuario']) {

                $sql = $em->createQueryBuilder();
                $sql->select('ul')->from('Usuario\Entity\UsuarioLogin', 'ul')
                        ->innerJoin('ul.usuario', 'u');


                if ($orgaoLotacao) {
                    $sql->andWhere('u.orgaoLotacao = :orgaoLotacao');
                    $sql->setParameter('orgaoLotacao', $orgaoLotacao);
                }

                if ($cpf) {

                    $sql->andWhere($sql->expr()->like('ul.cpf', ':cpf'));
                    $sql->setParameter('cpf', '%' . $cpf . '%');
                }

                if ($usuario) {
                    $sql->andWhere('u.idUsuario = :usuario');
                    $sql->setParameter('usuario', $usuario);
                }

                if ($email) {

                    $sql->andWhere($sql->expr()->like('ul.email', ':email'));
                    $sql->setParameter('email', '%' . $email . '%');
                }

                $sql->AddOrderBy('u.nome', 'ASC');
                $result = $sql->getQuery()->getResult();
            } else {

                $sql = $em->createQueryBuilder();
                $sql->select('ul')->from('Usuario\Entity\UsuarioLogin', 'ul')
                        ->innerJoin('ul.usuario', 'u');

                $sql->AddOrderBy('u.nome', 'ASC');

                $result = $sql->getQuery()->getResult();
                // echo '<pre>';var_dump($result);die;
            }

            //Configura o paginador 
            $pageAdapter = new ArrayAdapter($result);
            $paginator = new Paginator($pageAdapter);
            $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
            $paginator->setItemCountPerPage(1000);

            $form->get('cpf')->setValue($data['cpf']);
            $form->get('email')->setValue($data['email']);
            $form->get('usuario')->setValue($data['usuario']);
            $form->get('orgaoLotacao')->setValue($data['orgaoLotacao']);
        }
        return array(
            'form' => $form,
            'paginator' => $paginator,
            'result' => $result,
        );
    }

    public function editAction() {
        //Mensagem de erro caso o formulario foi preenchido incorretamente
        $message = "";

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

//ID do login (idLogin)
        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute('usuario/default', array('action' => 'acesso-negado'));
        }

        $model = $objectManager->getRepository('Usuario\Entity\Usuario')->find($key);

        //echo '<pre>';var_dump($model->idUsuario);die;
        $form = new UsuarioForm($objectManager);
        $form->bind($model);
        $form->get('enviar')->setValue('Salvar');

        $urlAction = $this->url()->fromRoute($this->route, array(
            'action' => 'edit',
            'key' => $key
                )
        );

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            $dados = $this->request->getPost();

            if ($form->isValid()) {
                $objectManager->_set('uaitec', $dados['uaitec']);
                $objectManager->persist($model);
                $objectManager->flush();
                $this->flashMessenger()->addSuccessMessage('Alterado com sucesso!');
                return $this->redirect()->toRoute($this->route, array('action' => 'edit', 'key' => $key));
            } else {
                $message = 'Erro. Verifique se todos os campos foram preenchidos corretamente!';
            }

            $this->flashMessenger()->addErrorMessage('Erro. N�o foi poss�vel alterar!');
        }
        return array(
            'form' => $form,
            'urlAction' => $urlAction,
            'title' => $this->setAndGetTitle(),
            'urlView' => $this->back(),
            'mensagem' => $message
        );
    }

}
