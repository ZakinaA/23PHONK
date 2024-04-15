<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Responsable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;
use Doctrine\ORM\EntityRepository;




class EleveType extends AbstractType
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
            ->add('tel', TextType::class, [
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Numéro de téléphone',
                'constraints' => [
                    new Length(['min' => 10, 'max' => 10]),
                ],
            ])
            ->add('mail', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Mail'])
            ->add('responsables', EntityType::class, [
                'class' => 'App\Entity\Responsable',
                'choice_label' => function ($responsable){
                    return $responsable->getNom() . ' '. $responsable->getPrenom();
                },
                "attr" => ["class" => "form-select"],
                'multiple' => true,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('r')
                    ->orderBy('r.prenom','ASC');
                },
                'constraints' => [
                    new Count(['max' => 2, 'maxMessage' => 'Vous ne pouvez sélectionner que deux responsables au maximum.'])
                ]
            ])
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
