<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Export;
use App\Entity\Import;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $listClient = [];
        // Create 5 clients
        for ($i = 1; $i <= 5; $i++) {
            $client = new Client();
            $client->setNom('Client ' . $i);
            $client->setTel(rand(1000000000, 9999999999));
            $client->setEmail('client' . $i . '@example.com');
            $client->setAdresse('Adresse client ' . $i);

            $manager->persist($client);

            $listClient[]=$client;
        }
        // $product = new Product();
        // $manager->persist($product);
        // Création d'une vingtaine de livres ayant pour titre
        for ($i = 0; $i < 20; $i++) {
            $import = new Import();

            // Set the date to the current date and time
            $currentDate = new \DateTimeImmutable();
            $import->setDate($currentDate);

            // Set random values for the range properties
            $import->setRange5(rand(1, 100));
            $import->setRange10(rand(1, 100));
            $import->setRange15(rand(1, 100));
            $import->setRange20(rand(1, 100));
            $import->setRange25(rand(1, 100));
            $import->setRange30(rand(1, 100));
            $import->setClient($listClient[array_rand($listClient)]);
            $manager->persist($import);
        }

        for ($i = 0; $i < 20; $i++) {
            $export = new Export();

            // Set the date to the current date and time
            $currentDate2 = new \DateTimeImmutable();
            $export->setDate($currentDate2);

            // Set random values for the range properties
            $export->setRange5(rand(1, 100));
            $export->setRange10(rand(1, 100));
            $export->setRange15(rand(1, 100));
            $export->setRange20(rand(1, 100));
            $export->setRange25(rand(1, 100));
            $export->setRange30(rand(1, 100));
            $export->setClient($listClient[array_rand($listClient)]);
            $manager->persist($export);
        }
        $manager->flush();
    }
}
