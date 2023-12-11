<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\TypeCours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormInterface;
use Doctrine\Persistence\ManagerRegistry;


class CoursModifierType extends AbstractType
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
            ->add('jour', EntityType::class, array('class' => 'App\Entity\Jour','choice_label' => 'libelle' , 'attr' => ['class' => 'form-control form-control-user']))
            ->add('professeur', EntityType::class, array('class' => 'App\Entity\Professeur','choice_label' => 'nom' , 'attr' => ['class' => 'form-control form-control-user']))
            ->add('typeInstrument', EntityType::class, array('class' => 'App\Entity\TypeInstrument','choice_label' => 'libelle' , 'attr' => ['class' => 'form-control form-control-user']))
            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier Cours', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
    }

    /*public function getParent(){
        return CoursType::class;
    }*/

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
