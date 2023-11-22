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
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('attestationAssurance')
            ->add('etatDetailleDebut')
            ->add('etatDetailleFin')
            ->add('eleve', EntityType::class, array('class' => 'App\Entity\Eleve','choice_label' => 'nom'))
            ->add('instrument', EntityType::class, array('class' => 'App\Entity\Instrument','choice_label' => 'numSENE'))
            ->add('interventions', EntityType::class, [
                'class' => 'App\Entity\Intervention',
                'choice_label' => 'decriptif',
                'multiple' => true,
                'expanded' => true,])

            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier contrat'))
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
