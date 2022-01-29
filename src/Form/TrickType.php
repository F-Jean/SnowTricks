<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',    TextType::class, array (
                'label' => 'Nom de la figure',
                'row_attr' => [
                    'class' => 'trick-title-input'
                ],
            ))
            ->add('description',    TextareaType::class, array (
                'label' => 'Description',
                'row_attr' => [
                    'class' => 'trick-description-input'
                ],
            ))
            ->add('category', EntityType::class, array (
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Groupe de la figure',
                'row_attr' => [
                    'class' => 'trick-category-input'
                ],
            ))
            ->add('illustrations', CollectionType::class, [
                'error_bubbling' => false,
                'entry_type' => IllustrationType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('videos', CollectionType::class, [
                'error_bubbling' => false,
                'entry_type' => VideoType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
