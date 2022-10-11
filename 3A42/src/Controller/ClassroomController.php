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
        $c=$this->getDoctrine()
        ->getRepository(Classroom::class)->findAll();
            return $this->render('classroom/afficheC.html.twig', [
                'classroom' => $c,
            ]);
        }
          #[Route('/afficheClassroom', name: 'afficheC')]

             public function listClub(ClassroomRepository $repository)
             {
                 $c= $repository->findAll();
                 return $this->render("classroom/afficheC.html.twig",
                 ["classroom"=>$c]);
              }

               #[Route('/suppC/{id}', name: 'supprimerC')]

public function suppC(ManagerRegistry $doctrine,$id,ClassroomRepository $repository)
                  {
                  //récupérer le classroom à supprimer
                      $classroom= $repository->find($id);
                  //récupérer l'entity manager
                      $em= $doctrine->getManager();
                      $em->remove($classroom);
                      $em->flush();
                      return $this->redirectToRoute("afficheC");
                  }

 #[Route('/addClub', name: 'app_addClub')]
    public function addClub(ManagerRegistry $doctrine,Request $request)
    {
        $club= new Club();
        $form=$this->createForm(ClubType::class,$club);
        //$club->setName("club2");
       //   $club->setDescription("description2");
       //  $em= $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute("app_clubs");
        }
        return $this->renderForm("club/addClub.html.twig",
            array("formClub"=>$form));
     }
}
