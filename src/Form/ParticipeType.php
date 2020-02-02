<?php

// src/Form/TaskType.php
namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Participer;
use Symfony\Component\Form\AbstractType;


class ParticipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role_brocante', ChoiceType::class, [
                'choices' => [
                    'Brocanteur' => 'Brocanteur',
                    'Marchand' => 'Marchand',
                    'Animateur' => 'Animateur',
                ],
                'label' => 'Quel rôle occuperez-vous au sein de cette brocante ?'

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class',Participer::class );
    }
}