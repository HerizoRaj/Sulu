<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Abonnement;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ticketsDemiJournees')
            ->add('ticketsJournees')
            ->add('ticketsMois')
            ->add('ticketsHeuresSDR')
            ->add('montant')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'id',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
