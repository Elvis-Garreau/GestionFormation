<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Planif;
use App\Repository\ClientRepository;
use App\Repository\FormateurRepository;
use App\Repository\FormationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PlanifType extends AbstractType
{
    protected $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser()->getOrganisme()->getId();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('adresse', null, [
                'label' => 'Adresse :'
            ])
            ->add('code_postal', null, [
                'label' => 'Code postal :'
            ])
            ->add('ville', null, [
                'label' => 'Ville :'
            ])
            ->add('etage', ChoiceType::class, [
                'choices' => [
                    'RDC' => 'RDC',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10'
                ],
                'label' => 'Étage :'
            ])
            ->add('salle', null, [
                'label' => 'Salle :'
            ])
            ->add('programme', EntityType::class, [
                'class' => Formation::class,
                'query_builder' => function (FormationRepository $formationRepository) {
                    return $formationRepository->createQueryBuilder('u')
                        ->where('u.organisme = '. $this->user);
                },
                'choice_label' => 'nom_plus_temps',
                'label' => 'Ref du programme :'
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'query_builder' => function (ClientRepository $clientRepository) {
                    return $clientRepository->createQueryBuilder('u')
                        ->where('u.organisme = '. $this->user);
                },
                'choice_label' => 'nom_societe',
                'label' => 'Client :'
            ])
            ->add('formateur', EntityType::class, [
                'class' => Formateur::class,
                'query_builder' => function (FormateurRepository $formateurRepository) {
                    return $formateurRepository->createQueryBuilder('u')
                        ->where('u.organisme = '. $this->user);
                },
                'choice_label' => 'formateur_prenom',
                'label' => 'Formateur :'
            ])
            ->add('stagiaires', CollectionType::class, [
                'entry_type' => StagiaireType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'required' => true
            ])
            ->add('prix', null, [
                'label' => 'Prix de la formation :'
            ])
            ->add('dates', CollectionType::class, [
                'entry_type' => DatesType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'required' => true
            ])
            ->add('modaliteOrga', TextareaType::class, [
                'label' => 'Modalités d\'organisation :',
                'attr' => ['placeholder' => 'ecrivez vos modalités d\'organisation ici']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Planif::class,
        ]);
    }
}