<?php

namespace App\Controller;

use App\Entity\Policy;
use App\Entity\Vote;
use App\Form\PolicyType;
use App\Form\VoteType;
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
        $policies = $repository->findAllParents();
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
     * @Route("/policy/{policy}/add", name="policy_add_child")
     */
    public function addChild(Policy $policy, Request $request)
    {
        $child = new Policy();
        $child->setParent($policy);
        $child->setVote($policy->getVote());
        $policy->addPolicy($child);
        $form = $this->createForm(PolicyType::class, $child);
        $form->add("submit", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($child);
            $entitymanager->flush();

            return $this->redirectToRoute('policy_edit', ["policy" => $child->getId()]);
        }

        return $this->render('policy/new.html.twig', [
            'form' => $form->createView(),
            'policy' => $child
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

    /**
     * @Route("/policy/{policy}/delete", name="policy_delete")
     */
    public function delete(Policy $policy, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $confirmation = $request->get("confirmation");
            if ($confirmation) {
                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->remove($policy);
                $entitymanager->flush();
                return $this->redirectToRoute('policy');
            }
        }

        return $this->render('policy/delete.html.twig', [
            'policy' => $policy
        ]);
    }

    /**
     * @Route("policy/{policy}/add-vote", name="policy_add_vote")
     */
    public function addVoteToPolicy(Policy $policy, Request $request)
    {
        $vote = new Vote();
        $vote->addPolicy($policy);
        $policy->setVote($vote);

        $form = $this->createForm(VoteType::class, $vote);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $policy->getPolicies()) {
                foreach ($policy->getPolicies() as $child) {
                    $child->setVote($vote);
                }
            }
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($vote);
            $entitymanager->persist($policy);
            $entitymanager->flush();

            return $this->redirectToRoute('vote_edit', ['vote' => $vote->getId()]);
        }

        return $this->render('vote/new.html.twig', [
            'form' => $form->createView(),
            'vote' => $vote
        ]);

    }


}
