<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(BlogPostRepository $blogPostRepository)
    {
        $blogPosts = $blogPostRepository->getPostsByLanguageName('English');
        $pages = $blogPostRepository->getPageCountByLanguageName('English');
        return $this->render('admin/index.html.twig', [
            'blogPosts' => $blogPosts,
            'currentPage' => 1,
            'pages' => $pages
        ]);
    }

    /**
     * @Route("/admin/posts/{page}", name="admin_posts_page")
     */
    public function getBlogPostsForPage($page)
    {
        if (is_numeric($page)) {
            $repository = $this->getDoctrine()->getManager()->getRepository("App\Entity\BlogPost");
            $results = $repository->getPostsByLanguageName('English', $page, 10);
            $pages = $repository->getPageCountByLanguageName('English');

            return $this->render('admin/index.html.twig', [
                'blogPosts' => $results,
                'pages' => $pages,
                'currentPage' => $page
            ]);
        } else {
            return new Response("Not valid: " . $page);
        }
    }
}
