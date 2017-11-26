<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Product;
use ShopBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ProductController extends Controller
{
    /**
    * @Route("/create/product", name="create_product")
    */
    public function create()
    {
        $categories = $this->getDoctrine()->getRepository('ShopBundle:Category')->findAll();

        return $this->render('/product/create.html.twig', compact('categories'));
    }

    /**
    * @Route("/product/create", name="product_create")
    */
    public function storeAction(Request $request)
    {
        $this->validate($request);

        $this->addFlash(
            'notice',
            'product added!'
        );
        return $this->redirectToRoute('home');
    }


    private function validate(Request $request)
    {
        $id = $request->get('category');
        $category = $this->getDoctrine()->getRepository('ShopBundle:Category')->find($id);

        $file = $request->files->get('image');
        $fileName = md5(uniqid()).'.'.$file->getClientOriginalExtension();
        $file->move($this->getParameter('images_directory'), $fileName);

        $title = $request->get('title');
        $description = $request->get('description');
        $price = $request->get('price');
        $slug = $request->get('slug');

        $product = new Product;
        $this->createProduct($product, $fileName, $category, $title, $description, $price, $slug);
    }

    private function createProduct($product, $fileName, $category, $title, $description, $price, $slug)
    {
        $product->setImage($fileName);
        $product->setTitle($title);
        $product->setCategory($category);
        $product->setDescription($description);
        $product->setSlug($slug);
        $product->setPrice($price);

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
    }
}