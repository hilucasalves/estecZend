<?php

namespace Usuario\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Query\ResultSetMapping;
use Usuario\Form\PerfilPermissaoForm;

class PerfilPermissaoController extends AbstractActionController
{

    public function editAction()
    {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key))
        {
            $this->redirect()->toRoute('usuarioPerfil');
        }


        $em = $GLOBALS['entityManager'];
        $model = $em->getRepository('Usuario\Entity\PerfilPermissao')->find($key);


        if (!$model)
        {
            $this->redirect()->toRoute('usuarioPerfil');
        }


        $form = new PerfilPermissaoForm();
        $form->bind($model);

        $form->get('enviar')->setValue('Alterar');
        $form->get('usuarioTipo')->setValue($model->usuarioTipo->idUsuarioTipo);
        $form->get('recurso')->setValue($model->recurso->idPerfilRecurso);


        $request = $this->getRequest();

        if ($request->isPost())
        {
            $form->setData($request->getPost());

            var_dump($request->getPost());

            if ($form->isValid())
            {


                $em->persist($model);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Alterado com sucesso!');
                return $this->redirect()->toRoute('usuarioPerfil', array('action' => 'edit', 'key' => $model->usuarioTipo->idUsuarioTipo));
            }
        }


        return array(
            'form' => $form,
            'model' => $model
        );
    }

}
