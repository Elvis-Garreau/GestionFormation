<?php

namespace App\Form;

use App\Entity\Veille;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule', TextType::class, [
                'label' => 'Intitulé de la veille :'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Déscription :'
            ])
            ->add('veilleFile', FileType::class, [
                'required' => false,
                'label' => 'Document de preuve :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Veille::class,
        ]);
    }
}
