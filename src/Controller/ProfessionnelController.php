<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Professionnel;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


        if (!$professionnel) {
            throw $this->createNotFoundException(
                'Aucun contrat trouvé avec le numéro '.$id
            );
        }

        return $this->render('professionnel/consulter.html.twig', ['professionnel' => $professionnel,

        ]);
    }
























}
