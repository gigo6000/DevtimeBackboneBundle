<?php

namespace Devtime\BackboneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BackboneController extends Controller
{
    /**
     * @Route("/backbone/hello")
     */
    public function helloAction()
    {
        return $this->render('DevtimeBackboneBundle:Backbone:hello.html.twig');
    }
}
