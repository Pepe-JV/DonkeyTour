<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $services = [
            [
                'type' => 'Burroterapia',
                'basePrice' => 40,
                'description' => 'Sesión de terapia asistida con burros',
                'duration' => new \DateTime('01:00:00'),
                'maxAphor' => 8,
                'leenguage' => 'es',
            ],
            [
                'type' => 'Tour',
                'basePrice' => 25,
                'description' => 'Ruta guiada por Granada con burros',
                'duration' => new \DateTime('02:00:00'),
                'maxAphor' => 12,
                'leenguage' => 'es',
            ],
            [
                'type' => 'Cumpleaños',
                'basePrice' => 30,
                'description' => 'Fiesta de cumpleaños con burros',
                'duration' => new \DateTime('01:30:00'),
                'maxAphor' => 15,
                'leenguage' => 'es',
            ],
            [
                'type' => 'Despedida',
                'basePrice' => 35,
                'description' => 'Despedida de soltero/a con burros',
                'duration' => new \DateTime('02:00:00'),
                'maxAphor' => 10,
                'leenguage' => 'es',
            ],
        ];

        foreach ($services as $data) {
            $service = new Service();
            $service->setType($data['type']);
            $service->setBasePrice($data['basePrice']);
            $service->setDescription($data['description']);
            $service->setDuration($data['duration']);
            $service->setMaxAphor($data['maxAphor']);
            $service->setLeenguage($data['leenguage']);
            $service->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($service);
        }
        $manager->flush();
    }
}
