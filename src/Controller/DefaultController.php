<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="start")
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
}
