<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_societe', null, [
                'label' => 'Nom de la société :'
            ])
            ->add('adresse_rue', null, [
                'label' => 'Adresse :'
            ])
            ->add('adresse_cp', null, [
                'label' => 'Code Postal :'
            ])
            ->add('adresse_ville', null, [
                'label' => 'Ville :'
            ])
            ->add('siret', null, [
                'label' => 'Numéro de SIRET :'
            ])
            ->add('representant_nom', null, [
                'label' => 'Nom du représentant :'
            ])
            ->add('representant_prenom', null, [
                'label' => 'Prenom du représentant :'
            ])
            ->add('representant_mail', null, [
                'label' => 'Adresse e-Mail :'
            ])
            ->add('representant_telephone', null, [
                'label' => 'Numéro de téléphone :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
