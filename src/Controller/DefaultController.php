<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="start", methods={"GET"})
     */
    public function index()
    {
        return $this->redirectToRoute('hum');
    }
}
