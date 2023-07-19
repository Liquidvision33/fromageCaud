<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Coupons;
use App\Entity\Images;
use App\Entity\Orders;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[isGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(CategoryCrudController::class)
            ->setController(ArticleCrudController::class)
            ->setController(UserCrudController::class)
            ->setController(ImagesCrudController::class)
            ->setController(OrdersCrudController::class)
            ->setController(CouponsCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La Fromagerie de Caudéran')
            ->setFaviconPath("{{ asset('/public/assets/images/Logo3.jpg') }} ");
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Accueil du site', 'fas fa-home', $this->generateUrl('app_home'));
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Membres', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-list', Article::class);
        yield MenuItem::linkToCrud('Images', 'fas fa-video', Images::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-euro', Orders::class);
        yield MenuItem::linkToCrud('Coupons', 'fas fa-tags', Coupons::class);
    }
}
