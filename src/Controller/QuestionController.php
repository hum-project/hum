<?php

namespace App\Controller;

use App\Entity\ContinuousAnswer;
use App\Entity\Hum;
use App\Entity\Language;
use App\Entity\NominalAnswer;
use App\Entity\OrdinalAnswer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/hum/question", name="question")
     */
    public function index()
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    /**
     * @Route("/hum/question/{question}/add-translation", name="question_add_translation")
     */
    public function addTranslation(Question $question, Request $request)
    {
        $original = $question;
        $language = $this->getDoctrine()->getRepository(Language::class)
            ->findOneBy(["name" => "Svenska"]);
        $question = new Question();
        $question->setLanguage($language);
        $question->setTranslation($original);
        $question->setHum($original->getHum());
        $form = $this->createForm(QuestionType::class, $question);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($question);
            $entitymanager->flush();

            return $this->redirectToRoute('question_edit', ["question" => $question->getId()]);
        }

        return $this->render('question/add-translation.html.twig', [
            'form' => $form->createView(),
            'original' => $original
        ]);
    }

    /**
     * @Route("/hum/question/{hum}/add", name="question_add_hum")
     */
    public function addToHum(Hum $hum, Request $request)
    {
        $language = $this->getDoctrine()->getRepository(Language::class)
            ->findOneBy(["name" => "English"]);
        $question = new Question();
        $question->setHum($hum);
        $question->setLanguage($language);
        $form = $this->createForm(QuestionType::class, $question);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($question);
            $entitymanager->flush();

            return $this->redirectToRoute('question_edit', ["question" => $question->getId()]);
        }

        return $this->render('question/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/hum/question/{question}/edit", name="question_edit")
     */
    public function edit(Question $question, Request $request)
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->add("submit", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($question);
            $entitymanager->flush();
        }

        return $this->render('question/edit.html.twig', [
            'form' => $form->createView(),
            'question' => $question
        ]);
    }

    /**
     * @Route("/hum/question/{question}/delete", name="question_delete")
     */
    public function delete(Question $question, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $confirmation = $request->get("confirmation");
            if ($confirmation) {
                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->remove($question);
                $entitymanager->flush();
                return $this->redirectToRoute('hum');
            }
        }

        return $this->render('question/delete.html.twig', [
            'question' => $question
        ]);

    }

    /**
     * @Route("/hum/question/{question}/add-answer", name="question_add_answer")
     */
    public function addAnswer(Question $question, Request $request)
    {
        $form = $this->createForm(AnswerType::class);
        $form->add('submit', SubmitType::class);

        if ('POST' === $request->getMethod()) {
            $manager = $this->getDoctrine()->getManager();
            $answer = $request->get("answer");
            $category = $answer["type"];

            if ($category === "0") {
                // Nominal
                $nominals = $this->getNominals($question, $answer);
                foreach ($nominals as $nominal) {
                    $manager->persist($nominal);
                }
            } elseif ($category === "1") {
                // Ordinal
                $scale = $answer["scale"];

                if ($scale) {
                    $ordinal = new OrdinalAnswer();
                    $ordinal->setQuestion($question);
                    $ordinal->setScale($scale);
                    $manager->persist($ordinal);
                }
            } else {
                // Continuous
                $min = $answer["minimum"];
                $max = $answer["maximum"];
                if ($min && $max) {
                    $continuous = new ContinuousAnswer();
                    $continuous->setQuestion($question);
                    $continuous->setMinimum($min);
                    $continuous->setMaximum($max);
                    $manager->persist($continuous);
                }

            }
            $manager->flush();
            return $this->redirectToRoute('question_edit', ['question' => $question->getId()]);
        }

        return $this->render('question/add-answers.html.twig', [
            'form' => $form->createView(),
            'question' => $question
        ]);
    }

    protected function getNominals($question, $answer) {
        $nominals = array();
        $textArray = $answer["text"];

        foreach ($textArray as $text) {
            $nominal = new NominalAnswer();
            $nominal->setQuestion($question);
            $nominal->setValue($text);
            $nominals[] = $nominal;
        }

        return $nominals;

    }
}
