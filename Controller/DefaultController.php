<?php

namespace Devtime\BackboneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/raffler")
     */
    public function indexAction()
    {
        return $this->render('DevtimeRafflerBundle:Default:index.html.twig');

    }
}
