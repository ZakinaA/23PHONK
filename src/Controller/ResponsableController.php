<?php

namespace App\Controller;

use App\Entity\Responsable;
use App\Form\ResponsableModifierType;
use App\Form\ResponsableType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResponsableController extends AbstractController
{
    #[Route('/responsable', name: 'app_responsable')]
    public function index(): Response
    {
        return $this->render('responsable/index.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }
    public function lister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Responsable::class);

        $responsable= $repository->findAll();
        return $this->render('responsable/lister.html.twig', [
            'pResponsables' => $responsable,]);

    }

    public function consulter(ManagerRegistry $doctrine, int $id){

        $responsable= $doctrine->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException(
                'Aucun responsable trouvé avec le numéro '.$id
            );
        }

        $eleves = $responsable->getEleves();

        return $this->render('responsable/consulter.html.twig', [
            'responsable' => $responsable,
            'eleves' => $eleves]);
    }

    public function ajouter(ManagerRegistry $doctrine,Request $request){
        $responsable = new responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $responsable = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($responsable);
            $entityManager->flush();

            return $this->render('responsable/consulter.html.twig', ['responsable' => $responsable,]);
        }
        else
        {
            return $this->render('responsable/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifier(ManagerRegistry $doctrine, $id, Request $request)
    {

        $responsable = $doctrine->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Aucun responsable trouvé avec le numéro ' . $id);
        } else {
            $form = $this->createForm(ResponsableModifierType::class, $responsable);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $responsable = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($responsable);
                $entityManager->flush();
                return $this->render('responsable/consulter.html.twig', ['responsable' => $responsable,]);
            } else {
                return $this->render('responsable/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }
}
