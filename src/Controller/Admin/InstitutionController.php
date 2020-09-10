<?php

namespace App\Controller\Admin;

use App\Entity\Hum;
use App\Entity\Institution;
use App\Form\InstitutionType;
use App\Repository\InstitutionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class InstitutionController extends AbstractController
{
    /**
     * @Route("/hum/institution", name="institution")
     */
    public function index(InstitutionRepository $repository)
    {
        $institutions = $repository->findAll();
        return $this->render('institution/index.html.twig', [
            'institutions' => $institutions
        ]);
    }
    
    /**
     * @Route("/hum/institution/add", name="institution_add")
     */
    public function add(Request $request)
    {
        $institution = new Institution();

        $form = $this->createForm(InstitutionType::class, $institution);
        $form->add("submit", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($institution);
            $entitymanager->flush();

            return $this->redirectToRoute('institution_edit', ['institution' => $institution->getId()]);
        }

        return $this->render('institution/new.html.twig', [
            'form' => $form->createView(),
            'institution' => $institution
        ]);
    }

    /**
     * @Route("/hum/institution/add-to-hum/{hum}", name="institution_hum_add")
     */
    public function addWithHum(Hum $hum, Request $request)
    {
        $institution = new Institution();
        $hum->setInstitution($institution);

        $form = $this->createForm(InstitutionType::class, $institution);
        $form->add("submit", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($hum);
            $entitymanager->persist($institution);
            $entitymanager->flush();

            return $this->redirectToRoute('institution_edit', ['institution' => $institution->getId()]);
        }

        return $this->render('institution/new.html.twig', [
            'form' => $form->createView(),
            'institution' => $institution
        ]);
    }

    /**
     * @Route("/hum/institution/{institution}/edit", name="institution_edit")
     */
    public function edit(Institution $institution, Request $request)
    {

        $form = $this->createForm(InstitutionType::class, $institution);
        $form->add("submit", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($institution);
            $entitymanager->flush();
        }

        return $this->render('institution/edit.html.twig', [
            'form' => $form->createView(),
            'institution' => $institution
        ]);
    }

    /**
     * @Route("/hum/institution/{institution}/add-translation", name="institution_add_translation")
     */
    public function addTranslation(institution $institution, Request $request)
    {
        $translation = new Institution();
        $translation->setTranslation($institution);
        $institution->addTranslation($translation);
        $parentTheme = $institution->getPolicyTheme();
        $translation->setPolicyTheme($parentTheme);
        $form = $this->createForm(InstitutionType::class, $translation);
        $form->add("submit", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $language = $translation->getLanguage();
            foreach ($institution->getPolicyTheme()->getTranslations() as $themeTranslation) {
                if ($themeTranslation->getLanguage() === $language) {
                    $translation->setPolicyTheme($themeTranslation);
                    break;
                }
            }
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($translation);
            $entitymanager->flush();

            return $this->redirectToRoute('institution_edit', ["institution" => $translation->getId()]);
        }

        return $this->render('institution/new.html.twig', [
            'form' => $form->createView(),
            'institution' => $translation
        ]);
    }

    /**
     * @Route("/hum/institution/{institution}/delete", name="institution_delete")
     */
    public function delete(Institution $institution, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $confirmation = $request->get("confirmation");
            if ($confirmation) {
                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->remove($institution);
                $entitymanager->flush();
                return $this->redirectToRoute('institution');
            }
        }

        return $this->render('institution/delete.html.twig', [
            'institution' => $institution
        ]);
    }
}
