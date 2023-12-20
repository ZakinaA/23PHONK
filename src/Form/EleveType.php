<?php

namespace App\Form;

use App\Entity\Eleve;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Nom'])
            ->add('prenom', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Prénom'])
            ->add('numRue', NumberType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Numéro de rue'])
            ->add('rue', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Rue'])
            ->add('copos', NumberType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Code Postal'])
            ->add('ville', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Ville'])
            ->add('tel', NumberType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Numéro de téléphone'])
            ->add('mail', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Mail'])
            ->add('responsables',
                EntityType::class, [
                    'class' => 'App\Entity\Responsable',
                    'choice_label' => function ($eleve) {
                        return $eleve->getNom() . ' ' . $eleve->getPrenom();},

                    'multiple' => true,
                    'expanded' => true,])
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvelle Elève', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
