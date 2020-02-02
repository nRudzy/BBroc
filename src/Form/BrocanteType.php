<?php

namespace App\Form;

use App\Entity\Brocante;
use App\Entity\Villesfr;
use App\Repository\VillesfrRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrocanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom",
                'attr'  => [
                    'placeholder' => "ex : Brocante de Villeurbanne",
                ],
            ])
            ->add('lieu', EntityType::class, [
                'class'         => Villesfr::class,
                'choice_label'  => function (Villesfr $villesfr) {
                    return $villesfr->getVilleCodePostal() . " - " . $villesfr->getVilleNomReel();
                },
                'query_builder' => function (VillesfrRepository $villesfrRepository) {
                    return $villesfrRepository->createQueryBuilder('v')
                        ->orderBy('v.ville_departement', 'ASC')
                        ->orderBy('v.ville_code_postal', 'ASC');
                },
                'group_by'      => "ville_departement",
                'label'         => "Lieu",
                'placeholder'   => "ex : Villeurbanne",
                'attr'          => [
                    'class' => 'select2',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Brocante'      => 'Brocante',
                    'Vide-Grenier'  => 'Vide-Grenier',
                    'Vide-Dressing' => 'Vide-Dressing',
                ],
                'label'   => "Type de la brocante",
            ])
            ->add('rue', TextType::class, [
                'label' => "Rue complète de la brocante",
                'attr'  => [
                    'placeholder' => "Place de la mairie, 95 Rue Montgolfier",
                ],
            ])
            ->add('date', DateTimeType::class, [
                'label'       => "Date",
                'date_widget' => "single_text",
                'time_widget' => "choice",
            ])
            ->add('prix', NumberType::class, [
                'label' => "Prix d'entrée de la brocante (en €)",
                'attr'  => [
                    'placeholder' => "ex : 10",
                ],
            ])
            ->add('description', TextareaType::class, [
                'label'    => "Description",
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'data'     => '',
                'required' => false,
                'label'    => 'Image',
                'attr'     => [
                    'accept'      => 'image/*',
                    'placeholder' => "Choisissez une image",
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', Brocante::class);
    }
}