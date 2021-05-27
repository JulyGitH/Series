<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('overview', TextareaType::class, [
                'required' => false,
                'label' => 'Synopsis'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Cancelled' => 'cancelled',
                    'Ended' => 'ended',
                    'Returning' => 'returning'
                ],
                'multiple' => false
            ])
            ->add('vote')
            ->add('popularity')
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Drama' => 'drama',
                    'Romance' => 'romance',
                    'Horror' => 'horror',
                    'Musical' => 'musical'
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('firstAirDate', DateType::class)
            ->add('lastAirDate', DateType::class, [
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('backdrop')
            ->add('poster', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize'=>'7024k',
                        'mimeTypesMessage'=>'Unhallowed format'
                    ])
                ]
            ])
            ->add('tmdbId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
