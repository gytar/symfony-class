<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamblerController extends AbstractController
{
    /**
     * @Route("/gambler", name="gambler_dashboard")
     */
    public function index(): Response
    {
        return $this->render('gambler/index.html.twig', [
            'gambler' => $this->getUser(),
        ]);
    }
}
