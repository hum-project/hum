<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index()
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    /**
     * @Route("/question/add", name="question_add")
     */
    public function add(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        dump($question);

        return $this->render('question/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
