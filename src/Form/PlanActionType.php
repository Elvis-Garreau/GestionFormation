<?php

namespace App\Form;

use App\Entity\PlanAction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organisation', TextareaType::class, [
                'label' => 'Saisissez les actions à mettre en place pour la partie Organisation:',
                'attr' => [
                    'placeholder' => 'vos actions ici'
                ]
            ])
            ->add('comprehension', TextareaType::class, [
                'label' => 'Saisissez les actions à mettre en place pour la partie Déroulement et Compréhension :',
                'attr' => [
                    'placeholder' => 'vos actions ici'
                ]
            ])
            ->add('autre', TextareaType::class, [
                'label' => 'Saisissez les actions à mettre en place pour la partie Autre :',
                'attr' => [
                    'placeholder' => 'vos actions ici'
                ]
            ])
            ->add('client', TextareaType::class, [
                'label' => 'Saisissez les actions à mettre en place pour la partie Client :',
                'attr' => [
                    'placeholder' => 'vos actions ici'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlanAction::class,
        ]);
    }
}
