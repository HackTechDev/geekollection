<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\Media;
use App\Entity\Support;
use App\Form\MediaType;
use App\Form\SupportType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('gencode')
            ->add('media', ChoiceType::class, [
                'choices' => $options['media_choices'],
                'label' => 'Media',
                'choice_label' => 'label', 
            ])
            ->add('support', ChoiceType::class, [
                'choices' => $options['support_choices'],
                'label' => 'Support',
                'choice_label' => 'label',
            ])
            ->add('box', ChoiceType::class, [
                'choices' => $options['box_choices'],
                'label' => 'Box',
                'choice_label' => 'label', 
            ])
            ->add('edition', ChoiceType::class, [
                'choices' => $options['edition_choices'],
                'label' => 'Edition',
                'choice_label' => 'label',
            ])
            ->add('oeuvrelink', TextareaType::class, [
                'label' => 'Oeuvre Link',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('objectlink', TextareaType::class, [
                'label' => 'Object Link',
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
            'media_choices' => [], 
            'support_choices' => [], 
            'box_choices' => [], 
            'edition_choices' => [], 
        ]);
    }
}
