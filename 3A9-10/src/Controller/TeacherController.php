<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig', [
            'name' => '3A9&&3A10',
        ]);
    }

    #[Route('/affiche', name: 'app_affiche')]
    public function affiche(): Response
    {
        return $this->render('teacher/affiche.html.twig', [
            'ecole' => 'INSAT',
        ]);
    }
}
