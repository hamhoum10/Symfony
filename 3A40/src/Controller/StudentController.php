<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use App\Entity\Student;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
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
        public function afficheS(StudentRepository $repository): Response
                    {
         //utiliser la fonction findAll()
            $s=$repository->findAll();
          //utiliser la fonction oderbymail
          $so=$repository->orderByMail();
       return $this->render('student/afficheS.html.twig', [
        'students' => $s,'so'=>$so
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

           #[Route('/searchStudentByAVG', name: 'searchStudentByAVG')]
                      public function searchStudentByAVG(Request $request,StudentRepository $student){

                              $students= $student->orderByMail();
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
              array('Students' => $students,'searchStudentByAVG'=>$searchForm,
                                  ));

           }

}

