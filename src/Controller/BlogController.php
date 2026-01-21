<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog')]
    public function index(PostRepository $postRepository): Response
    {
        // Obtener todos los posts ordenados por fecha de publicación descendente
        $posts = $postRepository->findBy([], ['publishedAt' => 'DESC']);

        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/{slug}', name: 'app_blog_show')]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Post $post): Response
    {
        // Symfony busca automáticamente el Post por slug
        // Si no existe, lanza automáticamente una excepción 404

        return $this->render('blog/show.html.twig', [
            'post' => $post,
        ]);
    }
}
