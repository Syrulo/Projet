<?php

namespace App\Controller;

use App\Entity\Producer;
use App\Repository\ProducerRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProducerController extends AbstractController
{
    #[Route('/producer', name: 'app_producer')]
    public function index(ProducerRepository $producerRepository): Response
    {
        $producers = $producerRepository->findAll();
        return $this->render('frontend/producteur/list.html.twig', [
            'producers' => $producers
        ]);
    }
    #[Route('/producer/{id}', name: 'app_producer_show')]
    public function show(Producer $producer): Response
    {
        return $this->render('producerDashboard.html.twig', [
            'producer' => $producer,
            'visitor' => $this->getUser(),
        ]);
    }

    #[Route('/producer/{slug}/details', name: 'app_producer.details', methods: ['GET'])]
    public function detailsProducteur(Producer $producer, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findByProducer($producer->getId());
        return $this->render('frontend/producteur/detailsProducteur.html.twig', [
            'producer' => $producer,
            'products' => $products
        ]);
    }
    #[Route('/producer/validate/{id}', name: 'app_validate_producer')]
    public function validate(Producer $producer, EntityManagerInterface $em): Response
    {
        $producer->setStatus("confirmed");
        $em->flush();
        return $this->redirectToRoute('app_admin.producer');
    }
}
