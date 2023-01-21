<?php

namespace App\Form;

use App\Entity\RepresentantOf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepresentantOfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom du représentant :'
            ])
            ->add('prenom', null, [
                'label' => 'Prénom du représentant :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RepresentantOf::class,
        ]);
    }
}
