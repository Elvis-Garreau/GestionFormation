<?php


namespace App\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class UserUpdateForUserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('plainPassword', RepeatedType::class)
            ->remove('roleAdmin', CheckboxType::class)
            ->remove('organisme', EntityType::class)
        ;
    }

    public function getParent()
    {
        return UserType::class;
    }

}