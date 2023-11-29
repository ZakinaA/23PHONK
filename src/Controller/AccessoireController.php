<?php

namespace App\Controller;

use App\Entity\Accessoire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccessoireController extends AbstractController
{
//    #[Route('/accessoire', name: 'app_accessoire')]
    public function index(): Response
    {
        return $this->render('accessoire/index.html.twig', [
            'controller_name' => 'AccessoireController',
        ]);
    }

    public function lister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Accessoire::class);

        $accessoire= $repository->findAll();
        return $this->render('accessoire/lister.html.twig', [
            'pAccessoires' => $accessoire,]);
    }
}
