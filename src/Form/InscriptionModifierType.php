<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateInscription', DateType::class, [
                'label' => 'Date au début du prêt',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            ->add('cours', EntityType::class, [
                'class' => 'App\Entity\Cours',
                'attr' => ['class' => 'form-control form-control-user'],
                'choice_label' => function ($inscrit) {
                    return $inscrit->getId() . '  ' . $inscrit->getJour()->getLibelle() . '  ' . $inscrit->getTypeCours()->getLibelle() . '  ' . $inscrit->getTypeInstrument()->getLibelle() . '  ' . $inscrit->getProfesseur()->getNom();
                }])
            ->add('eleve', EntityType::class, [
                'class' => 'App\Entity\Eleve',
                'attr' => ['class' => 'form-control form-control-user'],
                'choice_label' => function ($eleve) {
                    return $eleve->getPrenom(). '  ' . $eleve->getNom();
                }])
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvelle Inscription', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
