<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ItemType extends AbstractType
{

    private $security;
    private $entityManager;
    public function __construct(Security $security)
    {
        $this->security = $security;
    
    }



    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('information', TextareaType::class, [
                'label' => 'Information',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('selectedData', HiddenType::class,
            )
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
