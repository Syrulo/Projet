<?php

namespace App\Controller\Frontend;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/details/{slug}', name: 'app_produit')]
    public function show(Produit $produit): Response
    {
        return $this->render('frontend/produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }
}
