<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\PolicyTheme;
use App\Form\PolicyThemeType;
use App\Repository\PolicyThemeRepository;
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
    public function index(PolicyThemeRepository $repository)
    {
        $themes = $repository->findAll();
        $filePath = $_SERVER['APP_ENV'] === 'dev' ? '/uploads/images' : $this->getParameter('images_view');

        return $this->render('theme/index.html.twig', [
            'themes' => $themes,
            'filePath' => $filePath
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

    /**
     * @Route("/theme/{id}/edit", name="theme_edit", methods={"GET", "POST"})
     */
    public function edit(PolicyTheme $theme, Request $request, SluggerInterface $slugger)
    {
        $form = $this->createForm(PolicyThemeType::class, $theme);
        $form->handleRequest($request);

        $filePath = $_SERVER['APP_ENV'] === 'dev' ? 'uploads/images' : $this->getParameter('images_view');
        $fileShowPath = $_SERVER['APP_ENV'] === 'dev' ? '/uploads/images' : $this->getParameter('images_view');

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();

            $imageFile = $form->get('symbol')->getData();

            $alt = $form->get('alt')->getData();

            // Check that a new image has been set.
            if ($imageFile) {

                // If it has been set. Store the new one
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

                $prevImage = $theme->getSymbol();
                if ($prevImage) {
                    // and delete the old one.
                    $deleteStatus = unlink($filePath . '/' . $prevImage->getFileName());
                    if ($deleteStatus) {
                        $prevImage->setFileName($newFileName);
                        $prevImage->setAlt($alt);
                    } else {
                        $messages[] = "Could not remove file " . $prevImage->getFileName();
                    }
                } else {
                    $image = new Image();
                    $image->setFileName($newFileName);
                    $image->setAlt($alt);
                    $entitymanager->persist($image);

                    $theme->setSymbol($image);
                }
            }

            $entitymanager->persist($theme);
            $entitymanager->flush();
        }

        return $this->render('theme/edit.html.twig', [
            'form' => $form->createView(),
            'theme' => $theme,
            'filePath' => $filePath,
            'fileShowPath' => $fileShowPath
        ]);
    }

    /**
     * @Route("theme/{language}", name="theme_language")
     */
    public function indexForLanguage($language, PolicyThemeRepository $repository)
    {
        $languageRepository = $this->getDoctrine()->getRepository("App\Entity\Language");
        $languageEntity = $languageRepository->findOneBy(["name" => $language]);
        if (!$languageEntity) {
            $languageEntity = $languageRepository->findOneBy(["name" => ucfirst($language)]);
        }

        $themes = $repository->findBy(["language" => $languageEntity]);
        $filePath = $_SERVER['APP_ENV'] === 'dev' ? '/uploads/images' : $this->getParameter('images_view');

        return $this->render('theme/index.html.twig', [
            'themes' => $themes,
            'filePath' => $filePath
        ]);
    }
}
