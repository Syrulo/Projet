<?php

namespace App\Controller\Backend;

use App\Entity\Producteur;
use App\Form\ProducteurType;
use App\Repository\ProducteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminProducteurController extends AbstractController
{
    #[Route('/producteur/create', name: 'app_admin.producteur.create', methods: ['GET', 'POST'])]
    public function createProducteur(Request $request, EntityManagerInterface $manager): Response
    {
        $producteur = new Producteur();

        $form = $this->createForm(ProducteurType::class, $producteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($producteur);
            $manager->flush();
            $this->addFlash('success', 'Le producteur a bien été ajouté');
            return $this->redirectToRoute('app_admin.producteur');
        }

        return $this->render('backend/producteur/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/producteur/edit/{id}', name: 'app_admin.producteur.edit', methods: ['GET', 'POST'])]
    public function editProducteur( Producteur $producteur, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProducteurType::class, $producteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($producteur);
            $manager->flush();
            $this->addFlash('success', 'Le producteur a bien été modifié');
            return $this->redirectToRoute('app_admin.producteur');
        }

        return $this->render('backend/producteur/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/producteur', name: 'app_admin.producteur', methods: ['GET'])]
    public function listProducteur(ProducteurRepository $repoProducteur): Response
    {
        $producteurs = $repoProducteur->findAll();
        return $this->render('backend/producteur/list.html.twig', [
            'producteurs' => $producteurs
        ]);
    }

    #[Route('/producteur/delete/{id}', name: 'app_admin.producteur.delete', methods: ['GET', 'POST'])]
    public function deleteProducteur(Producteur $producteur, Request $request, EntityManagerInterface $manager): response
    {
        if ($this->isCsrfTokenValid('delete' . $producteur->getId(), $request->get('_token'))) {
            $manager->remove($producteur);
            $manager->flush();
            
            $this->addFlash('success', 'Le producteur a bien été supprimé de la liste');
        
        return $this->redirectToRoute('app_admin.producteur');
        }

        $this->addFlash('error', 'Le producteur n\'est pas valide');

        return $this->redirectToRoute('app_admin.producteur');
    }
}
