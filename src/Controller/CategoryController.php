<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/{slug}', name:'list')]
    public function list(Category $category): Response
    {
        $articles = $category->getArticles();

        return $this->render('category/list.html.twig',
            compact('category','articles'));
        // Alternative syntax for the same render before
        // return $this->>render('category/list.html.twig', [
        //      'category' => $category,
        //      'article' => $articles
        //]);
    }
}
