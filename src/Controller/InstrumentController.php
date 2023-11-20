<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Instrument;
use App\Entity\Intervention;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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


        $repository = $doctrine->getRepository(Intervention::class);
        $intervention= $repository->findBy(['id' => $id]);

        if (!$instrument) {
            throw $this->createNotFoundException(
                'Aucun instrument trouvé avec le numéro '.$id
            );
        }

        //return new Response('Etudiant : '.$etudiant->getNom());
        return $this->render('instrument/consulter.html.twig',
            ['instrument' => $instrument, 'pIntervention' => $intervention]);
    }
}
