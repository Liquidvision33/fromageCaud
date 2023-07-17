<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/articles', name:'admin_articles_')]
class ArticlesController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(): Response
    {
        return $this->render('admin/articles/index.html.twig');
    }

    #[Route('/add', name:'add')]
    public function add(): Response
    {
        return $this->render('admin/articles/index.html.twig');
    }

    #[Route('/edit/{id}', name:'edit')]
    public function edit(Article $article): Response
    {
        return $this->render('admin/articles/index.html.twig');
    }

    #[Route('/delete/{id}', name:'delete')]
    public function delete(Article $article): Response
    {
        $this->denyAccessUnlessGranted('ARTICLE_DELETE', $article);
        return $this->render('admin/articles/index.html.twig');
    }
}
