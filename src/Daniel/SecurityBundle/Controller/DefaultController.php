<?php

namespace Daniel\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DanielSecurityBundle:Default:index.html.twig');
    }
}
