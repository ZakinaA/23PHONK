<?php

namespace App\Controller;

use App\Entity\TypeCours;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cours;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CoursType;
use App\Form\CoursModifierType;
use Twig\Environment;



class CoursController extends AbstractController
{
    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    private $twig;

    public function lister(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Cours::class);
        $cours = $repository->findAll();

        // Tri des cours par type d'instrument, jour (trié par ID) et heure
        usort($cours, function ($a, $b) {
            $dayIdA = $a->getJour()->getId();
            $dayIdB = $b->getJour()->getId();

            if ($dayIdA === $dayIdB) {
                $heureDebutA = $a->getHeureDebut()->getTimestamp();
                $heureDebutB = $b->getHeureDebut()->getTimestamp();
                return $heureDebutA - $heureDebutB;
            }

            return $dayIdA - $dayIdB;
        });

        // Calcul du nombre de cours par type d'instrument
        $countByTypeInstrument = [];
        foreach ($cours as $c) {
            $typeInstrument = $c->getTypeInstrument()->getLibelle();
            $countByTypeInstrument[$typeInstrument] = ($countByTypeInstrument[$typeInstrument] ?? 0) + 1;
        }

        return $this->render('cours/lister.html.twig', [
            'pCours' => $cours,
            'countByTypeInstrument' => $countByTypeInstrument,
        ]);
    }

    public function consulter(ManagerRegistry $doctrine, int $id){

        $cours= $doctrine->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException(
                'Aucun cours trouvé avec le numéro '.$id
            );
        }

        $elevesInscrits = $cours->getInscriptions();

        //return new Response('Cours : '.$cours->getNom());
        return $this->render('cours/consulter.html.twig', [
            'cours' => $cours,
            'elevesInscrits' => $elevesInscrits,]);
    }

    public function ajouter(ManagerRegistry $doctrine,Request $request){
        $cours = new cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nbPlaces = $cours->getNbPlaces();

            $typeCours = ($nbPlaces > 1) ? $doctrine->getRepository(TypeCours::class)->findOneBy(['libelle' => 'Collectif']) : $doctrine->getRepository(TypeCours::class)->findOneBy(['libelle' => 'Individuel']);

            if ($typeCours instanceof TypeCours) {
                $cours->setTypeCours($typeCours);
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();

            $this->addFlash('success', 'Cours created successfully!'); // Change the flash message
            return $this->redirectToRoute('coursLister');
        }
        else
        {
            return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifier(ManagerRegistry $doctrine, $id, Request $request){

        $cours = $doctrine->getRepository(Cours::class)->find($id);
        $elevesInscrits = $cours->getInscriptions();

        if (!$cours) {
            throw $this->createNotFoundException('Aucun cours trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(CoursModifierType::class, $cours);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $nbPlaces = $cours->getNbPlaces();

                $typeCours = ($nbPlaces > 1) ? $doctrine->getRepository(TypeCours::class)->findOneBy(['libelle' => 'Collectif']) : $doctrine->getRepository(TypeCours::class)->findOneBy(['libelle' => 'Individuel']);

                if ($typeCours instanceof TypeCours) {
                    $cours->setTypeCours($typeCours);
                }

                $entityManager = $doctrine->getManager();
                $entityManager->flush();
                return $this->render('cours/consulter.html.twig', ['cours' => $cours,'elevesInscrits' => $elevesInscrits,]);
            }
            else{
                return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }


}
