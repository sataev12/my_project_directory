<?php

namespace App\Controller;

use App\Entity\Tuto;
use App\Repository\TutoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TutoController extends AbstractController
{
    #[Route('/tuto/{id}', name: 'app_tuto')]
    public function index(TutoRepository $productRepository, int $id): Response
    {
        // $product = $entityManager->getRepository(Tuto::class)->find($id);
        $product = $productRepository->findOneById($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'name' => $product->getName(),
        ]);
    }

    #[Route('/add-tuto', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        $product = new Tuto();
        $product->setName('Unity');
        $product->setSlug('tuto-unity');
        $product->setSubtitle('Lorem ipsum dolor sit amet.');
        $product->setDescription('Lorem ipsum dolor sit amet.');
        $product->setImage('newsFillm.jpeg');
        $product->setVideo('qTfjtDnV4Hc');
        $product->setLink('https://grafikart.fr/');
        
        

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
