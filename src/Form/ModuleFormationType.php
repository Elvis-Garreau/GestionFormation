<?php

namespace App\Form;

use App\Entity\ModuleFormation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_module',null, [
                'label' => 'Nom du Module'
            ])
            ->add('nombre_heure', null, [
                'label' => 'Nombre d\'heure pour ce module'
            ])
            ->add('description', null, [
                'label' => 'Détails du Module'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ModuleFormation::class,
        ]);
    }
}
