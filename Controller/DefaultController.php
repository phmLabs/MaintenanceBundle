<?php

namespace phmLabs\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('phmLabsMaintenanceBundle:Default:index.html.twig');
    }
}
