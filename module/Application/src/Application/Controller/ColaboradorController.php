<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ColaboradorController extends AbstractActionController {

    public function indexAction() {
        $em = $GLOBALS['entityManager'];

        $pagina = $em->getRepository('Comunicacao\Entity\Post')->find(33);

        return array(
            'pagina' => $pagina
        );
    }

    public function buscarColaborador() {
        
        $xml = simplexml_load_file('http://dados/view/XmlSgerpColaborador/ver.php');
        
        echo '<pre>';
        var_dump($xml);
        die;

        return array(
            'colaborador' => $xml
        );
    }

}
