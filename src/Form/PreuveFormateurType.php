<?php

namespace App\Form;

use App\Entity\PreuveFormateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreuveFormateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule', TextType::class, [
                'label' => 'Intitulé de l\'élément'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Déscription de l\'élément :'
            ])
            ->add('preuveFile', FileType::class, [
                'required' => false,
                'label' => 'Document de preuve :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PreuveFormateur::class,
        ]);
    }
}
