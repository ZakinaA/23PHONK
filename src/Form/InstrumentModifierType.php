<?php

namespace App\Form;

use App\Entity\Instrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstrumentModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numSerie', TextType::class, ['attr' => ['class' => 'form-control form-control-user']])
            ->add('dateAchat', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control form-control-user']
            ])
            ->add('prixAchat', NumberType::class, ['attr' => ['class' => 'form-control form-control-user']])
            ->add('utilisation', TextType::class, ['attr' => ['class' => 'form-control form-control-user']])
            ->add('cheminImage', TextType::class, ['attr' => ['class' => 'form-control form-control-user']])
            ->add('type', EntityType::class, array('class' => 'App\Entity\TypeInstrument','choice_label' => 'libelle', 'attr' => ['class' => 'form-control form-control-user']))
            ->add('marque', EntityType::class, array('class' => 'App\Entity\Marque','choice_label' => 'libelle', 'attr' => ['class' => 'form-control form-control-user']))
            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier instrument', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
