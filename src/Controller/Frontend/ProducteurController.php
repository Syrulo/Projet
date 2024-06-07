<?php

namespace App\Controller\Frontend;

use App\Entity\Producteur;
use App\Repository\ProduitRepository;
use App\Repository\ProducteurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProducteurController extends AbstractController
{
    #[Route('/producteur/{slug}', name: 'app_producteur.details', methods: ['GET'])]
    public function detailsProducteur(Producteur $producteur, ProduitRepository $repoProduit): Response
    {
        $produits = $repoProduit->findByProducteur($producteur->getId());
        return $this->render('frontend/producteur/detailsProducteur.html.twig', [
            'producteur' => $producteur,
            'produits' => $produits
        ]);
    }

    #[Route('/producteur', name: 'app_producteur', methods: ['GET'])]
    public function listProducteur(ProducteurRepository $repoProducteur): Response
    {
        $producteurs = $repoProducteur->findAll();
        return $this->render('frontend/producteur/list.html.twig', [
            'producteurs' => $producteurs
        ]);
    }
}
