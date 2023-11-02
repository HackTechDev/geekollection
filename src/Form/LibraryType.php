<?php

namespace App\Form;

use App\Entity\Library;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LibraryType extends AbstractType
{

    private $security;
    private $entityManager;
    public function __construct(Security $security)
    {
        $this->security = $security;
    
    }



    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

/*
        $connectedUser = $this->security->getUser();
        $userId = $connectedUser->getId();

        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er)  use ($userId)  {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.id = :userId')
                        ->setParameter('userId', $userId);
                },
                'choice_label' => 'email',
                'multiple' => true,
                'data' => [$connectedUser],
            ])
            ->add('item')
        ;
  */
        $builder
            ->add('item')
            ->add('information', TextareaType::class, [
                'label' => 'Information',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control'],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Library::class,
        ]);
    }
}
