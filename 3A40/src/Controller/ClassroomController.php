<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
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
 return $this->redirectToRoute('afficheC',);}
     #[Route('/addC', name: 'addClassroom')]
public function addClassroom(ManagerRegistry $doctrine,Request $request)
               {$classroom= new Classroom();
$form=$this->createForm(ClassroomFormType::class,$classroom);
                   $form->handleRequest($request);
                   if($form->isSubmitted()){
                       $em =$doctrine->getManager() ;
                       $em->persist($classroom);
                       $em->flush();
                       return $this->redirectToRoute("afficheC");}
              return $this->renderForm("classroom/addClassroom.html.twig",
                       array("f"=>$form));
                }

               #[Route('/updateClassroom/{id}', name: 'updateClassroom')]
               public function updateClassroom(ClassroomRepository $repository,$id,ManagerRegistry $doctrine,Request $request)
               { //récupérer le classroom à modifier
                   $classroom= $repository->find($id);
                   $form=$this->createForm(ClassroomFormType::class,$classroom);
                   $form->handleRequest($request);
                   if($form->isSubmitted()){
                       $em =$doctrine->getManager();
                       $em->flush();
                       return $this->redirectToRoute("afficheC"); }

                   return $this->renderForm("classroom/addClassroom.html.twig",
                       array("f"=>$form));
               }


}
