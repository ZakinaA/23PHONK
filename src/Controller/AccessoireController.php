<?php

namespace App\Controller;

use App\Entity\Accessoire;
use App\Entity\Instrument;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    public function ajaxAddAccessory(ManagerRegistry $doctrine, Request $request)
    {

        try {
            $accessoryData = json_decode($request->getContent(), true);

            $accessory = new Accessoire();
            $accessory->setLibelle($accessoryData['libelle']);


            $instrumentId = $accessoryData['instrumentId'];
            $instrument = $doctrine->getRepository(Instrument::class)->find($instrumentId);

            if (!$instrument) {

                return new JsonResponse(['success' => false, 'error' => 'Instrument not found.']);
            }

            // Assurez-vous de définir l'instrument correctement, selon votre logique
            $accessory->setInstrument($instrument);

            // Enregistrer l'accessoire en base de données
            $entityManager = $doctrine->getManager();
            $entityManager->persist($accessory);
            $entityManager->flush();

            // Répondre à la requête AJAX avec un JSON indiquant le succès
            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception for further investigation


            // Return an error response to the client
            return $this->render('test.html.twig', ['error' => $e]);
//            return new JsonResponse(['success' => false, 'error' => $e]);
        }
    }

    public function ajaxDelAccessory(ManagerRegistry $doctrine, Request $request)
    {

        try {
            $accessoryData = json_decode($request->getContent(), true);

            $entityManager = $doctrine->getManager();
            $accessoire= $doctrine->getRepository(Accessoire::class)->find($accessoryData['accid']);


            $entityManager->remove($accessoire);
            return $this->render('test.html.twig', ['error' => $entityManager]);

            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {

            // Return an error response to the client
//            return new JsonResponse(['success' => false, 'e' => $e]);
            return $this->render('test.html.twig', ['error' => $e]);
        }
    }

    public function lister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Accessoire::class);

        $accessoire= $repository->findAll();
        return $this->render('accessoire/lister.html.twig', [
            'pAccessoires' => $accessoire,]);
    }
}
