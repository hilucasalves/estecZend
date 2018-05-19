<?php

namespace Application\Controller;

use Uaitec\Controller\AbstractCrudController;
use Application\Form\LocalizarProdutoForm;
use Application\Form\ProdutoForm;
use Application\Entity\Produto;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class ProdutoController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Application\Form\ProdutoForm';
        $this->modelClass = 'Application\Entity\Produto';
        $this->route = 'produto';
        $this->title = 'Produtos em estoque';
        $this->label['yes'] = 'Sim';
        $this->label['no'] = 'Não';
        $this->label['add'] = 'Cadastrar';
        $this->label['edit'] = 'Alterar';
        $this->label['view'] = 'Ver';
        $this->label['delete'] = 'Excluir';
    }

    public function indexAction() {

        $data = $this->getRequest()->getPost();

        $em = $GLOBALS['entityManager'];

        $sql = $em->createQueryBuilder();
        $sql->select('p')->from($this->modelClass, 'p');

        if ($data['produto']) {
            $sql->andWhere('p.idProduto = :produto')->setParameter('produto', $data['produto']);
        }

        if ($data['statusProduto']) {
            $sql->andWhere('p.statusProduto = :statusProduto')->setParameter('statusProduto', $data['statusProduto']);
        }

        $sql->AddOrderBy('p.nome', 'ASC');
        $turmas = $sql->getQuery()->getResult();

        $form = new LocalizarProdutoForm();

        $pageAdapter = new ArrayAdapter($turmas);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage(5);

        $form->get('produto')->setValue($data['produto']);
        $form->get('statusProduto')->setValue($data['statusProduto']);

        return array(
            'title' => $this->title,
            'form' => $form,
            'paginator' => $paginator,
        );
    }

    public function viewAction() {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute($this->route);
        }

        $em = $GLOBALS['entityManager'];

        $model = $em->getRepository($this->modelClass)->find($key);

        if ($model) {
            return array(
                'urlView' => $this->back(),
                'model' => $model
            );
        } else {
            return $this->redirect()->toRoute('produto', array('action' => 'acesso-negado'));
        }
    }

    public function addAction() {

        $em = $GLOBALS['entityManager'];

        $form = new ProdutoForm($em);
        $model = new Produto();

        $form->get('enviar')->setValue('Cadastrar');
        $form->bind($model);

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $em->persist($model);
                $em->flush();
                $this->flashMessenger()->addInfoMessage('Cadastrado com sucesso.');
                return $this->redirect()->toRoute($this->route);
            }
            $this->flashMessenger()->addErrorMessage('Erro. Não foi possível cadastrar.');
        }
        return array(
            'form' => $form
        );
    }

    public function editAction() {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute('produto', array('action' => 'acesso-negado'));
        }

        $em = $GLOBALS['entityManager'];

        $model = $em->getRepository($this->modelClass)->find($key);
        if ($model) {

            $form = new ProdutoForm($em);
            $form->bind($model);
            $form->get('enviar')->setValue('Salvar');

            if ($this->getRequest()->isPost()) {
                $form->setData($this->getRequest()->getPost());
                if ($form->isValid()) {
                    $em->persist($model);
                    $em->flush();
                    $this->flashMessenger()->addInfoMessage('Alterado com sucesso.');
                    return $this->redirect()->toRoute($this->route);
                }
                $this->flashMessenger()->addErrorMessage('Erro. Não foi possível alterar.');
            }
            return array(
                'form' => $form,
            );
        } else {
            return $this->redirect()->toRoute('produto', array('action' => 'acesso-negado'));
        }
    }

}
