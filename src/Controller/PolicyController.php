<?php

namespace App\Controller;

use App\Entity\Argument;
use App\Entity\Language;
use App\Entity\Policy;
use App\Entity\PolicyTheme;
use App\Entity\Vote;
use App\Form\ArgumentType;
use App\Form\PolicyType;
use App\Form\VoteType;
use App\Repository\PolicyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolicyController extends AbstractController
{
    /**
     * @Route("/hum/policy", name="policy")
     */
    public function index(PolicyRepository $repository)
    {
        $policies = $repository->findAllParents();
        return $this->render('policy/index.html.twig', [
            'policies' => $policies,
        ]);
    }

    /**
     * @Route("/hum/policy/add", name="policy_add")
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
     * @Route("/hum/policy/{policy}/add-argument", name="policy_add_argument")
     */
    public function addArgument(Policy $policy, Request $request)
    {
        $argument = new Argument();
        $policy->setArgument($argument);
        $form = $this->createForm(ArgumentType::class, $argument);
        $form->add("submit", SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($argument);
            $entitymanager->persist($policy);
            $entitymanager->flush();
        }

        return $this->render('argument/new.html.twig', [
            "form" => $form->createView(),
            "policy" => $policy,
            "argument" => $argument
        ]);
    }

    /**
     * @Route("/hum/policy/by-theme/{theme}", name="policy_by_theme")
     */
    public function policiesByTheme(PolicyTheme $theme, Request $request)
    {
        $policies = $this->getDoctrine()->getRepository(Policy::class)
            ->findBy(["policyTheme" => $theme]);

        $response = new JsonResponse($policies);

        //return $response;
        return $this->render('policy/index.html.twig', [
            'policies' => $policies,
        ]);
    }

    /**
     * @Route("/hum/policy/{policy}/add", name="policy_add_child")
     */
    public function addChild(Policy $policy, Request $request)
    {
        $language = $this->getDoctrine()->getRepository(Language::class)
            ->findOneBy(["name" => "Svenska"]);

        $child = new Policy();
        $child->setParent($policy);
        $child->setVote($policy->getVote());
        $child->setLanguage($language);

        $argumentTranslation = false;
        $themeTranslation = false;

        if ($policy->getArgument()) {
            $argument = $policy->getArgument();
            if ($argument->getTranslations()) {
                foreach ($argument->getTranslations() as $translation) {
                    if ($translation->getLanguage() === $language) {
                        $argument = $translation;
                        $argumentTranslation = true;
                        break;
                    }
                }
            }
            $child->setArgument($argument);

        }
        if ($policy->getPolicyTheme()) {
            $theme = $policy->getPolicyTheme();
            if ($theme->getTranslations()) {
                foreach ($theme->getTranslations() as $translation) {
                    if ($translation->getLanguage() === $language) {
                        $theme = $translation;
                        $themeTranslation = true;
                        break;
                    }
                }
            }
            $child->setPolicyTheme($theme);
        }
        if ($policy->getSource()) {
            $child->setSource($policy->getSource());
        }

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

        return $this->render('policy/add-translation.html.twig', [
            'form' => $form->createView(),
            'policy' => $child,
            'argumentParent' => $policy->getArgument(),
            'argumentTranslation' => $argumentTranslation,
            'themeTranslation' => $themeTranslation
        ]);
    }

    /**
     * @Route("/hum/policy/{policy}/edit", name="policy_edit")
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
     * @Route("/hum/policy/{policy}/delete", name="policy_delete")
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
     * @Route("/hum/policy/{policy}/add-vote", name="policy_add_vote")
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
