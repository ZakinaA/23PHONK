<?php

namespace App\Form;

use App\Entity\Professionnel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du professionnel',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            ->add('numRue', IntegerType::class, [
                'label' => 'Numéro de la rue du professionnel',
                'attr' => [ 'min' => 0,'class' => 'form-control form-control-user'],
            ])
            ->add('rue', TextType::class, [
                'label' => 'La rue du professionnel',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            ->add('copos', IntegerType::class, [
                'label' => 'Code Postal du professionnel',
                'attr' => [ 'min' => 0,'class' => 'form-control form-control-user'],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville du professionnel',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Mail du professionnel',
                'attr' => ['class' => 'form-control form-control-user'],
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Nouveau professionnel',
                'attr' => ['class' => 'btn btn-primary btn-user btn-block'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professionnel::class,
        ]);
    }
}