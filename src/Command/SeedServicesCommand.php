<?php

namespace App\Command;

use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:seed:services',
    description: 'Crea servicios iniciales como Burroterapia, Tour, Cumpleaños y Despedida.'
)]
class SeedServicesCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = [
            [
                'type' => 'Burroterapia',
                'basePrice' => 40,
                'description' => 'Sesión de terapia asistida con burros',
                'duration' => new \DateTime('01:00:00'),
                'maxAphor' => 8,
                'leenguage' => 'es',
                'typeService' => 'burroterapia',
            ],
            [
                'type' => 'Tour',
                'basePrice' => 25,
                'description' => 'Ruta guiada por Granada con burros',
                'duration' => new \DateTime('02:00:00'),
                'maxAphor' => 12,
                'leenguage' => 'es',
                'typeService' => 'tour',
            ],
            [
                'type' => 'Cumpleaños',
                'basePrice' => 30,
                'description' => 'Fiesta de cumpleaños con burros',
                'duration' => new \DateTime('01:30:00'),
                'maxAphor' => 15,
                'leenguage' => 'es',
                'typeService' => 'cumpleanos',
            ],
            [
                'type' => 'Despedida',
                'basePrice' => 35,
                'description' => 'Despedida de soltero/a con burros',
                'duration' => new \DateTime('02:00:00'),
                'maxAphor' => 10,
                'leenguage' => 'es',
                'typeService' => 'despedida',
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
            $this->entityManager->persist($service);
        }
        $this->entityManager->flush();
        $output->writeln('<info>Servicios iniciales creados correctamente.</info>');
        return Command::SUCCESS;
    }
}
