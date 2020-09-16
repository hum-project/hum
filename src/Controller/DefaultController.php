<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="start", methods={"GET"})
     */
    public function index(BlogPostRepository $blogPostRepository)
    {
        $blogPosts = $blogPostRepository->getPostsByLanguageName('English');
        $pages = $blogPostRepository->getPageCountByLanguageName('English');
        return $this->render('default/index.html.twig', [
            'blogPosts' => $blogPosts,
            'currentPage' => 1,
            'pages' => $pages
        ]);
    }

    /**
     * @Route("/", name="submit_start", methods={"POST"})
     */
    public function submit(BlogPostRepository $blogPostRepository, Request $request)
    {
        dump($request);
        $blogPosts = $blogPostRepository->getPostsByLanguageName('English');
        $pages = $blogPostRepository->getPageCountByLanguageName('English');
        return $this->render('default/index.html.twig', [
            'blogPosts' => $blogPosts,
            'currentPage' => 1,
            'pages' => $pages
        ]);
    }
}
