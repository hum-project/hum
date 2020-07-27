<?php

namespace App\Controller;

use App\Entity\Policy;
use App\Form\PolicyType;
use App\Repository\PolicyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PolicyController extends AbstractController
{
    /**
     * @Route("/policy", name="policy")
     */
    public function index(PolicyRepository $repository)
    {
        $policies = $repository->findAll();
        return $this->render('policy/index.html.twig', [
            'policies' => $policies,
        ]);
    }

    /**
     * @Route("/policy/add", name="policy_add")
     */
    public function add(Request $request)
    {
        $policy = new Policy();
        $form = $this->createForm(PolicyType::class, $policy);
        $form->add("submit", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($policy);
            $entitymanager->flush();

            return $this->redirectToRoute('policy_edit', ["policy" => $policy->getId()]);
        }

        return $this->render('policy/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/policy/{policy}/edit", name="policy_edit")
     */
    public function edit(Policy $policy, Request $request)
    {
        $form = $this->createForm(PolicyType::class, $policy);
        $form->add("submit", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($policy);
            $entitymanager->flush();
        }

        return $this->render('policy/edit.html.twig', [
            'form' => $form->createView(),
            'policy' => $policy
        ]);
    }
}
