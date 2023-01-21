<?php

namespace App\Form;

use App\Entity\MailAmont;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailAmontType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom du contact :'
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom du contact :'
            ])
            ->add('mailClient', EmailType::class, [
                'label' => 'e-Mail du contact :'
            ])
            ->add('nouveauClient', ChoiceType::class, [
                'label' => 'Nouveau client ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0
                ],
                'expanded' => true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MailAmont::class,
        ]);
    }
}
