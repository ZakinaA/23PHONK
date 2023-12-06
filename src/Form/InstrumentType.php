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

class InstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numSerie', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Numéro de série'])
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Nom (ex : org-01)'])
            ->add('dateAchat', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control form-control-user'],
                'label' => 'Date d\'achat'
            ])
            ->add('prixAchat', NumberType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Prix d\'achat'])
            ->add('utilisation', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Utilisation'])
            ->add('cheminImage', TextType::class, ['attr' => ['class' => 'form-control form-control-user'], 'label' => 'Lien de l\'image'])
            ->add('type', EntityType::class, array('class' => 'App\Entity\TypeInstrument','choice_label' => 'libelle', 'attr' => ['class' => 'form-control form-control-user']))
            ->add('marque', EntityType::class, array('class' => 'App\Entity\Marque','choice_label' => 'libelle', 'attr' => ['class' => 'form-control form-control-user']))
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvel instrument', 'attr' => ['class' => 'btn btn-primary btn-user btn-block']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
