<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class UserChooseOFType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('plainPassword', RepeatedType::class)
            ->remove('email', RepeatedType::class)
            ->remove('nom')
            ->remove('prenom')
            ->remove('roleAdmin', CheckboxType::class)
        ;
    }

    public function getParent()
    {
        return UserType::class;
    }

}