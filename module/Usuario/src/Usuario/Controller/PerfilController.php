<?php

namespace Usuario\Controller;

use Uaitec\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Query\ResultSetMapping;

class PerfilController extends AbstractActionController
{

    public function indexAction()
    {
        $em = $GLOBALS['entityManager'];
        $perfis = $em->getRepository('Usuario\Entity\UsuarioTipo')->findby(array(), array('dataAtualizacao' => 'DESC'));

        return new ViewModel(array(
            'perfis' => $perfis
        ));
    }

    public function editAction()
    {


        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key))
        {
            $this->redirect()->toRoute('usuarioPerfil');
        }

        $em = $GLOBALS['entityManager'];

        $usuarioTipo = $em->getRepository('Usuario\Entity\UsuarioTipo')->find($key);

        if (!$usuarioTipo)
        {
            $this->redirect()->toRoute('usuarioPerfil');
        }

        return new ViewModel(array(
            'perfis' => $this->getArrayControlePermissao($key),
            'nomeUsuarioTipo' => $usuarioTipo->__get('nome')
        ));
    }

    private function getArrayControlePermissao($idUsuarioTipo)
    {
        $em = $GLOBALS['entityManager'];

        $controles = $em->getRepository('Usuario\Entity\PerfilControle')->findAll();

        $controlesPermissoes = array();

        foreach ($controles as $controle)
        {

            $controlesPermissoes[$controle->nome] = $this->getSqlPermissoes($idUsuarioTipo, $controle->nome);
        }

        return $controlesPermissoes;
    }

    private function getSqlPermissoes($idUsuarioTipo, $nomeControle)
    {

        $sql = "select
                p.idPerfilPermissao as idPerfilPermissao,  
                c.apelido as Recurso,
                a.nome as Acao,
                if(p.permitido = 1, 'Sim', 'Não') as Permissao
                from 
                perfilcontrole c
                inner join perfilrecurso r on r.idPerfilControle = c.idPerfilControle
                inner join perfilpermissao p on p.idPerfilRecurso = r.idPerfilRecurso
                inner join perfilacao a on a.idPerfilAcao = r.idPerfilAcao 
                inner join usuariotipo u on u.idUsuarioTipo = p.idUsuarioTipo
                where u.idUsuarioTipo = :idUsuarioTipo and c.nome = :nomeControle
            ";

        $parans = array(':idUsuarioTipo' => $idUsuarioTipo, ':nomeControle' => $nomeControle);

        $resultMapp = new ResultSetMapping();
        $resultMapp->addScalarResult('idPerfilPermissao', 'idPerfilPermissao');
        $resultMapp->addScalarResult('Recurso', 'recurso');
        $resultMapp->addScalarResult('Permissao', 'permissao');
        $resultMapp->addScalarResult('Acao', 'acao');

        $em = $GLOBALS['entityManager'];
        $qb = $em->createNativeQuery($sql, $resultMapp);
        $qb->setParameters($parans);

        return $qb->getScalarResult();

        var_dump($qb->getScalarResult());
        die;
    }

}
