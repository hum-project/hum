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

    /**
     * @Route("/posts/{page}", name="posts_page")
     */
    public function getBlogPostsForPage($page)
    {
        if (is_numeric($page)) {
            $repository = $this->getDoctrine()->getManager()->getRepository("App\Entity\BlogPost");
            $results = $repository->getPostsByLanguageName('English', $page, 10);
            $pages = $repository->getPageCountByLanguageName('English');

            return $this->render('default/index.html.twig', [
                'blogPosts' => $results,
                'pages' => $pages,
                'currentPage' => $page
            ]);
        } else {
            return new Response("Not valid: " . $page);
        }
    }
}
