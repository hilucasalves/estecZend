<?php

namespace Application\Controller;

use Uaitec\Controller\AbstractCrudController;
use Application\Form\LocalizarMovimentacaoForm;
use Application\Form\MovimentacaoForm;
use Application\Entity\Movimentacao;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class MovimentacaoController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Application\Form\MovimentacaoForm';
        $this->modelClass = 'Application\Entity\Movimentacao';
        $this->route = 'movimentacao';
        $this->title = 'Movimentação de produtos';
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
        $sql->select('m')->from($this->modelClass, 'm');

        if ($data['produto']) {
            $produto = $em->getRepository('Application\Entity\Produto')->find($data['produto']);
            $sql->andWhere('m.produto = :produto')->setParameter('produto', $produto);
        }
        
        if ($data['tipoMovimentacao']) {
            $sql->andWhere('m.tipoMovimentacao = :tipoMovimentacao')->setParameter('tipoMovimentacao', $data['tipoMovimentacao']);
        }

        $sql->AddOrderBy('m.dataInsercao', 'ASC');
        $movimentacoes = $sql->getQuery()->getResult();
        
        $form = new LocalizarMovimentacaoForm();

        $pageAdapter = new ArrayAdapter($movimentacoes);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage(5);

        $form->get('produto')->setValue($data['produto']);
        $form->get('tipoMovimentacao')->setValue($data['tipoMovimentacao']);
        $form->get('statusMovimentacao')->setValue($data['statusMovimentacao']);

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

        return array(
            'urlView' => $this->back(),
            'model' => $model
        );
    }

    public function addAction() {

        $em = $GLOBALS['entityManager'];
        
        $form = new MovimentacaoForm($em);
        $model = new Movimentacao();

        $form->get('enviar')->setValue('Cadastrar');
        $form->bind($model);

        if ($this->getRequest()->isPost()) {
            
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $em->persist($model);
                
                $produto = $em->getRepository('Application\Entity\Produto')->find($model->produto->idProduto);
                if($model->tipoMovimentacao == "E") $quantidade = $produto->__get('qtd') + $model->qtd;
                else $quantidade = $produto->__get('qtd') - $model->qtd;
                
                $produto->__set('qtd', $quantidade);
                $em->persist($produto);
                
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso.');
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
            return $this->redirect()->toRoute('movimentacao', array('action' => 'acesso-negado'));
        }

        $em = $GLOBALS['entityManager'];

        $model = $em->getRepository($this->modelClass)->find($key);

        $form = new ProdutoForm($em);
        $form->bind($model);
        $form->get('enviar')->setValue('Salvar');

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $em->persist($model);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Alterado com sucesso.');
                return $this->redirect()->toRoute($this->route);
            }
            $this->flashMessenger()->addErrorMessage('Erro. Não foi possível alterar.');
        }
        return array(
            'form' => $form,
        );
    }

}
