<?php

namespace App\Form;

use App\Entity\Intervention;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'label' => 'Date au début de l\'intervention',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control form-control-user'],

            ])

            ->add('dateFin', DateType::class, [
                'label' => 'Date de la fin de l\'intervention',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control form-control-user'],

            ])

            ->add('descriptif', null, [
                'label' => 'Descriptif de l\'intervention',
                'attr' => ['class' => 'form-control form-control-user'],

            ])

            ->add('prix', null, [
                'label' => 'Prix de l\'intervention',
                'attr' => ['class' => 'form-control form-control-user'],

            ])
            ->add('professionnel', EntityType::class, [
                'class' => 'App\Entity\Professionnel',
                'label' => 'Professionnel',
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionner un professionnel',
                'required' => false, // Si le choix est facultatif
                'attr' => ['class' => 'form-control form-control-user'],
            ])



            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvelle intervention', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }

}
