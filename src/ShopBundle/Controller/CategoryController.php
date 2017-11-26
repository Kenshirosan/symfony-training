<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class CategoryController extends Controller
{
    /**
    * @Route("/category/create")
    */
    public function create(Request $request)
    {
        if(!$request->get('title') || !$request->get('description') || !$request->get('slug') ){
            $message = $this->addFlash(
                'error',
                'Form invalide!'
            );
            return $this->redirectToRoute('home', array('message' => $message));
        }

        $category = new Category;
        $title = $request->get('title');
        $description = $request->get('description');
        $slug = $request->get('slug');

        $category->setTitle($title);
        $category->setDescription($description);
        $category->setSlug($slug);

        $em = $this->getDoctrine()->getManager();

        $em->persist($category);
        $em->flush();
        $this->addFlash(
                'notice',
                'Category added!'
            );

        return $this->redirectToRoute('home');
    }
}