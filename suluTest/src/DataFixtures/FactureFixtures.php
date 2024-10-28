<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Facture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FactureFixtures extends Fixture
{
    public function load(ObjectManager $manager) : void
    {
        $faker = Factory::create('fr_FR');

        // Récupérer tous les clients existants
        $clientRepository = $manager->getRepository(Client::class);
        $clients = $clientRepository->findAll();

        foreach ($clients as $client) {
            // Générer plusieurs factures pour chaque client
            for ($i = 0; $i < mt_rand(1, 5); $i++) {
                $facture = new Facture();
                $montantHt = $faker->randomFloat(2, 50, 500);
                $tva = 20.0;
                $montantTtc = $montantHt * (1 + $tva / 100);

                $facture->setClient($client)
                    ->setDate($faker->dateTimeThisYear)
                    ->setMontant($montantHt)
                    ->setTva($tva)
                    ->setMontantTtc($montantTtc)
                    ->setType($faker->randomElement(['abonnement', 'achat crédit']));

                $manager->persist($facture);
            }
        }

        $manager->flush();
    }
}
