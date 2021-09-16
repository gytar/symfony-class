<?php

namespace App\Form;

use App\Entity\Bet;
use App\Entity\Game;
use App\Entity\User;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'name',
                'label' => 'Game',
            ])
            ->addEventListener(FormEvents::POST_SET_DATA, function (
                FormEvent $event
            ) {
                $product = $event->getData();
                $form = $event->getForm();

                if (null !== $product) {
                    $form->add('challenger', EntityType::class, [
                        'class' => User::class,
                        'choice_label' => 'name',
                    ])
                    ->add('amount', TypeTextType::class, [
                        'label' => 'Amount',
                    ]);
                }
            });

            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bet::class,
        ]);
    }
}
