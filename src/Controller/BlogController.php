<?php

namespace App\Controller;

use App\Entity\BlogImage;
use App\Entity\BlogPost;
use App\Entity\Image;
use App\Form\BlogImageType;
use App\Form\BlogPostType;
use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function addPost(Request $request, BlogPostRepository $repository, SluggerInterface $slugger)
    {
        $blogPost = new BlogPost();
        /*
        $blogImage = new BlogImage();
        $blogPost->addBlogImage($blogImage);
        // */

        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();

            // make sure no empty blog image is being added

            foreach ($form->get('blogImages') as $blogImage) {
                $blogImageEntity = new BlogImage();

                $imageFile = $blogImage->get('image')->getData();
                $alt = $blogImage->get('alt')->getData();
                $subtext = $blogImage->get('subtext')->getData();

                $image = new Image();
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                // Move the file to the directory where images are stored


                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    $errors[] = $e;
                }

                $image->setFileName($newFilename);
                $image->setAlt($alt);

                if (!empty($subtext)) {
                    $blogImageEntity->setSubtext($subtext);
                }

                $blogImageEntity->setImage($image);
                $blogImageEntity->setBlogPost($blogPost);
                $blogPost->addBlogImage($blogImageEntity);

            }

            $blogPost->setEntered(new \DateTime('now'));
            $blogPost->updateSlug();
            dump($blogPost);
            /*
            $entitymanager->persist($blogPost);
            $entitymanager->flush();
            // */
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
