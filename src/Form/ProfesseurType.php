<?php

namespace App\Form;

use App\Entity\Professeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;

class ProfesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Nom',
                'constraints' => [
                    new Length(['max' => 50]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Prénom',
                'constraints' => [
                    new Length(['max' => 50]),
                ],
            ])
            ->add('numRue', NumberType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Numéro de rue',
                'constraints' => [
                    new Range(['min' => 1, 'max' => 50]),
                ],
            ])
            ->add('rue', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Rue'])
            ->add('copos', NumberType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Code Postal',
                'constraints' => [
                    new Length(['min' => 5, 'max' => 5]),
                ],
            ])
            ->add('ville', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Ville'])
            ->add('tel', NumberType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Numéro de téléphone',
                'constraints' => [
                    new Length(['min' => 10, 'max' => 10]),
                ],
            ])
            ->add('mail', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Mail'])
            ->add('typeInstruments',
                EntityType::class, [
                    'attr' => ['class' => 'form-control form-control-user'],
                    'class' => 'App\Entity\TypeInstrument',
                    'choice_label' => 'libelle',
                    'multiple' => true,
                    'expanded' => true,])
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouveau Professeur', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
