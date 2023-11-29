<?php

namespace App\Controller;

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

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

        $this->twig->addGlobal('jourToNumber', new \Twig\TwigFunction('jourToNumber', [$this, 'jourToNumber']));

    }

    public function lister(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Cours::class);
        $cours = $repository->findAll();

        $orderOfDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        // Fonction personnalisée pour rechercher l'index d'un élément dans un tableau
        $arraySearch = function ($needle, array $haystack) {
            foreach ($haystack as $index => $value) {
                if ($value === $needle) {
                    return $index;
                }
            }
            return false;
        };

        // Tri des cours par type d'instrument, jour et heure
        usort($cours, function ($a, $b) use ($orderOfDays, $arraySearch) {
            $dayComparison = $arraySearch($a->getJour()->getLibelle(), $orderOfDays) - $arraySearch($b->getJour()->getLibelle(), $orderOfDays);

            if ($dayComparison === 0) {
                $heureDebutA = $a->getHeureDebut()->getTimestamp();
                $heureDebutB = $b->getHeureDebut()->getTimestamp();
                return $heureDebutA - $heureDebutB;
            }

            return $dayComparison;
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

            $cours = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();

            return $this->render('cours/consulter.html.twig', ['cours' => $cours,]);
        }
        else
        {
            return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifier(ManagerRegistry $doctrine, $id, Request $request)
    {

        $cours = $doctrine->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException('Aucun cours trouvé avec le numéro ' . $id);
        } else {
            $form = $this->createForm(CoursModifierType::class, $cours);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $cours = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($cours);
                $entityManager->flush();
                return $this->render('cours/consulter.html.twig', ['cours' => $cours,]);
            } else {
                return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }

    private function getIndex($needle, $haystack)
    {
        return array_search($needle, $haystack);
    }

    public function jourToNumber($jour)
    {
        // Assurez-vous que les noms de jours correspondent exactement à ceux de votre base de données
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        return array_search($jour, $jours) + 1; // Ajoutez 1 car les numéros de jour de la semaine commencent à 1
    }
}
