<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
    	$products = $this->getDoctrine()->getRepository('ShopBundle:Product')->findAll();
        $categories = $this->getDoctrine()->getRepository('ShopBundle:Category')->findAll();

        return $this->render('ShopBundle:Default:index.html.twig', compact('products', 'categories'));
    }

    /**
     * @Route("/produits/{id}", name="show_product")
     */
    public function showAction($id) {
    	$produit = $this->getDoctrine()->getRepository('ShopBundle:Product')->find($id);

    	return $this->render('ShopBundle:Default:show.html.twig', compact('produit'));
    }

    /**
     * @Route("/produits", name="add-product")
     */
    public function store(Product $product)
    {
        var_dump($request);
    }
}
