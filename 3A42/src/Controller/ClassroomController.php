<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ClassroomFormType;

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

 #[Route('/addclassroom', name: 'addclassroom')]
    public function addclassroom(ManagerRegistry $doctrine,
    Request $request){
  $classroom= new Classroom();
  $form=$this->createForm(ClassroomFormType::class,$classroom);
  $form->handleRequest($request);
  //Action d'ajout
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute("afficheC");}
        return $this->renderForm("classroom/addClassroom.html.twig",
            array("f"=>$form));
     }


#[Route('/modifierclassroom/{id}', name: 'modifierclassroom')]
    public function modifierclassroom(ManagerRegistry $doctrine,
    Request $request,$id,ClassroomRepository $repository ){
 //récupérer le classroom à modifier
       $classroom= $repository->find($id);
      $form=$this->createForm(ClassroomFormType::class,$classroom);
  $form->handleRequest($request);
  //Action de MAJ
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $em->flush();
            return $this->redirectToRoute("afficheC");}
        return $this->renderForm("classroom/addClassroom.html.twig",
            array("f"=>$form));
     }

}
