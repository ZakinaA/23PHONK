<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Professeur;
use App\Entity\Professionnel;
use App\Form\ProfesseurType;
use App\Form\ProfessionnelModifierType;
use App\Form\ProfessionnelType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfessionnelController extends AbstractController
{
   // #[Route('/profesionnel', name: 'app_profesionnel')]
    public function index(): Response

    {
        return $this->render('profesionnel/index.html.twig', [
            'controller_name' => 'ProfesionnelController',
        ]);
    }


    public function consulterProfessionnel(ManagerRegistry $doctrine, int $id){

        $professionnel= $doctrine->getRepository(Professionnel::class)->find($id);

        $metiers = $professionnel->getMetiers();

        if (!$professionnel) {
            throw $this->createNotFoundException(
                'Aucun contrat trouvé avec le numéro '.$id
            );
        }

        return $this->render('professionnel/consulter.html.twig', ['professionnel' => $professionnel,'metiers' => $metiers

        ]);
    }
    public function ajouterProfessionnel(ManagerRegistry $doctrine,Request $request){
        $professionnel = new professionnel();
        $form = $this->createForm(ProfessionnelType::class, $professionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $professionnel = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($professionnel);
            $entityManager->flush();

            return $this->render('professionnel/consulter.html.twig', ['professionnel' => $professionnel,]);
        }
        else
        {
            return $this->render('professionnel/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }
    public function professionnelLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Professionnel::class);

        $professionnels= $repository->findAll();
        return $this->render('professionnel/lister.html.twig', [
            'pProfessionnels' => $professionnels,]);

    }

    public function professionnelModifier(ManagerRegistry $doctrine, $id, Request $request){


        $professionnel = $doctrine->getRepository(Professionnel::class)->find($id);

        if (!$professionnel) {
            throw $this->createNotFoundException('Aucun professionnel trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(ProfessionnelModifierType::class, $professionnel);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $professionnel = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($professionnel);
                $entityManager->flush();

                return $this->render('professionnel/consulter.html.twig', ['professionnel' => $professionnel,]);
            }
            else{
                return $this->render('professionnel/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }

    }






















}
