<?php

namespace App\Controller;

use App\Entity\Argument;
use App\Form\ArgumentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class ArgumentController extends AbstractController
{
    /**
     * @Route("/hum/argument", name="argument")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Argument::class);
        $arguments = $repository->findAll();
        return $this->render('argument/index.html.twig', [
            'arguments' => $arguments,
        ]);
    }

    /**
     * @Route("/hum/argument/add", name="argument_add")
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
     * @Route("/hum/argument/{argument}/add", name="argument_add_child")
     */
    public function addChild(Argument $argument, Request $request)
    {
        $child = new Argument();
        $prevChild = $argument->getChild();
        if ($prevChild) {
            $prevChild->setParent($child);
        }
        $child->setChild($prevChild);

        $argument->setChild($child);
        $child->setParent($argument);
        $child->setLanguage($argument->getLanguage());

        $form = $this->createForm(ArgumentType::class, $child);
        $form->add("submit", SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();


            if ($prevChild) {
                $child->setParent(null);
                $entitymanager->persist($child);
                $entitymanager->persist($prevChild);
                $entitymanager->flush();
            }

            $child->setParent($argument);
            $entitymanager->persist($child);
            $entitymanager->flush();

            $entitymanager->persist($argument);
            $entitymanager->flush();



        }
        return $this->render('argument/new.html.twig', [
            "form" => $form->createView(),
            "argument" => $child
        ]);
    }

    /**
     * @Route("/hum/argument/{argument}/add-translation", name="argument_add_translation")
     */
    public function addTranslation(Argument $argument, Request $request)
    {
        $child = new Argument();
        $child->setTranslation($argument);

        $argument->addTranslation($child);

        $form = $this->createForm(ArgumentType::class, $child);
        $form->add("submit", SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();

            $entitymanager->persist($child);
            $entitymanager->flush();

        }
        return $this->render('argument/new.html.twig', [
            "form" => $form->createView(),
            "argument" => $child
        ]);
    }

    /**
     * @Route("/hum/argument/{argument}/edit", name="argument_edit")
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
     * @Route("/hum/argument/{argument}/delete", name="argument_delete")
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
                    $descendant->setParent(null);
                    $entitymanager->persist($descendant);
                    $entitymanager->flush();
                    $entitymanager->remove($descendant);
                    $entitymanager->flush();

                }
                if ($argument->getParent()) {
                    $argument->getParent()->setChild(null);
                }
                $entitymanager->remove($argument);
                $entitymanager->flush();
                return $this->redirectToRoute('argument');
            }

            if ($confirmation) {

                $parent = $argument->getParent();
                $child = $argument->getChild();
                $argument->setChild(null);
                $argument->setParent(null);
                $entitymanager->persist($argument);
                $entitymanager->flush();


                if ($parent) {
                    if ($child) {
                        $parent->setChild($child);
                        $child->setParent($parent);
                        $entitymanager->persist($child);
                    } else {
                        $parent->setChild(null);
                    }
                    $entitymanager->persist($parent);

                } elseif ($child) {
                    $child->setParent(null);
                    $entitymanager->persist($child);
                }
                $entitymanager->flush();

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
