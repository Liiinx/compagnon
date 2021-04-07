<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProductRepository $product
     * @return Response
     */
    public function index(ProductRepository $product): Response
    {
        $products = $product->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/new_product", name="new_product")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {

        $product = new Product();

        /*$product->setTitle('test');
        $product->setDescription('tes skjhqe oiwd oidfh');
        $product->setPrice(10);*/

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            var_dump($product);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('home');

        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
