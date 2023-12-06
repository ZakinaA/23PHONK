<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;


class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ageMini', IntegerType::class, [
                'attr' => [
                    'min' => 0, // Empêche les nombres négatifs
                    'class' => 'form-control form-control-user'
                ],
            ])
            ->add('ageMaxi', IntegerType::class, [
                'attr' => [
                    'min' => 0, // Empêche les nombres négatifs
                    'class' => 'form-control form-control-user'
                ],
            ])
            ->add('nbPlaces', IntegerType::class, [
                'attr' => [
                    'min' => 1, // Empêche les nombres négatif
                    'class' => 'form-control form-control-user'
                ],
            ])
            ->add('heureDebut', TimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control form-control-user']
            ])
            ->add('heureFin', TimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control form-control-user']
            ])
            ->add('typeCours', EntityType::class, [
                'class' => 'App\Entity\TypeCours',
                'choice_label' => 'libelle',
                'constraints' => [
                    new Assert\Callback(['callback' => [$this, 'validateNbPlacesAndTypeCours']]),
                ], 'attr' => ['class' => 'form-control form-control-user']
            ])
            ->add('jour', EntityType::class, array('class' => 'App\Entity\Jour','choice_label' => 'libelle' , 'attr' => ['class' => 'form-control form-control-user']))
            ->add('professeur', EntityType::class, array('class' => 'App\Entity\Professeur','choice_label' => 'nom' , 'attr' => ['class' => 'form-control form-control-user']))
            ->add('typeInstrument', EntityType::class, array('class' => 'App\Entity\TypeInstrument','choice_label' => 'libelle' , 'attr' => ['class' => 'form-control form-control-user']))
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouveau Cours', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
    public function validateNbPlacesAndTypeCours($value, ExecutionContextInterface $context)
    {
        $nbPlaces = $context->getRoot()->get('nbPlaces')->getData();
        $typeCours = $value;

        // Check if typeCours is not null
        if ($typeCours !== null) {
            // If the number of places is 1, typeCours must be "Individuel"
            if ($nbPlaces === 1 && $typeCours->getLibelle() !== 'Individuel') {
                $context->buildViolation('Si le nombre de place est de 1 le type de cours doit être Individuel.')
                    ->atPath('typeCours')
                    ->addViolation();
            }

            // If the number of places is greater than 1, typeCours must be "Collectif"
            if ($nbPlaces > 1 && $typeCours->getLibelle() !== 'Collectif') {
                $context->buildViolation('Si le nombre de place est superieure à 1 le type de cours doit être Collectif.')
                    ->atPath('typeCours')
                    ->addViolation();
            }
        }
    }
}
