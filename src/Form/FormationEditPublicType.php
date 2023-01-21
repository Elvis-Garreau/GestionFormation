<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class FormationEditPublicType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('moduleFormations', CollectionType::class)
            ->remove('objectifs', CollectionType::class)
            ->remove('prerequis', CollectionType::class)
            ->remove('nom_formation')
        ;
    }

    public function getParent()
    {
        return FormationType::class;
    }

}