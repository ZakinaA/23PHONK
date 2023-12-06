<?php

namespace App\Form;


use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('eleve', EntityType::class, [
                'label' => 'Nom de l\'élève',
                'class' => 'App\Entity\Eleve',
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control form-control-user'],

            ])
            ->add('instrument', EntityType::class, [
                'label' => 'L\'instrument du prêt',
                'class' => 'App\Entity\Instrument',
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control form-control-user'],

            ])

            ->add('dateDebut', DateType::class, [
                'label' => 'Date au début du prêt',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control form-control-user'],

            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de la fin du prêt',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control form-control-user'],
                'required' => false,

            ])
            ->add('attestationAssurance', FileType::class, [
                'label' => 'Attestation d\'assurance de l\'élève',
                'attr' => ['class' => 'form-control form-control-user'],
                'mapped' => false,
                'required' => false,
            ])
            ->add('etatDetailleDebut', null, [
                'label' => 'Etat détaillé de l\'instrument au début du prêt',
                'attr' => ['class' => 'form-control form-control-user'],

            ])
            ->add('etatDetailleFin', null, [
                'label' => 'Etat détaillé de l\'instrument à la fin du prêt',
                'attr' => ['class' => 'form-control form-control-user'],
                'required' => false,
            ])


           /* ->add('responsable', EntityType::class, [
                'class' => Responsable::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez un responsable',
                'attr' => ['class' => 'form-control form-control-user']
            ])*/

           ->add('enregistrer', SubmitType::class, array('label' => 'Nouveau contrat', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
    }








    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
