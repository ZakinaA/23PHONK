<?php

namespace App\Form;

use App\Entity\Contrat;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control form-control-user']
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control form-control-user']
            ])
            ->add('attestationAssurance', null, ['attr' => ['class' => 'form-control form-control-user']])
            ->add('etatDetailleDebut', null, ['attr' => ['class' => 'form-control form-control-user']])
            ->add('etatDetailleFin', null, ['attr' => ['class' => 'form-control form-control-user']])
            ->add('eleve', EntityType::class, [
                'class' => 'App\Entity\Eleve',
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control form-control-user']
            ])
            ->add('instrument', EntityType::class, ['class' => 'App\Entity\Instrument', 'choice_label' => 'name', 'attr' => ['class' => 'form-control form-control-user']
            ])
            ->add('interventions', EntityType::class, [
                'class' => 'App\Entity\Intervention',
                'choice_label' => 'descriptif',
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'form-control form-control-user']
            ])

            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier contrat', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
        ;

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
