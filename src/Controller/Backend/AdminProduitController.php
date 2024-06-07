<?php

namespace App\Controller\Backend;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminProduitController extends AbstractController
{
    #[Route('/produit/create', name: 'app_admin.produit.create', methods: ['GET', 'POST'])]
    public function createProduit(Request $request, EntityManagerInterface $manager): response
    {
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été crée');
            return $this->redirectToRoute('app_admin.produit');
        }

        return $this->render('backend/produit/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/produit/edit/{id}', name: 'app_admin.produit.edit', methods: ['GET', 'POST'])]
    public function editProduit(Produit $produit, Request $request, EntityManagerInterface $manager): response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setUpdatedAt(new \DateTime());
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirectToRoute('app_admin.produit');
        }

        return $this->render('backend/produit/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/produit', name: 'app_admin.produit', methods: ['GET', 'POST'])]
    public function listProduit(ProduitRepository $repoProduit, Request $request): Response
    {
        $keyword = $request->get('search');
        $produits = $repoProduit->findAll();
        if($keyword){
            $searchType = $request->get('search_type');
            $produits = $repoProduit->search($keyword, $searchType);
            if($produits == null){
                $this->addFlash('error', 'Aucun produit correspondant');
                return $this->redirectToRoute('app_admin.produit');
            }
        }
        return $this->render('backend/produit/list.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/produit/delete/{id}', name: 'app_admin.produit.delete', methods: ['GET', 'POST'])]
    public function deleteProduit(Produit $produit, Request $request, EntityManagerInterface $manager): response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->get('_token'))) {
            $manager->remove($produit);
            $manager->flush();
            
            $this->addFlash('success', 'Le produit a bien été supprimé');
        
        return $this->redirectToRoute('app_admin');
        }

        $this->addFlash('error', 'Le produit n\'est pas valide');

        return $this->redirectToRoute('app_admin.produit');
    }
}