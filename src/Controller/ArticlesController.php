<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articles', name: 'articles_')]
class ArticlesController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(): Response
    {
        return $this->render('articles/index.html.twig');
    }

    #[Route('/{slug}', name:'details')]
    public function details(Article $article): Response
    {
        $images = $article->getImages();

        return $this->render('articles/details.html.twig', [
            'article' => $article,
            'images' => $images,
        ]);    }
}