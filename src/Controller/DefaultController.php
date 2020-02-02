<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DefaultController
 *
 * @package AppBundle\Controller
 *
 * @Route("", methods={"GET"})
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("", name="accueil")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('accueil.html.twig');
    }
}
