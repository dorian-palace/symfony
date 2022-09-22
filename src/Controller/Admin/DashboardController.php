<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Controller\ArticleController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ){

    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
      //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        //return parent::index();
        $url = $this->adminUrlGenerator
            ->setController(ArticleCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    //    return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('blog');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::section('Blog');

        yield MenuItem::section('Article');

        yield MenuItem::subMenu('Article', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Create Article', 'fas fa-list', Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Article', 'fas fa-eye', Article::class)
         //   MenuItem::linkToCrud('')
        ]);

        yield MenuItem::subMenu('Comment', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Create Comment', 'fas fa-list', Comment::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Comment', 'fas fa-eye', Comment::class)
        ]);

        yield MenuItem::subMenu('User', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Create Article', 'fas fa-list', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Article', 'fas fa-eye', User::class)
        ]);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
