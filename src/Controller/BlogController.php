<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\BlogPostType;
use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function addPost(BlogPostRepository $repository)
    {

        return $this->render('blog/new.html.twig', [
            'form' => $this->createForm(BlogPostType::class, new BlogPost())->createView()
        ]);
    }
}
