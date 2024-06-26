<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Instrument;
use App\Entity\Intervention;
use App\Form\ContratModifierType;
use App\Form\ContratType;
use App\Form\InstrumentType;
use App\Form\InterventionModifierType;
use App\Form\InterventionType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class InterventionController extends AbstractController
{
    //#[Route('/intervention', name: 'app_intervention')]
    public function index(): Response
    {
        return $this->render('intervention/index.html.twig', [
            'controller_name' => 'InterventionController',
        ]);
    }

    public function interventionLister(ManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(Intervention::class);

        $interventions = $repository->findAll();
        return $this->render('intervention/lister.html.twig', [
            'pInterventions' => $interventions,]);
    }

    public function consulterIntervention(ManagerRegistry $doctrine, int $id)
    {

        $intervention = $doctrine->getRepository(Intervention::class)->find($id);


        if (!$intervention) {
            throw $this->createNotFoundException(
                'Aucun contrat trouvé avec le numéro ' . $id
            );
        }

        //return new Response('Intervention : '.$intevention->getNom());
        return $this->render('intervention/consulter.html.twig',
            ['intervention' => $intervention,]);
    }

    public function listerByInstrument(ManagerRegistry $doctrine, int $id)
    {

        //$interventions = $doctrine->getRepository(Intervention::class)->findBy(['instrument' => $id]);
        $instrument = $doctrine->getRepository(Instrument::class)->find($id);
        $interventions = $instrument->getInterventions();

        if (!$interventions) {
            return $this->render('intervention/consulterByInstrument.html.twig',
                ['message' => 'false']);
        }

        //return new Response('Intervention : '.$intevention->getNom());
        return $this->render('intervention/consulterByInstrument.html.twig',
            ['pIntervention' => $interventions,'pInstrument' => $instrument]);
    }

    public function ajouterIntervention(Request $request, ManagerRegistry $doctrine, $instrumentId): Response
    {
        $instrument = $doctrine->getRepository(Instrument::class)->find($instrumentId);

        if (!$instrument) {
            throw $this->createNotFoundException('Instrument non trouvé');
        }

        $intervention = new Intervention();
        $intervention->setInstrument($instrument);

        $form = $this->createForm(InterventionType::class, $intervention);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($intervention);
            $entityManager->flush();

            $this->addFlash('success', 'Intervention créée avec succès!');

            return $this->redirectToRoute('consulterInstrument', ['id' => $instrument->getId()]);
        }

        $instruments = $doctrine->getRepository(Instrument::class)->findAll();

        return $this->render('intervention/ajouter.html.twig', [
            'form' => $form->createView(),
            'instrument' => $instrument,
            'instruments' => $instruments,
        ]);
    }

    /*public function ajouterInterventionByContrat(ManagerRegistry $doctrine, Request $request, $id)
    {
        // Récupérer l'instrument par son id
        $instrument = $doctrine->getRepository(Instrument::class)->find($id);

        // Vérifier si l'instrument existe
        if (!$instrument) {
            throw $this->createNotFoundException('Instrument non trouvé avec l\'identifiant ' . $id);
        }

        // Créer une nouvelle intervention liée à l'instrument
        $intervention = new Intervention();
        $intervention->setInstrument($instrument);

        var_dump($intervention->getInstrument());

        // Ajouter l'association avec le contrat
        $intervention->setContrats($instrument->getContrat());

        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($intervention);
            $entityManager->flush();

            // Rediriger vers la page de consultation de l'instrument ou du contrat
            return $this->redirectToRoute('app_contrat_consulter', ['id' => $instrument->getContrat()->getId()]);
        }

        return $this->render('intervention/ajouter.html.twig', [
            'form' => $form->createView(),
            'instrument' => $instrument,
        ]);
    }*/

    public function modifierIntervention(ManagerRegistry $doctrine, $id, Request $request)
    {


        $intervention = $doctrine->getRepository(Intervention::class)->find($id);

        if (!$intervention) {
            throw $this->createNotFoundException('Aucune intervention trouvé avec le numéro ' . $id);
        } else {
            $form = $this->createForm(InterventionModifierType::class, $intervention);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $intervention = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($intervention);
                $entityManager->flush();


                return $this->render('intervention/consulter.html.twig', ['intervention' => $intervention,]);
            } else {
                return $this->render('intervention/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }


    }

}
