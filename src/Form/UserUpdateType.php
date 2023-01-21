<?php


namespace App\Form;

use \Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class UserUpdateType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('plainPassword', RepeatedType::class)
        ;
    }

    public function getParent()
    {
        return UserType::class;
    }

}