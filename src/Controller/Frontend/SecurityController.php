<?php

namespace App\Controller\Frontend;

use App\Entity\Utilisateur;
use App\Entity\UtilisateurDetails;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * This controller allow us to login
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/connexion', name: 'app_security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
        return $this->redirectToRoute('app_home_page');
    }

    /**
     * This controller allow us to logout
     *
     * @return void
     */
    #[Route('/deconnexion', 'app_security.logout')]
    public function logout()
    {
        // controller can be blank: it will never be called!
    }

    /**
     * This controller allows us to register
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/inscription', 'app_security.inscription', methods: ['GET', 'POST'])]
    public function inscription(Request $request, EntityManagerInterface $manager) : Response
    {

        $utilisateur = new Utilisateur();
        $utilisateurDetails = new UtilisateurDetails();
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $form->getData();            
            $utilisateur->setActive(true);
            $utilisateur->setRoles(['ROLE_USER']);
            $this->addFlash(
                'success',
                'Votre compte a bien été crée.'
            );

            $manager->persist($utilisateur);
            $manager->flush();
            $lastId = $utilisateur->getId();
            $utilisateurDetails->setUtilisateur($utilisateur);
            $manager->persist($utilisateurDetails);
            $manager->flush();



            return $this->redirectToRoute('app_security.login');
        }    
        
        return $this->render('security/inscription.html.twig', [
            'form' => $form
        ]);
    }
}
