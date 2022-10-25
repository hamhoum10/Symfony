<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Student;
use App\Form\StudentFormType;
use App\Form\SearchStudentFormType;

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

                 public function afficheS(StudentRepository $repository)
                 {
                     $s= $repository->findAll();
                     return $this->render("student/afficheS.html.twig",
                     ["student"=>$s]);
                  }

                  #[Route('/addS', name: 'addS')]
                      public function addS(ManagerRegistry $doctrine,
                      Request $request){
                    $student= new Student();
                    $form=$this->createForm(StudentFormType::class,$student);
                    $form->handleRequest($request);
                    //Action d'ajout
                          if($form->isSubmitted()){
                              $em =$doctrine->getManager() ;
                              $em->persist($student);
                              $em->flush();
                              return $this->redirectToRoute("afficheS");}
                          return $this->renderForm("student/addS.html.twig",
                              array("f"=>$form));
                       }




            #[Route('/searchStudentByAVGG', name: 'searchStudentByAVG')]
           public function searchStudentByAVG(Request $request,StudentRepository $student){

                   $students = $student->findAll();
                   $searchForm = $this->createForm(SearchStudentFormType::class);
                   $searchForm->handleRequest($request);
                   if ($searchForm->isSubmitted()) {
                       $minMoy=$searchForm['min']->getData();
                       $maxMoy=$searchForm['max']->getData();
                       $resultOfSearch = $student->findStudentByAVG($minMoy,$maxMoy);
                       return $this->renderForm('student/searchStudentByAVG.html.twig', [
                           'Students'=>$resultOfSearch,
                           'searchStudentByAVG' => $searchForm,]);
                   }
  return $this->renderForm('student/searchStudentByAVG.html.twig',
   array('searchStudentByAVG'=>$searchForm,'Students'=>$students));
               }
}
