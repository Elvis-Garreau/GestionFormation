<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanifSearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mot', SearchType::class, [
                'label' => 'Recherche par mots-clés',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrez un ou plusieurs mots-clés'
                ]
            ])
            ->add('periode', ChoiceType::class, [
                'label' => 'Statut :',
                'required' => false,
                'placeholder' => 'Aucun',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'Déja effectuée' => 1,
                    'En cours / À venir' => 2
                ],
                'expanded' => true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
