<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Media;
use App\Entity\Support;
use App\Form\MediaType;
use App\Form\SupportType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
 $builder
        ->add('title')
        ->add('media', ChoiceType::class, [
            'choices' => $options['media_choices'],
            'label' => 'Media',
            'choice_label' => 'label', 
        ])
        ->add('support', ChoiceType::class, [
            'choices' => $options['support_choices'],
            'label' => 'Support',
            'choice_label' => 'label',
        ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
            'media_choices' => [], 
            'support_choices' => [], 
        ]);
    }
}
