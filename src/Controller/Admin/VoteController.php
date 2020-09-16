<?php

namespace App\Controller\Admin;

use App\Entity\Policy;
use App\Entity\Vote;
use App\Form\VoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class VoteController extends AbstractController
{
    /**
     * @Route("/hum/vote", name="vote")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Vote::class);
        $votes = $repository->findAll();
        return $this->render('vote/index.html.twig', [
            'votes' => $votes,
        ]);
    }


    /**
     * @Route("/hum/vote/add/{policy}", name="vote_add_policy")
     */
    public function addWithPolicy(Policy $policy, Request $request)
    {
        $vote = new Vote();
        $vote->addPolicy($policy);

        $form = $this->createForm(VoteType::class, $vote);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($vote);
            $entitymanager->flush();

            return $this->redirectToRoute('vote_edit', ['vote' => $vote->getId()]);
        }

        return $this->render('vote/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/hum/vote/{vote}/edit", name="vote_edit")
     */
    public function edit(Vote $vote, Request $request)
    {

        $form = $this->createForm(VoteType::class, $vote);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($vote);
            $entitymanager->flush();
        }

        return $this->render('vote/edit.html.twig', [
            'form' => $form->createView(),
            'vote' => $vote
        ]);
    }

    /**
     * @Route("/hum/vote/{vote}/delete", name="vote_delete")
     */
    public function delete(Vote $vote, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $confirmation = $request->get("confirmation");
            if ($confirmation) {
                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->remove($vote);
                $entitymanager->flush();
                return $this->redirectToRoute('vote');
            }
        }

        return $this->render('vote/delete.html.twig', [
            'vote' => $vote
        ]);
    }
}
