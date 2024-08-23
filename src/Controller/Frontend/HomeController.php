<?php

namespace App\Controller\Frontend;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur pour la page d'accueil du frontend.
 */
class HomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil.
     *
     * @param CategorieRepository $repoCategorie Le repository pour accéder aux données des catégories.
     * @return Response Une réponse HTTP qui rend le template frontend/home/index.html.twig avec les catégories.
     */
    #[Route('/', name: 'app_home_page')]
    public function index(CategorieRepository $repoCategorie): Response
    {
        $categories = $repoCategorie->findAll();
        return $this->render('frontend/home_page/home.html.twig', [
            'categories' => $categories
        ]);
    }
}
