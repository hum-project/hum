<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(BlogPostRepository $blogPostRepository)
    {
        $blogPosts = $blogPostRepository->findAllByEnglish();
        return $this->render('admin/index.html.twig', [
            'blogPosts' => $blogPosts
        ]);
    }
}
