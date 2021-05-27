<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("", name="dashbord")
     */
    public function dashbord(): Response
    {
        return $this->render('admin/dashbord.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
