<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('shop/index.html.twig', [
            'categories' =>$categoryRepository->findBy([], ['categoryOrder'=>'asc'])
        ]);
    }
}