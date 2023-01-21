<?php

namespace App\Form;

use App\Entity\EnqueteFroid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnqueteFroidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duree_stage', ChoiceType::class, [
                'label' => 'La durée du stage vous a-t-elle semblé adaptée ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('support_formation', ChoiceType::class, [
                'label' => 'Les supports de formation étaient-ils clairs et utiles ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('formateur_clair', ChoiceType::class, [
                'label' => 'Le formateur était-il clair et dynamique ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('formateur_adapte', ChoiceType::class, [
                'label' => 'Le formateur a-t-il adapté la formation aux stagiaires ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('programme_clair', ChoiceType::class, [
                'label' => 'Le programme était-il clair et précis ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('programme_adapte', ChoiceType::class, [
                'label' => 'Le programme était-il adapté à vos besoins ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('objectif_formation', ChoiceType::class, [
                'label' => 'Les objectifs de la formation ont-ils été clairement annoncés ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('compris_objectif', ChoiceType::class, [
                'label' => 'Avez-vous compris et retenu les objectifs de la formation ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('exercices_pertinents', ChoiceType::class, [
                'label' => 'Les exercices et activités étaient-ils pertinents ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('competences_ameliorees', ChoiceType::class, [
                'label' => 'Cette formation améliore-t-elle vos compétences ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('condition_accueil', ChoiceType::class, [
                'label' => 'Les conditions d’accueil ont-elles été de qualité ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('apprecie_global', ChoiceType::class, [
                'label' => 'Avez-vous apprécié la formation dans sa globalité ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'pas du tout' => 0,
                    'insuffisamment' => 1,
                    'en partie' => 2,
                    'totalement' => 3
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('recommande', ChoiceType::class, [
                'label' => 'Recommanderiez vous cette formation ?',
                'label_attr' => ['class'=>'radio-inline'],
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('points_forts', TextareaType::class, [
                'label' => 'Points forts de la formation :',
                'required' => false,
                'attr' => ['placeholder'=>'Entrez votre text ici']
            ])
            ->add('points_faibles', TextareaType::class, [
                'label' => 'Points faibles de la formation :',
                'required' => false,
                'attr' => ['placeholder'=>'Entrez votre text ici']
            ])
            ->add('autres_remarques', TextareaType::class, [
                'label' => 'Autres remarques :',
                'required' => false,
                'attr' => ['placeholder'=>'Entrez votre text ici']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnqueteFroid::class,
        ]);
    }
}
