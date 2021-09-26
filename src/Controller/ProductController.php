<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @return Response
     */
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $product = new Product();
        /*$form = $this->createForm(ProductType::class, $product, [
            'action' => $this->generateUrl('product_map_new'),
            'method' => 'POST',
        ]);*/
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        $products = $productRepository->findAll();
//        $categories = $categoryRepository->findAllCategoryName();
        return $this->render('product/index.html.twig', [
            'products' => $products,
//            'categories' => $categories,
            'form' => $form->createView()
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
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product_edit/{id}", name="product_edit", requirements={"id":"\d+"})
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    public function edit(Product $product, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('product_list');
        }
        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product_delete/{id}", name="product_delete", methods={"DELETE"})
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    public function delete(Product $product, Request $request): Response
    {
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete-product', $submittedToken)) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }
        return $this->redirectToRoute('product_list');
    }

    /**
     * @Route("/product_map_new", name="product_map_new")
     */
    public function mapNewProduct(Request $request)
    {

        $content = $request->getContent();
        dd($request);
    }
}
