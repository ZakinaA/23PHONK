<?php

namespace App\Controller;


use App\Entity\Inscription;
use App\Form\InscriptionModifierType;
use App\Form\InscriptionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    public function lister(ManagerRegistry $doctrine): Response
    {

        $repository = $doctrine->getRepository(Inscription::class);

        $inscription= $repository->findAll();
        return $this->render('inscription/lister.html.twig', [
            'pInscriptions' => $inscription,]);

    }

    public function consulter(ManagerRegistry $doctrine, int $id){

        $inscription= $doctrine->getRepository(Inscription::class)->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException(
                'Aucuen inscription trouvé avec le numéro '.$id
            );
        }


        return $this->render('inscription/consulter.html.twig', [
            'inscription' => $inscription,
            ]);
    }

    public function ajouter(ManagerRegistry $doctrine,Request $request){
        $inscription = new inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $inscription = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();

            return $this->render('inscription/consulter.html.twig', [
                'inscription' => $inscription,
                ]);
        }
        else
        {
            return $this->render('eleve/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifier(ManagerRegistry $doctrine, $id, Request $request)
    {

        $inscription = $doctrine->getRepository(Inscription::class)->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException('Aucune inscription trouvé avec le numéro ' . $id);
        } else {
            $form = $this->createForm(InscriptionModifierType::class, $inscription);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $inscription = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($inscription);
                $entityManager->flush();
                return $this->render('inscription/consulter.html.twig', ['inscription' => $inscription,]);
            } else {
                return $this->render('inscription/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }
}

