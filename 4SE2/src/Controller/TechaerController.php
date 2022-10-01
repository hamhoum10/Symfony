<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechaerController extends AbstractController
{
    #[Route('/techaer', name: 'app_techaer')]
    public function index(): Response
    {
        return $this->render('techaer/index.html.twig', [
            'name' => '4SE2',
        ]);
    }
    #[Route('/essai', name: 'app_essai')]
        public function essai(): Response
        {
            return $this->render('techaer/essai.html.twig');
        }

     #[Route('/test', name: 'app_test')]
        public function test(): Response
        {
            return $this->render('techaer/test.html.twig');
        }
}
