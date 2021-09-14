<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('startAt', DateTimeType::class)
        ->add('name')
        ->add('challengers', EntityType::class, [
            'class' => User::class,
            'query_builder' => function (UserRepository $repository) {
                $qb = $repository->createQueryBuilder('user');
                return $qb
                    ->andWhere($qb->expr()->like('user.roles', ':role'))
                    ->setParameter('role', '%CHALLENGER%')
                    ->orderBy('user.email', 'ASC');
            },
            'choice_label' => 'name',
            'multiple' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
