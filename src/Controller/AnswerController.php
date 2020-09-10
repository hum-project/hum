<?php

namespace App\Controller;

use App\Entity\ContinuousAnswer;
use App\Entity\NominalAnswer;
use App\Entity\OrdinalAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AnswerController extends AbstractController
{
    /**
     * @Route("/hum/nominal-answer/{answer}/delete", name="nominal_delete")
     */
    public function deleteNominal(NominalAnswer $answer, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $confirmation = $request->get("confirmation");
            if ($confirmation) {
                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->remove($answer);
                $entitymanager->flush();
                return $this->redirectToRoute('question_edit', ["question" => $answer->getQuestion()->getId()]);
            }
        }

        return $this->render('answer/delete.html.twig', [
            'answer' => $answer
        ]);
    }

    /**
     * @Route("/hum/ordinal-answer/{answer}/delete", name="ordinal_delete")
     */
    public function deleteOrdinal(OrdinalAnswer $answer, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $confirmation = $request->get("confirmation");
            if ($confirmation) {
                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->remove($answer);
                $entitymanager->flush();
                return $this->redirectToRoute('question_edit', ["question" => $answer->getQuestion()->getId()]);
            }
        }

        return $this->render('answer/delete.html.twig', [
            'answer' => $answer
        ]);
    }

    /**
     * @Route("/hum/continuous-answer/{answer}/delete", name="continuous_delete")
     */
    public function deleteContinuous(ContinuousAnswer $answer, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $confirmation = $request->get("confirmation");
            if ($confirmation) {
                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->remove($answer);
                $entitymanager->flush();
                return $this->redirectToRoute('question_edit', ["question" => $answer->getQuestion()->getId()]);
            }
        }

        return $this->render('answer/delete.html.twig', [
            'answer' => $answer
        ]);
    }
}
