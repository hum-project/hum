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

        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();

            // make sure no empty blog image is being added

            foreach ($form->get('blogImages') as $blogImage) {
                $blogImageEntity = new BlogImage();

                $imageFile = $blogImage->get('image')->getData();
                dump($imageFile);
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
                $entitymanager->persist($image);

                if (!empty($subtext)) {
                    $blogImageEntity->setSubtext($subtext);
                }

                $blogImageEntity->setImage($image);
                $blogImageEntity->setBlogPost($blogPost);
                $entitymanager->persist($blogImageEntity);

                $blogPost->addBlogImage($blogImageEntity);

            }

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
     * @Route("/news/{slug}", name="news_show")
     */
    public function show(BlogPost $blogPost)
    {
        $text = $blogPost->getText();
        $filePath = $_SERVER['APP_ENV'] === 'dev' ? '/images' : $this->getParameter('images_view');
        $blogImages = $blogPost->getBlogImages();
        $imageIndex = 0;
        foreach ($blogImages as $blogImage) {
            $found = false;
            for ($i = 0; $i < 25; $i++) {
                $pattern = '/\|' . $imageIndex . '\|/';
                if (strpos($text, '|' . $imageIndex . '|')) {
                    $found = true;
                    $replace = '<div class="img-container"> <img src="' . $filePath . '/'
                        . $blogImage->getImage()->getFileName()
                        . '" alt="' . $blogImage->getImage()->getAlt() . '" /><p>'. $blogImage->getSubtext() .'</p></div>';
                    $text = preg_replace($pattern, $replace, $text);
                }
                $imageIndex++;
                if ($found) {
                    break;
                }
            }
        }

        dump($blogPost);
        return $this->render('blog/show.html.twig   ', [
            "title" => $blogPost->getTitle(),
            "publish_date" => $blogPost->getPublishTime(),
            "text" => $text
        ]);

    }

    /**
     * @Route("/news/{slug}/edit", name="news_edit", methods={"GET", "POST"})
     */
    public function editPost(BlogPost $blogPost, Request $request, SluggerInterface $slugger)
    {
        $messages = [];

        $blogImages = $blogPost->getBlogImages();
        foreach ($blogImages as $blogImage) {
            $image = $blogImage->getImage();
            $alt = $image->getAlt();
        }

        $form = $this->createForm(BlogPostType::class, $blogPost);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            // make sure no empty blog image is being added

            $blogInputs = $request->request->get("blog_post");
            $hasBlogImages = array_key_exists("blogImages", $blogInputs);
            if ($hasBlogImages) {
                $blogInputs = $blogInputs["blogImages"];
            }
            dump($blogInputs, $request);
            $currentBlogImages = $form->get('blogImages');
            $prevBlogImages = $blogPost->getBlogImages();

            $filePath = $_SERVER['APP_ENV'] === 'dev' ? 'images' : $this->getParameter('images_view');

            // Update or remove images
            foreach ($prevBlogImages as $prevBlogImage) {
                $remove = true;
                foreach ($blogInputs as $currentBlogImage) {
                    if ($hasBlogImages && $prevBlogImage->getImage()->getFileName() === $currentBlogImage['image']) {
                        $remove = false;

                        // check if something needs updating
                        $alt = $currentBlogImage['alt'];
                        $subtext = $currentBlogImage['subtext'];

                        $prevBlogImage->getImage()->setAlt($alt);
                        $prevBlogImage->setSubtext($subtext);
                        $entitymanager->persist($prevBlogImage);
                        break;
                    }
                }

                if ($remove) {
                    $deleteStatus = unlink($filePath . '/' . $prevBlogImage->getImage()->getFileName());
                    if ($deleteStatus) {
                        $blogPost->removeBlogImage($prevBlogImage);
                        $entitymanager->remove($prevBlogImage->getImage());
                        $entitymanager->remove($prevBlogImage);
                    } else {
                        $messages[] = "Could not remove file " . $prevBlogImage->getImage()->getFileName();
                    }
                }
            }

            // insert new images
            foreach ($currentBlogImages as $currentBlogImage) {
                $isNew = true;
                $currentFile = $currentBlogImage->get('image')->getData();

                foreach ($prevBlogImages as $prevBlogImage) {
                    if ($currentFile === $prevBlogImage->getImage()->getFileName()) {
                        $isNew = false;
                        break;
                    }
                }

                if ($isNew && !empty($currentFile)) {
                    $blogImageEntity = new BlogImage();
                    $alt = $currentBlogImage->get('alt')->getData();
                    $subtext = $currentBlogImage->get('subtext')->getData();

                    $originalFilename = pathinfo($currentFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$currentFile->guessExtension();

                    try {
                        $currentFile->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                        $errors[] = $e;
                    }

                    $image = new Image();
                    $image->setFileName($newFilename);
                    $image->setAlt($alt);
                    $entitymanager->persist($image);

                    if (!empty($subtext)) {
                        $blogImageEntity->setSubtext($subtext);
                    }

                    $blogImageEntity->setImage($image);
                    $blogImageEntity->setBlogPost($blogPost);
                    $entitymanager->persist($blogImageEntity);

                    $blogPost->addBlogImage($blogImageEntity);
                }
            }

            $entitymanager->flush();
        }


        return $this->render('blog/edit.html.twig', [
            "form" => $form->createView(),
            "blogPost" => $blogPost,
            "messages" => $messages
        ]);
    }
}
