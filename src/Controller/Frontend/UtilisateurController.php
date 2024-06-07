<?php

namespace App\Controller\Frontend;

use App\Form\AdminUtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profil')]
class UtilisateurController extends AbstractController
{
    public function __construct(
        private Security $security,
        private UtilisateurRepository $repo
    ) {
    }

    #[Route('', name: 'profil')]
    public function showProfil(): Response
    {
        $user = $this->security->getUser();

        return $this->render('frontend/utilisateur/profil.html.twig', [
            'utilisateur' => $user,
        ]);
    }

    #[Route('/edit', name: 'profil.edit', methods: ['GET', 'POST'])]
    public function editProfil(Request $request, EntityManagerInterface $em): Response 
    {

        $user = $this->security->getUser();

        $form = $this->createForm(AdminUtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('frontend/utilisateur/edit.html.twig', [
            'utilisateur' => $user,
            'form' => $form,
            'title_heading' => 'Editez votre profil'
        ]);
    }
}
