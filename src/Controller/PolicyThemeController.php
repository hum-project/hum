<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\PolicyTheme;
use App\Form\PolicyThemeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PolicyThemeController extends AbstractController
{
    /**
     * @Route("/theme", name="theme")
     */
    public function index()
    {
        return $this->render('theme/index.html.twig', [
            'controller_name' => 'PolicyThemeController',
        ]);
    }

    /**
     * @Route("/theme/add", name="theme_add", methods={"GET", "POST"})
     */
    public function add(Request $request, SluggerInterface $slugger)
    {
        $theme = new PolicyTheme();

        $form = $this->createForm(PolicyThemeType::class, $theme);
        $form->handleRequest($request);

        $status = "get";
        $errors = array();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $status = "post";

            $image = new Image();
            $alt = $form->get('alt')->getData();

            $imageFile = $form->get('symbol')->getData();
            $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFileName = $slugger->slug($originalFileName);
            $newFileName = $safeFileName.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFileName
                );
            } catch (FileException $e) {
                $errors[] = $e;
            }

            $image->setFileName($newFileName);
            $image->setAlt($alt);
            $entityManager->persist($image);


            $theme->setSymbol($image);
            $entityManager->persist($theme);

            $entityManager->flush();

        }

        return $this->render('theme/new.html.twig', [
            'form' => $form->createView(),
            'status' => $status,
            'errors' => $errors
        ]);

    }
}
