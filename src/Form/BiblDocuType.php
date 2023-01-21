<?php

namespace App\Form;

use App\Entity\BiblDocu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BiblDocuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile01', FileType::class, [
                'required' => false,
                'label' => 'Programme :'
            ])
            ->add('imageFile02', FileType::class, [
                'required' => false,
                'label' => 'Fiche de renseignement :'
            ])
            ->add('imageFile03', FileType::class, [
                'required' => false,
                'label' => 'Pré requis et buletin d\'inscription :'
            ])
            ->add('imageFile04', FileType::class, [
                'required' => false,
                'label' => 'Convention :'
            ])
            ->add('imageFile05', FileType::class, [
                'required' => false,
                'label' => 'Convocation :'
            ])
            ->add('imageFile06', FileType::class, [
                'required' => false,
                'label' => 'Émargement :'
            ])
            ->add('imageFile07', FileType::class, [
                'required' => false,
                'label' => 'Enquête à chaud :'
            ])
            ->add('imageFile08', FileType::class, [
                'required' => false,
                'label' => 'Enquête client:'
            ])
            ->add('imageFile09', FileType::class, [
                'required' => false,
                'label' => 'Enquête à froid :'
            ])
            ->add('imageFile10', FileType::class, [
                'required' => false,
                'label' => 'Attestation de présence :'
            ])
            ->add('imageFile11', FileType::class, [
                'required' => false,
                'label' => 'Dépouillement :'
            ])
            ->add('imageFile12', FileType::class, [
                'required' => false,
                'label' => 'Plan d\'action :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BiblDocu::class,
        ]);
    }
}
