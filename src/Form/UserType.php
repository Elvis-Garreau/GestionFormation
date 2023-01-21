<?php

namespace App\Form;

use App\Entity\Organisme;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Veuillez rentrer deux fois le même mot de passe',
                'mapped' => false,
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le Mot de passe']
            ])
            ->add('email', RepeatedType::class, [
                'invalid_message' => 'Veuillez rentrer deux fois la même adresse mail',
                'required' => true,
                'first_options' => ['label' => 'Adresse mail'],
                'second_options' => ['label' => 'Confirmer l\'adresse mail']
            ])
            ->add('organisme', EntityType::class, [
                'class' => Organisme::class,
                'choice_label' => 'nomOf'
            ])
            ->add('nom', null, [
                'label' => 'Nom'
            ])
            ->add('prenom', null, [
                'label' => 'Prénom'
            ])
            ->add('roleAdmin', CheckboxType::class, [
                'label' => 'Mettre en Administrateur',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
