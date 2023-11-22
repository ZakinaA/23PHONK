<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Entity\Intervention;
use App\Entity\TypeInstrument;
use App\Form\InstrumentModifierType;
use App\Form\InstrumentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class InstrumentController extends AbstractController
{
//    #[Route('/instrument', name: 'app_instrument')]
    public function index(): Response
    {
        return $this->render('instrument/index.html.twig', [
            'controller_name' => 'InstrumentController',
        ]);
    }
    public function lister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Instrument::class);

        $instrument= $repository->findAll();
        return $this->render('instrument/lister.html.twig', [
            'pInstruments' => $instrument,]);
    }
    public function consulter(ManagerRegistry $doctrine, int $id){

        $instrument= $doctrine->getRepository(Instrument::class)->find($id);

        $intervention= $doctrine->getRepository(Intervention::class)->findBy(['instrument' => $id]);

        if (!$instrument) {
            throw $this->createNotFoundException(
                'Aucun instrument trouvé avec le numéro '.$id
            );
        }

        //return new Response('Etudiant : '.$etudiant->getNom());
        return $this->render('instrument/consulter.html.twig',
            ['instrument' => $instrument, 'pIntervention' => $intervention]);
    }

    public function ajouter(Request $request, PersistenceManagerRegistry $doctrine):Response
    {
        $instrument = new instrument();
        $form = $this->createForm(InstrumentType::class, $instrument);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($instrument);
            $entityManager->flush();

            $this->addFlash('success', 'Instrument created successfully!'); // Change the flash message
            return $this->redirectToRoute('listerInstrument');
        }

        return $this->render('instrument/ajouter.html.twig', [ // Change the template path
            'form' => $form->createView(),
        ]);
    }

    public function modifier(ManagerRegistry $doctrine, $id, Request $request){

        //récupération de l'étudiant dont l'id est passé en paramètre
        $instrument = $doctrine->getRepository(Instrument::class)->find($id);
        $intervention= $doctrine->getRepository(Intervention::class)->findBy(['instrument' => $id]);

        if (!$instrument) {
            throw $this->createNotFoundException('Aucun instrument trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(InstrumentModifierType::class, $instrument);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $instrument = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($instrument);
                $entityManager->flush();
                return $this->render('instrument/consulter.html.twig', ['instrument' => $instrument, 'pIntervention' => $intervention]);
            }
            else{
                return $this->render('instrument/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }

}
