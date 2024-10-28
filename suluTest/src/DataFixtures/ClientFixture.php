<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        $client = new Client();
        $client->setCivilite($faker->randomElement(['abonnement', 'achat crédit']))
            ->setNom($faker->firstName())
            ->setPrenom($faker->lastName())
            ->setEmailPrincipal($faker->email())
            ->setEmailFacturation($faker->email())
            ->setPassword($faker->password())
            ->setAdresse($faker->address())
            ->setTel($faker->phoneNumber())
            ->setVille($faker->city())
            ->setRegion("région")
            ->setCodePostal($faker->postcode())
            ->setPays($faker->country())
            ->setRaisonSociale($faker->company())
            ->setNumTva("FR32123456789")
            ->setSiret("36252187900034")
            ->setRibIban("FR7630001007941234567890185")
            ->setRibBic("CRLYFRPPXXX")
            ->setDateInscription(new \DateTime());

        $manager->flush();
    }
}
