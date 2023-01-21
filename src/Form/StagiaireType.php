<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom du stagiaire :'
            ])
            ->add('prenom', null, [
                'label' => 'Prénom du stagiaire :'
            ])
            ->add('mail', null, [
                'label' => 'e-Mail du stagiaire :',
                'required' => true
            ])
            ->add('telephone', null, [
                'label' => 'Numéro de téléphone du stagiaire :'
            ])
            ->add('qualite', null, [
                'label' => 'Qualité du stagiaire :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
