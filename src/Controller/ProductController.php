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
     * @Route("/product_new", name="product_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product_list", name="product_list")
     * @param ProductRepository $product
     * @return Response
     */
    public function getAllProducts(ProductRepository $product): Response
    {
        $products = $product->findAll();
        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }
}
