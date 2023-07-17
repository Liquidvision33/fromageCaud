<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticlesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/articles', name:'admin_articles_')]
class ArticlesController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(): Response
    {
        return $this->render('admin/articles/index.html.twig');
    }

    #[Route('/add', name:'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $article = new Article();

        $articleForm = $this->createForm(ArticlesFormType::class, $article);

        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $slug = $slugger->slug($article->getName());
            $article->setSlug($slug);
            $price = $article->getPrice() * 100;
            $article->setPrice($price);

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');

            return $this->redirectToRoute('admin_articles_index');
        }

        return $this->render('admin/articles/add.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    #[Route('/edit/{id}', name:'edit')]
    public function edit(Article $article, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $price = $article->getPrice() / 100;
        $article->setPrice($price);

        $articleForm = $this->createForm(ArticlesFormType::class, $article);

        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $slug = $slugger->slug($article->getName());
            $article->setSlug($slug);

            $price = $article->getPrice() * 100;
            $article->setPrice($price);

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Produit modifié avec succès');

            return $this->redirectToRoute('admin_articles_index');
        }

        return $this->render('admin/articles/edit.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    #[Route('/delete/{id}', name:'delete')]
    public function delete(Article $article): Response
    {
        $this->denyAccessUnlessGranted('ARTICLE_DELETE', $article);
        return $this->render('admin/articles/index.html.twig');
    }
}
