<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resetPassword',   RepeatedType::class, array (
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Confirmer mot de passe'),
                'invalid_message' => 'Le mot de passe n\'est pas le même !',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 8, 
                        'minMessage' => 'Le mot de passe doit faire minimum {{ limit }} caractères.'
                    ]),
                    new Regex([
                        '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/',
                        'message' => 'Le mot de passe {{ value }} ne respect pas les demandes.'
                    ]),
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
