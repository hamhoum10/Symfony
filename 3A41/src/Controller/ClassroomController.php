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

             #[Route('/suppClassroom/{id}', name: 'suppC')]
                public function suppClassroom(ClassroomRepository $r,$id,
                 ManagerRegistry $doctrine): Response
                {
                //récupérer le classroom à supprimer
                $classroom=$r->find($id);
                //récupérer le entity manager
                $em=$doctrine->getManager();
                //action de suppression
                $em->remove($classroom);
               $em->flush();
                //redirection vers l'affichage
                    return $this->redirectToRoute('afficheClassroom');
                }
      #[Route('/modifclassroom/{id}', name: 'modifC')]
         public function modifclassroom(ManagerRegistry $doctrine,
         Request $request,$id,ClassroomRepository $r){
      //récupérer le classroom à modifier
         $classroom=$r->find($id);
       $form=$this->createForm(ClassroomFormType::class,
       $classroom);
       $form->handleRequest($request);
       //Action d'update
             if($form->isSubmitted()){
                 $em =$doctrine->getManager() ;
                 $em->flush();
                 return $this->redirectToRoute("afficheC");}
             return $this->renderForm("classroom/add.html.twig",
                 array("f"=>$form));
          }

           #[Route('/addclassroom', name: 'addclassroom')]
                   public function addclassroom(ManagerRegistry $doctrine,
                   Request $request){
                 $classroom= new Classroom();
                 $form=$this->createForm(ClassroomFormType::class,
                 $classroom);
                 $form->handleRequest($request);
                 //Action d'ajout
                       if($form->isSubmitted()){
                           $em =$doctrine->getManager() ;
                           $em->persist($classroom);
                           $em->flush();
                           return $this->redirectToRoute("afficheC");}
                       return $this->renderForm("classroom/add.html.twig",
                           array("f"=>$form));
                    }




}
