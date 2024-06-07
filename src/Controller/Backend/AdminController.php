<?php

namespace App\Controller\Backend;

use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin')]
    public function index(ProduitRepository $repoProduit, CategorieRepository $repoCategorie): Response
    {
        // // Récupérer toutes les catégories
        $categories = $repoCategorie->findAll();

        // Récupérer tous les produits
        $produits = $repoProduit->findAll();

        return $this->render('backend/adminDashboard.html.twig', [
            'produits' => $produits,
            'categories' => $categories,
        ]);
    }
}