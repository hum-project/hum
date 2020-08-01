<?php

namespace App\Controller;

use App\Entity\Hum;
use App\Form\HumType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HumController extends AbstractController
{
    /**
     * @Route("/hum", name="hum")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Hum::class);
        $hums = $repository->findAll();
        return $this->render('hum/index.html.twig', [
            'hums' => $hums,
        ]);
    }

    /**
     * @Route("/hum/add", name="hum_add")
     */
    public function add(Request $request)
    {
        $hum = new Hum();
        $form = $this->createForm(HumType::class, $hum);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($hum);
            $manager->flush();
            $this->redirectToRoute('hum_edit', ['hum' => $hum->getId()]);
        }

        return $this->render('hum/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/hum/{hum}/edit", name="hum_edit")
     */
    public function edit(Hum $hum, Request $request)
    {
        $form = $this->createForm(HumType::class, $hum);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($hum);
            $manager->flush();
        }

        return $this->render('hum/edit.html.twig', [
            'form' => $form->createView(),
            'hum' => $hum
        ]);
    }
}
