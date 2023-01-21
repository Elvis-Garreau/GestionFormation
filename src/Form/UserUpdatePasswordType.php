<?php


namespace App\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class UserUpdatePasswordType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('email', RepeatedType::class)
            ->remove('organisme', EntityType::class)
            ->remove('nom')
            ->remove('prenom')
            ->remove('username')
            ->remove('roleAdmin', CheckboxType::class)
        ;
    }

    public function getParent()
    {
        return UserType::class;
    }

}