<?php

namespace App\Controller;

use App\Entity\BlogImage;
use App\Entity\BlogPost;
use App\Entity\Image;
use App\Form\BlogImageType;
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
            $blogPost->setEntered(new \DateTime('now'));
            $blogPost->updateSlug();
            $entitymanager->persist($blogPost);
            $entitymanager->flush();
        }
        return $this->render('blog/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/news/image/add"), name="news_image_add"), methods={"GET", "POST"})
     */
    public function addImage(Request $request)
    {
        $blogImage = new BlogImage();
        $form = $this->createForm(BlogImageType::class, $blogImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();

            $imageFile = $form->get('image')->getData();
            $alt = $form->get('alt')->getData();
            dump($imageFile);
            $image = new Image();
            $image->setFileAttributesWithImageFilePath($imageFile->getPathName());
            $image->setFiletype($imageFile->getMimeType());
            $image->setAlt($alt);
            $entitymanager->persist($image);
            $blogImage->setImage($image);

            $entitymanager->persist($blogImage);
            $entitymanager->flush();
        }

        return $this->render('blog/new_image.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
