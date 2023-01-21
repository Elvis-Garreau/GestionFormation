<?php

namespace App\Form;


use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('choixcontact', ChoiceType::class, [
                'label' => 'Pour quelle raisons souhaitez vous nous contacter ?',
                'choices' => [
                    'Question sur l\'utilisation de l\'outil' => 1,
                    'Question technique sur l\'outil' => 2
                ]
            ])
            ->add('objet', TextType::class, [
                'label' => 'Objet de votre message :',
                'attr' => [
                    'placeholder' => 'Objet'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message :',
                'attr' => [
                    'placeholder' => 'Tapez votre message ici'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
