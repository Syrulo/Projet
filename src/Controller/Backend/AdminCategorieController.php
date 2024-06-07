<?php

namespace App\Controller\Backend;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminCategorieController extends AbstractController
{
    #[Route('/categorie/create', name: 'app_admin.categorie.create', methods: ['GET', 'POST'])]
    public function createCategorie(Request $request, EntityManagerInterface $manager): Response
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            $this->addFlash('success', 'La catégorie a bien été crée');
            return $this->redirectToRoute('app_admin.categorie');
        }

        return $this->render('backend/categorie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categorie/edit/{id}', name: 'app_admin.categorie.edit', methods: ['GET', 'POST'])]
    public function editCategorie( Categorie $categorie, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            $this->addFlash('success', 'La catégorie a bien été modifiée');
            return $this->redirectToRoute('app_admin.categorie');
        }

        return $this->render('backend/categorie/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categorie', name: 'app_admin.categorie', methods: ['GET'])]
    public function listCategorie(CategorieRepository $repoCategorie): Response
    {
        $categories = $repoCategorie->findAll();
        return $this->render('backend/categorie/list.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/categorie/delete/{id}', name: 'app_admin.categorie.delete', methods: ['GET', 'POST'])]
    public function deleteCategorie(Categorie $categorie, Request $request, EntityManagerInterface $manager): response
    {
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->get('_token'))) {
            $manager->remove($categorie);
            $manager->flush();
            
            $this->addFlash('success', 'La catégorie a bien été supprimée');
        
        return $this->redirectToRoute('app_admin');
        }

        $this->addFlash('error', 'La catégorie n\'est pas valide');

        return $this->redirectToRoute('app_admin.categorie');
    }
}
