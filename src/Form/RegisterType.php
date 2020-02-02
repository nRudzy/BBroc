<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;


/**
 * Class UtilisateurType
 * @package App\Form
 */
class RegisterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom",
                'attr'  => ['class' => 'text-uppercase'],
            ])
            ->add('prenom', TextType::class, [
                'label' => "Prénom",
                'attr'  => ['class' => 'text-capitalize'],
            ])
            ->add('birth_date', BirthdayType::class, [
                'label' => "Date de naissance",
            ])
            ->add('email', RepeatedType::class, [
                'type'            => EmailType::class,
                'invalid_message' => "Les adresses mail doivent correspondrent",
                'first_options'   => ['label' => "Adresse mail"],
                'second_options'  => ['label' => "Confirmation de l'adresse mail"],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'            => PasswordType::class,
                'invalid_message' => "Les mots de passe doivent correspondrent",
                'first_options'   => [
                    'label'       => "Mot de passe",
                    'attr'        => [
                        'pattern' => ".{8,}",
                        'title'   => "Veuillez entrer au moins 8 caractères",
                    ],
                    'constraints' => [new Constraints\Length(['min' => 8, 'minMessage' => "Le mot de passe doit comporter au moins {{ limit }} caractères"]),],
                ],
                'second_options'  => ['label' => "Confirmation du mot de passe"],
                'mapped'          => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Inscription",
                'attr'  => ['class' => 'btn btn-primary pull-right'],
            ]);
    }
}
