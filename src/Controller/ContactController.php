<?php


namespace App\Controller;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact", methods={"POST"})
     */
    public function contact(Request $request, LoggerInterface $logger, MailerInterface $mailer) {
        $email = null;
        $name = null;
        $message = null;

        try {
            $parameters = json_decode($request->getContent(), true);
            $email = $parameters["email"];
            $name = $parameters["name"];
            $message = $parameters["message"] . "\n\n"
                . "From: " . $name . "\n\n"
                . "Email: " . $email;
            $from = "mailer@hum.nu";

            $email = (new Email())
                ->from($from)
                ->to("contact@hum.nu")
                ->subject("Message for Hum")
                ->text($message);
            $mailer->send($email);
        } catch (\Exception $e) {
            $logger->log(LogLevel::ERROR, "Error posting message: " . $e);
            return new Response('Error posting message', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $logger->info("Got a post request: \n");
        $logger->debug($parameters["name"]);
        return new Response('Posted message from ' . $name, Response::HTTP_OK);
    }
}