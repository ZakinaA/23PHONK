<?php

namespace App\Controller;



use DateTime;
use App\Entity\Intervention;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Form\ContratModifierType;
use App\Form\ContratType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Contrat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


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

    public function contratListerParInstrument(ManagerRegistry $doctrine, int $id){

        $repository = $doctrine->getRepository(Contrat::class);

        $contrats= $repository->findBy(['instrument' => $id]);
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

        $eleve = $contrat->getEleve();

        $interventions = $contrat->getInterventions();


        return $this->render('contrat/consulter.html.twig', [
            'interventions' => $interventions,
            'contrat' => $contrat,
            'eleve' => $eleve,


        ]);
    }
    public function ajouterContrat(ManagerRegistry $doctrine, Request $request, KernelInterface $kernel)
    {
        $contrat = new Contrat();

        $contrat->setDateFin(new DateTime('2024-06-30'));

        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez le fichier téléchargé
            $file = $form->get('attestationAssurance')->getData();

            if ($file instanceof UploadedFile) {
                $entityManager = $doctrine->getManager();
                $entityManager->persist($contrat);
                $entityManager->flush();

                $contratId = $contrat->getId();

                $fileName = $contratId . '.' . $file->guessExtension();

                $publicDirectory = $kernel->getProjectDir() . '/public';

                $uploadDirectory = $publicDirectory . '/ressources/by/AttestationAssurance';

                $file->move(
                    $uploadDirectory,
                    $fileName
                );
                $contrat->setAttestationAssurance($fileName);

                $entityManager->persist($contrat);

                $entityManager->flush();
            }
            else
            {
                //$contrat->setAttestationAssurance(null);
            }

            $interventions = $contrat->getInterventions();

            return $this->render('contrat/consulter.html.twig', [
                'contrat' => $contrat,
                'interventions' => $interventions,
            ]);
        } else {
            return $this->render('contrat/ajouter.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }


    public function ContratModifier(ManagerRegistry $doctrine, $id, Request $request){


        $contrat = $doctrine->getRepository(Contrat::class)->find($id);

        if (!$contrat) {
            throw $this->createNotFoundException('Aucun contrat trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(ContratModifierType::class, $contrat);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $contrat = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($contrat);
                $entityManager->flush();

                $interventions = $contrat->getInterventions();
                return $this->render('contrat/consulter.html.twig', ['contrat' => $contrat,'interventions' => $interventions]);
            }
            else{
                return $this->render('contrat/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }

    }










}
