<?php

namespace App\Controller;


use App\Entity\Intervention;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Contrat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContratController extends AbstractController
{
    //#[Route('/contrat', name: 'app_contrat')]
    public function index(): Response
    {
        return $this->render('contrat/index.html.twig', [
            'controller_name' => 'ContratController',
        ]);
    }

    public function contratLister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Contrat::class);

        $contrats= $repository->findAll();
        return $this->render('contrat/lister.html.twig', [
            'pContrats' => $contrats,]);

    }
    public function consulterContrat(ManagerRegistry $doctrine, int $id){

        $contrat= $doctrine->getRepository(Contrat::class)->find($id);


        if (!$contrat) {
            throw $this->createNotFoundException(
                'Aucun contrat trouvé avec le numéro '.$id
            );
        }

        $interventions = $contrat->getInterventions();

        return $this->render('contrat/consulter.html.twig', [
            'interventions' => $interventions,
            'contrat' => $contrat,
        ]);
    }


}
