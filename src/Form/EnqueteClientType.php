<?php

namespace App\Form;

use App\Entity\EnqueteClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnqueteClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('offre_disponible', ChoiceType::class, [
                'label' => 'L’offre est-elle claire et disponible ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('formalites_clair', ChoiceType::class, [
                'label' => 'Les formalités d’inscription sont-elles claires et facile d’accès ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('infos_avant_formation', ChoiceType::class, [
                'label' => 'Les informations transmises avant la formation ont-elles étés bien communiqués ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('elements_contractuels', ChoiceType::class, [
                'label' => 'Les éléments contractuels ont-ils été bien respectés ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('formation_utile_competences', ChoiceType::class, [
                'label' => 'La formation a-t-elle été utile dans le développement des compétences recherchées ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('apprecie_relation_of', ChoiceType::class, [
                'label' => 'Avez-vous apprécié la relation avec notre organisme dans sa globalité ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('recommande', ChoiceType::class, [
                'label' => 'Recommanderiez vous notre organisme ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnqueteClient::class,
        ]);
    }
}
