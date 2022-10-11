<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
     #[Route('/afficheC', name: 'afficheC')]
        public function afficheC(): Response
        {
        //récupérer le repository de l'entité classroom
        $r=$this->getDoctrine()->getRepository(Classroom::class);
        //utiliser la fonction findAll()
        $c=$r->findAll();
            return $this->render('classroom/afficheC.html.twig', [
                'classrooms' => $c,
            ]);
        }
        //2ème façon pour l'affichage avec l'injection de dépendance
         #[Route('/afficheClassroom', name: 'afficheClassroom')]

                     public function listClassroom(ClassroomRepository $repository)
                     {
                         $c= $repository->findAll();
                         return $this->render("classroom/afficheC.html.twig",
                         ["classrooms"=>$c]);
                      }
}
