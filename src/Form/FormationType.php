<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_formation', null, [
                'label' => 'Intitulé de la Formation'
            ])
            ->add('moduleFormations', CollectionType::class, [
                'entry_type' => ModuleFormationType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false
            ])
            ->add('objectifs', CollectionType::class, [
                'entry_type' => ObjectifType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false
            ])
            ->add('prerequis', CollectionType::class, [
                'entry_type' => PrerequiType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false
            ])
            ->add('public', null, [
                'label' => 'Public de la formation'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
