<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use App\Entity\Student;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\StudentFormType;


class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

     #[Route('/afficheS', name: 'afficheS')]
                    public function afficheS(StudentRepository $repository): Response
                    {
                    //utiliser la fonction findAll()
                    $s=$repository->findAll();
                        return $this->render('student/afficheS.html.twig', [
                            'students' => $s,
                        ]);
                        }

 #[Route('/addS', name: 'addS')]
 public function addS(ManagerRegistry $doctrine,Request $request)
                {$s= new Student();
 $form=$this->createForm(StudentFormType::class,$s);
                    $form->handleRequest($request);
                    if($form->isSubmitted()){
                        $em =$doctrine->getManager() ;
                        $em->persist($s);
                        $em->flush();
                        return $this->redirectToRoute("afficheS");}
               return $this->renderForm("student/addS.html.twig",
                        array("f"=>$form));
                 }
}

