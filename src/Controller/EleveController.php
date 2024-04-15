<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveModifierType;
use App\Form\EleveType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;



class EleveController extends AbstractController
{
    #[Route('/eleve', name: 'app_eleve')]
    public function index(): Response
    {
        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'EleveController',
        ]);
    }

    public function lister(ManagerRegistry $doctrine): Response
    {

        $repository = $doctrine->getRepository(Eleve::class);

        $eleve= $repository->findAll();
        return $this->render('eleve/lister.html.twig', [
            'pEleves' => $eleve,]);

    }

    public function consulter(ManagerRegistry $doctrine, int $id){

        $eleve= $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException(
                'Aucun élève trouvé avec le numéro '.$id
            );
        }

        $responsables = $eleve->getResponsables();

        return $this->render('eleve/consulter.html.twig', [
            'eleve' => $eleve,
            'responsables' => $responsables,]);
    }

    public function ajouter(ManagerRegistry $doctrine,Request $request){
        $eleve = new eleve();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        $responsables = $eleve->getResponsables();

        if ($form->isSubmitted() && $form->isValid()) {

            $eleve = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($eleve);
            $entityManager->flush();

            return $this->render('eleve/consulter.html.twig', [
                'eleve' => $eleve,
                'responsables' => $responsables,]);
        }
        else
        {
            return $this->render('eleve/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifier(ManagerRegistry $doctrine, $id, Request $request)
    {

        $eleve = $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException('Aucun élève trouvé avec le numéro ' . $id);
        } else {
            $form = $this->createForm(EleveModifierType::class, $eleve);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $eleve = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($eleve);
                $entityManager->flush();
                return $this->render('eleve/consulter.html.twig', ['eleve' => $eleve,]);
            } else {
                return $this->render('eleve/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }
}
