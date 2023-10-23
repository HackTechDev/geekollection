<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
           ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'multiple' => true, // Allow multiple roles to be selected
                'choices' => [
                    'Role 1' => 'USER_ROLE'
                    // Add more roles as needed
                ],
                'required' => true, // You can set this to false if roles are not required
            ])
            ->add('password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
