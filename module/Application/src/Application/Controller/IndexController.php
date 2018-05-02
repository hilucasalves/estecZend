<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {

   
                
        return array(
 
        );
    }
    
    public function atualizaPontoAction() {
        $em = $GLOBALS['entityManager'];
        $usuariosAtivos = $em->getRepository('Usuario\Entity\Usuario')->findBy(array('statusUsuario' => 'A'));

        foreach ($usuariosAtivos as $usuario) {
            $usuarioRegistro = $em->getRepository('Usuario\Entity\UsuarioRegistro')->findOneBy(array('usuario' => $usuario, 'dataInsercao' => new \DateTime('now')));

            if (!$usuarioRegistro) {
                $tipoRegistro = $em->getRepository('Usuario\Entity\TipoRegistro')->find(5);
                $usuarioRegistro = new \Usuario\Entity\UsuarioRegistro();

                $usuarioRegistro->__set('usuario', $usuario);
                $usuarioRegistro->__set('tipoRegistro', $tipoRegistro);
                $usuarioRegistro->__set('dataInsercao', new \DateTime('now'));
                $usuarioRegistro->__set('entrada', new \DateTime('00:00:00'));
                $usuarioRegistro->__set('saida', new \DateTime('00:00:00'));
                $em->persist($usuarioRegistro);

                $horasTrabalhadas = new \Usuario\Entity\HorasTrabalhadas();
                $horasTrabalhadas->__set('usuarioRegistro', $usuarioRegistro);
                $em->persist($horasTrabalhadas);

                $em->flush();
            }
        }   
    }   
    

}
