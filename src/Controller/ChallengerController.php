<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChallengerController extends AbstractController
{
    /**
     * @Route("/challenger", name="challenger_dashboard")
     */
    public function index(): Response
    {
        return $this->render('challenger/index.html.twig', [
            'challenger' => $this->getUser(),
        ]);
    }
}
