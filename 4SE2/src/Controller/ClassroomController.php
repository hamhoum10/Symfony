<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;


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
        //récupérer le repository
        $r=$this->getDoctrine()->getRepository(Classroom::class);
        $c=$r->findAll();
            return $this->render('classroom/afficheC.html.twig', [
                'classrooms' => $c,
            ]);
        }

         #[Route('/afficheClassroom', name: 'afficheClassroom')]

                     public function listClub(ClassroomRepository $repository)
                     {
                         $c= $repository->findAll();
                         return $this->render("classroom/afficheC.html.twig",
                         ["classrooms"=>$c]);
                      }

                       #[Route('/SupprimerC/{id}', name: 'suppC')]
                          public function SupprimerC($id,ClassroomRepository $repository,
                          ManagerRegistry $doctrine): Response
                          {
                          //récupérer classroom à supprimer
                          $classroom=$repository->find($id);
                          //Action de suppression via Entity manager
                          $em=$doctrine->getManager();
                          $em->remove($classroom);
                          $em->flush();
                              return $this->redirectToRoute('afficheC');
                          }
}
