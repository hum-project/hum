<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/image", name="image")
     */
    public function index()
    {
        return $this->render('image/index.html.twig', [
            'controller_name' => 'ImageController',
        ]);
    }

    /**
     * @Route("/image/add", name="image_add", methods={"GET", "POST"})
     */
    public function add(Request $request)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $imageFile = $form->get('image')->getData();

            $image->setFileAttributesWithImageFilePath($imageFile->getPathName());
            $image->setFiletype($imageFile->getMimeType());
            $entitymanager->persist($image);
            $entitymanager->flush();
            //*/

        }

        return $this->render('image/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
