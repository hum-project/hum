<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Language;
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
        $language = $this->getDoctrine()->getRepository(Language::class)
            ->findOneBy(["name" => "English"]);
        if ($language) {
            $theme->setLanguage($language);
        }

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
            if ($imageFile) {
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
            }

            $entityManager->persist($theme);
            $entityManager->flush();

            $this->redirectToRoute('theme_edit', ['theme' => $theme->getId()]);

        }

        return $this->render('theme/new.html.twig', [
            'form' => $form->createView(),
            'theme' => $theme,
            'status' => $status,
            'errors' => $errors
        ]);

    }

    /**
     * @Route("/theme/{theme}/add-translation", name="theme_add_translation")
     */
    public function addTranslation(PolicyTheme $theme, Request $request, SluggerInterface $slugger)
    {
        $translation = new PolicyTheme();
        $translation->setTranslation($theme);
        $language = $this->getDoctrine()->getRepository(Language::class)
            ->findOneBy(["name" => "Svenska"]);
        if ($language) {
            $translation->setLanguage($language);
        }

        $image = new Image();
        $image->setFileName($theme->getSymbol()->getFileName());
        $image->setAlt($theme->getSymbol()->getAlt());
        $translation->setSymbol($image);

        $form = $this->createForm(PolicyThemeType::class, $translation);
        $form->handleRequest($request);

        $status = "get";
        $errors = array();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $status = "post";

            $alt = $form->get('alt')->getData();

            $imageFile = $form->get('symbol')->getData();
            if ($imageFile) {
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
            }

            $image->setAlt($alt);
            $entityManager->persist($image);
            $entityManager->persist($translation);

            $entityManager->flush();
        }

        return $this->render('theme/new.html.twig', [
            'form' => $form->createView(),
            'theme' => $translation,
            'status' => $status,
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/theme/{theme}/edit", name="theme_edit", methods={"GET", "POST"})
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

    /**
     * @Route("/theme/{theme}/delete", name="theme_delete")
     */
    public function delete(PolicyTheme $theme, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $confirmation = $request->get("confirmation");
            $deleteTranslations = $request->get("translations");
            if ($confirmation) {
                $entitymanager = $this->getDoctrine()->getManager();

                if ($deleteTranslations) {
                    foreach ($theme->getTranslations() as $translation) {
                        $entitymanager->remove($translation);
                    }
                }
                $entitymanager->remove($theme);
                $entitymanager->flush();
                return $this->redirectToRoute('policy');
            }
        }

        return $this->render('theme/delete.html.twig', [
            'theme' => $theme
        ]);
    }
}
