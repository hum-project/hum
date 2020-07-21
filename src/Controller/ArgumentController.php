<?php

namespace App\Controller;

use App\Entity\Argument;
use App\Form\ArgumentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArgumentController extends AbstractController
{
    /**
     * @Route("/argument", name="argument")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Argument::class);
        $arguments = $repository->findBy(["parent" => null]);
        return $this->render('argument/index.html.twig', [
            'arguments' => $arguments,
        ]);
    }

    /**
     * @Route("/argument/add", name="argument_add")
     */
    public function add(Request $request)
    {
        $argument = new Argument();
        $form = $this->createForm(ArgumentType::class, $argument);
        $form->add("submit", SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($argument);
            $entitymanager->flush();
        }

        return $this->render('argument/new.html.twig', [
            "form" => $form->createView(),
            "argument" => $argument
        ]);
    }

    /**
     * @Route("/argument/{argument}/add", name="argument_add_child")
     */
    public function addChild(Argument $argument, Request $request)
    {
        $child = new Argument();
        $argument->setChild($child);
        $child->setLanguage($argument->getLanguage());

        $form = $this->createForm(ArgumentType::class, $child);
        $form->add("submit", SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($argument);
            $entitymanager->flush();
        }
        return $this->render('argument/new.html.twig', [
            "form" => $form->createView(),
            "argument" => $child
        ]);
    }

    /**
     * @Route("/argument/{argument}/edit", name="argument_edit")
     */
    public function edit(Argument $argument, Request $request)
    {
        $form = $this->createForm(ArgumentType::class, $argument);
        $form->add("submit", SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($argument);
            $entitymanager->flush();
        }

        return $this->render('argument/edit.html.twig', [
            "form" => $form->createView(),
            "argument" => $argument
        ]);
    }

    /**
     * @Route("/argument/{argument}/delete", name="argument_delete")
     */
    public function delete(Argument $argument, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $entitymanager = $this->getDoctrine()->getManager();

            $deleteAll = $request->get("delete-all");
            $confirmation = $request->get("confirmation");
            if($confirmation && $deleteAll) {
                $arguments = $argument->getDescendants();
                foreach ($arguments as $descendant) {
                    $entitymanager->remove($descendant);
                }
                if ($argument->getParent()) {
                    $argument->getParent()->setChild(null);
                }
                $entitymanager->remove($argument);
                $entitymanager->flush();
                return $this->redirectToRoute('argument');
            }

            if ($confirmation) {
                if ($argument->getParent()) {
                    if ($argument->getChild()) {
                        $argument->getParent()->setChild($argument->getChild());
                    } else {
                        $argument->setChild(null);
                    }
                } elseif ($argument->getChild()) {
                    $argument->getChild()->setParent(null);
                }

                $entitymanager->remove($argument);
                $entitymanager->flush();

                return $this->redirectToRoute('argument');

            }
        }

        return $this->render('argument/delete.html.twig', [
            "argument" => $argument
        ]);
    }
}
