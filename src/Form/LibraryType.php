<?php

namespace App\Form;

use App\Entity\Library;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;

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
        ->add('item'); // Other fields you want to include

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Library::class,
        ]);
    }
}
