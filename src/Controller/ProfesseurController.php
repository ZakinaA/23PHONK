<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Professeur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ProfesseurController extends AbstractController
{
    #[Route('/professeur', name: 'app_professeur')]
    public function index(): Response
    {
        return $this->render('professeur/index.html.twig', [
            'controller_name' => 'ProfesseurController',
        ]);
    }

    public function lister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Professeur::class);

        $professeur= $repository->findAll();
        return $this->render('professeur/lister.html.twig', [
            'pProfesseurs' => $professeur,]);

    }

    public function consulter(ManagerRegistry $doctrine, int $id){

        $professeur= $doctrine->getRepository(Professeur::class)->find($id);

        if (!$professeur) {
            throw $this->createNotFoundException(
                'Aucun professeur trouvé avec le numéro '.$id
            );
        }

        $typesInstruments = $professeur->getTypeInstruments();

        return $this->render('professeur/consulter.html.twig', [
            'professeur' => $professeur,
            'typeInstruments' => $typesInstruments,]);
    }

}
