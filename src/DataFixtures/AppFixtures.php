<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Employe;
use App\Entity\Export;
use App\Entity\Import;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }
    public function load(ObjectManager $manager ,): void
    {

        // Création d'un user "normal"

        $user = new Employe();

        $user->setEmail("user@lapostapi.com");

        $user->setNom("employe");
        $user->setPrenom("test");
        $user->setTel(13345555);

        $user->setRoles(["ROLE_USER"]);

        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));

        $manager->persist($user);



        // Création d'un user admin

        $userAdmin = new Employe();

        $userAdmin->setEmail("admin@lapostapi.com");

        $userAdmin->setNom("admin");
        $userAdmin->setPrenom("test");
        $userAdmin->setTel(13345555);

        $userAdmin->setRoles(["ROLE_ADMIN"]);

        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));

        $manager->persist($userAdmin);

        $listClient = [];
        // Create 5 clients
        for ($i = 1; $i <= 5; $i++) {
            $client = new Client();
            $client->setNom('Client ' . $i);
            $client->setTel(rand(1000000000, 9999999999));
            $client->setEmail('client' . $i . '@example.com');
            $client->setAdresse('Adresse client ' . $i);
            $client->setRoles(["ROLE_CLIENT"]);

            $client->setPassword($this->userPasswordHasher->hashPassword($client, "password"));

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
