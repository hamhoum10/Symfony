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
        //récupérer le répository
        $r=$this->getDoctrine()->getRepository(Classroom::Class);
        //utiliser la fonction findAll()
        $c=$r->findAll();
            return $this->render('classroom/afficheC.html.twig', [
                'classrooms' => $c,
            ]);
        }
          #[Route('/afficheClassroom', name: 'afficheClassroom')]
                public function afficheClassroom(ClassroomRepository $repository): Response
                {
                //utiliser la fonction findAll()
                $c=$repository->findAll();
                    return $this->render('classroom/afficheC.html.twig', [
                        'classrooms' => $c,
                    ]);
 }
       #[Route('/suppClassroom/{id}', name: 'suppC')]
           public function suppClassroom($id,ClassroomRepository $r,
           ManagerRegistry $doctrine): Response
           {//récupérer la classroom à supprimer
           $classroom=$r->find($id);
           //Action suppression
            $em =$doctrine->getManager();
            $em->remove($classroom);
            $em->flush();
 return $this->redirectToRoute('afficheC',);
           }
}
