<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class FormationEditNomType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('moduleFormations', CollectionType::class)
            ->remove('objectifs', CollectionType::class)
            ->remove('prerequis', CollectionType::class)
            ->remove('public')
        ;
    }

    public function getParent()
    {
        return FormationType::class;
    }

}