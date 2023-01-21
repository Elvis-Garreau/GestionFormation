<?php

namespace App\Form;

use App\Entity\Formateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('formateur_nom', null, [
                'label' => 'Nom du formateur'
            ])
            ->add('cvFile', FileType::class, [
                'required' => false,
                'label' => 'CV :'
            ])
            ->add('formateur_prenom', null, [
                'label' => 'Prénom du formateur'
            ])
            ->add('formateur_mail', null, [
                'label' => 'Adresse Mail du formateur'
            ])
            ->add('formateur_phone', null, [
                'label' => 'Numéro de téléphone du formateur'
            ])
            ->add('preuveFormateurs', CollectionType::class, [
                'entry_type' => PreuveFormateurType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formateur::class,
        ]);
    }
}
