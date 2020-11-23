<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName',    TextType::class, array(
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'placeholder' => 'Nom d\'utilisateur',
                    'data-rules' => json_encode([
                        'required' => true,
                        'minlength' => '3'
                    ]),
                    'data-messages' => json_encode([
                        'required' => 'Veuillez remplir ce champ',
                        'minlength' => 'Votre nom doit contenir au moins 3 lettres'
                    ]),
                    'class' => 'input_validation'
                ]
            ))
            ->add('email',  EmailType::class, array (
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Adresse email',
                    'data-rules' => json_encode([
                        'email' => true,
                        "required" => true
                    ]),
                    'data-messages' => json_encode([
                        'email' => 'Veuillez saisir une adresse email valide.',
                        'required' => "Veuillez saisir une adresse email."
                    ]),
                    'class' => 'input_validation'
                ]))
            ->add('password',    TextType::class, array(
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'data-rules' => json_encode([
                        'required' => true,
                        'minlength' => '8'
                    ]),
                    'data-messages' => json_encode([
                        'required' => 'Veuillez remplir ce champ',
                        'minlength' => 'Votre nom doit contenir au moins 8 caractères'
                    ]),
                    'class' => 'input_validation'
                ]
            ))
            ->add('confirm_password',    TextType::class, array(
                'label' => 'Confirmer mot de passe',
                'attr' => [
                    'placeholder' => 'Répétez votre mot de passe',
                    'data-messages' => json_encode([
                        'required' => 'Veuillez remplir ce champ',
                ]),
                    'class' => 'input_validation'
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
