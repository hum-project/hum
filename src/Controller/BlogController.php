<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\BlogPostType;
use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     */
    public function index(BlogPostRepository $repository)
    {
        $news = $repository->findAll();
        return $this->render('blog/index.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/news/add", name="news_add", methods={"GET", "POST"})
     */
    public function addPost(Request $request, BlogPostRepository $repository)
    {
        $blogPost = new BlogPost();
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($blogPost);
            $entitymanager->flush();
        }
        return $this->render('blog/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
