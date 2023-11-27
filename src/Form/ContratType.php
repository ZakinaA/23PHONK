<?php

namespace App\Form;


use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Entity\Intervention;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('attestationAssurance')
            ->add('etatDetailleDebut')
            ->add('etatDetailleFin')
            ->add('eleve', EntityType::class, array('class' => 'App\Entity\Eleve','choice_label' => 'nom'))
          ->add('instrument', EntityType::class, array('class' => 'App\Entity\Instrument','choice_label' => 'numSerie'))
           ->add('interventions', EntityType::class, [
                'class' => 'App\Entity\Intervention',
                'choice_label' => 'descriptif',
                'multiple' => true,
                'expanded' => true,])

            ->add('enregistrer', SubmitType::class, array('label' => 'Nouveau contrat'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
