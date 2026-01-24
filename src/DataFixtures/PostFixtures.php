<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Crear categorías primero
        $categorySymfony = new Category();
        $categorySymfony->setName('Symfony');
        $categorySymfony->setSlug('symfony');
        $categorySymfony->setDescription('Todo sobre el framework Symfony y sus componentes');
        $manager->persist($categorySymfony);

        $categoryPHP = new Category();
        $categoryPHP->setName('PHP');
        $categoryPHP->setSlug('php');
        $categoryPHP->setDescription('Desarrollo y buenas prácticas en PHP');
        $manager->persist($categoryPHP);

        $categoryFrontend = new Category();
        $categoryFrontend->setName('Frontend');
        $categoryFrontend->setSlug('frontend');
        $categoryFrontend->setDescription('Desarrollo frontend, CSS, JavaScript y más');
        $manager->persist($categoryFrontend);

        $categoryDatabase = new Category();
        $categoryDatabase->setName('Base de Datos');
        $categoryDatabase->setSlug('base-de-datos');
        $categoryDatabase->setDescription('Gestión y optimización de bases de datos');
        $manager->persist($categoryDatabase);

        // Post 1: Introducción a Symfony
        $post1 = new Post();
        $post1->setTitle('Introducción a Symfony 7');
        $post1->setSlug('introduccion-symfony-7');
        $post1->setSummary('Descubre las nuevas características de Symfony 7 y cómo empezar tu primer proyecto.');
        $post1->setContent(
            "Symfony 7 es la última versión del popular framework PHP que revoluciona el desarrollo web.\n\n" .
            "En este artículo exploraremos las principales novedades:\n\n" .
            "1. Mejoras en el rendimiento: Symfony 7 es un 20% más rápido que la versión anterior.\n" .
            "2. Nuevos atributos PHP 8: Aprovecha las últimas características del lenguaje.\n" .
            "3. AssetMapper mejorado: Gestión de assets más simple y eficiente.\n" .
            "4. Mejor integración con TypeScript: Soporte nativo para desarrollo frontend moderno.\n\n" .
            "Para empezar, solo necesitas ejecutar:\n" .
            "composer create-project symfony/skeleton my-project\n\n" .
            "¡Y estarás listo para crear aplicaciones web profesionales!"
        );
        $post1->setPublishedAt(new \DateTime('2026-01-15 10:30:00'));
        $post1->setAuthor('María González');
        $post1->addCategory($categorySymfony);
        $post1->addCategory($categoryPHP);
        $manager->persist($post1);

        // Post 2: Doctrine ORM
        $post2 = new Post();
        $post2->setTitle('Dominando Doctrine ORM');
        $post2->setSlug('dominando-doctrine-orm');
        $post2->setSummary('Aprende a trabajar con bases de datos en Symfony usando Doctrine ORM de forma profesional.');
        $post2->setContent(
            "Doctrine ORM es el sistema de mapeo objeto-relacional más potente para PHP.\n\n" .
            "Conceptos clave que debes dominar:\n\n" .
            "Entidades: Clases PHP que representan tablas de la base de datos.\n" .
            "Repositorios: Clases para consultar datos de forma organizada.\n" .
            "Migraciones: Control de versiones de tu esquema de base de datos.\n" .
            "Relaciones: OneToMany, ManyToOne, ManyToMany y OneToOne.\n\n" .
            "Ejemplo de una consulta personalizada:\n" .
            "SELECT p FROM App\\Entity\\Post p WHERE p.publishedAt > :date\n\n" .
            "Con Doctrine, gestionar bases de datos nunca fue tan elegante y seguro.\n" .
            "Olvídate del SQL manual y enfócate en tu lógica de negocio."
        );
        $post2->setPublishedAt(new \DateTime('2026-01-18 14:45:00'));
        $post2->setAuthor('Carlos Rodríguez');
        $post2->addCategory($categoryDatabase);
        $post2->addCategory($categorySymfony);
        $manager->persist($post2);

        // Post 3: Twig Templates
        $post3 = new Post();
        $post3->setTitle('Plantillas Twig: Guía Completa');
        $post3->setSlug('plantillas-twig-guia-completa');
        $post3->setSummary('Todo lo que necesitas saber sobre Twig, el motor de plantillas de Symfony.');
        $post3->setContent(
            "Twig es el motor de plantillas más elegante y seguro para PHP.\n\n" .
            "Ventajas de usar Twig:\n\n" .
            "Sintaxis limpia y legible: {{ variable }} para mostrar datos.\n" .
            "Seguridad por defecto: Auto-escape de HTML para prevenir XSS.\n" .
            "Herencia de plantillas: Crea layouts base y extiéndelos.\n" .
            "Filtros potentes: |date, |upper, |nl2br y muchos más.\n\n" .
            "Ejemplo de herencia:\n" .
            "{% extends 'base.html.twig' %}\n" .
            "{% block content %}\n" .
            "  <h1>Mi contenido</h1>\n" .
            "{% endblock %}\n\n" .
            "Twig separa la lógica de la presentación, haciendo tu código más mantenible.\n" .
            "¡Es la herramienta perfecta para crear interfaces de usuario profesionales!"
        );
        $post3->setPublishedAt(new \DateTime('2026-01-21 09:15:00'));
        $post3->setAuthor('Laura Martínez');
        $post3->addCategory($categoryFrontend);
        $post3->addCategory($categorySymfony);
        $manager->persist($post3);

        // Guardar todos los posts en la base de datos
        $manager->flush();
    }
}
