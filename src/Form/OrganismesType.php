<?php

namespace App\Form;

use App\Entity\Organisme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganismesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_of', null, [
                'label' => 'Nom de l\'organsime :'
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Logo de l\'Organisme :'
            ])
            ->add('livretFile', FileType::class, [
                'required' => false,
                'label' => 'Livret d\'accueil :'
            ])
            ->add('adresse_voie', null, [
                'label' => 'Adresse :'
            ])
            ->add('adresse_CP', null, [
                'label' => 'Code Postal :'
            ])
            ->add('adresse_ville', null, [
                'label' => 'Ville :'
            ])
            ->add('declaration_activite', null, [
                'label' => 'Nuémro de déclaration d\'activité :'
            ])
            ->add('siret', null, [
                'label' => 'Numéro de SIRET :'
            ])
            ->add('representant', CollectionType::class, [
                'entry_type' => RepresentantOfType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false
            ])
            ->add('telephone', null, [
                'label' => 'Numéro de téléphone :'
            ])
            ->add('mail', null, [
                'label' => 'Adresse e-Mail :'
            ])
            ->add('capital', null, [
                'label' => 'Capital de l\'entreprise:'
            ])
            ->add('codeApe', null, [
                'label' => 'Code APE :'
            ])
            ->add('tvaFr', null, [
                'label' => 'Numéro de TVA FR :'
            ])
            ->add('RCS', null, [
                'label' => 'RCS (ville) :'
            ])
            ->add('formeJuridique', null, [
                'label' => 'Forme Juridique :'
            ])
            ->add('cfNom', null, [
                'label' => 'Nom :'
            ])
            ->add('cfPrenom', null, [
                'label' => 'Prénom :'
            ])
            ->add('cfMail', null, [
                'label' => 'Adresse e-Mail :'
            ])
            ->add('cfPhone', null, [
                'label' => 'Numéro de téléphone :'
            ])
            ->add('accesHandicape', ChoiceType::class, [
                'label' => 'Vos formations sont elles accessibles aux personnes en situation de handicap ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organisme::class,
        ]);
    }
}
