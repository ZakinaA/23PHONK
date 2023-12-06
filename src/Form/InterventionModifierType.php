<?php

namespace App\Form;

use App\Entity\Intervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionModifierType extends AbstractType
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


            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier intervention', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
