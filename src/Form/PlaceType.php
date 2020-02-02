<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taillePlace', NumberType::class, [
                'label' => "Taille de la place en m²",
            ])
            ->add('prixPlace', NumberType::class, [
                'label' => "Prix de la place en €",
            ])
            ->add('nbPlaces', NumberType::class, [
                'label' => "Nombre de places à ajouter avec ces paramètres",
            ]);
    }
}