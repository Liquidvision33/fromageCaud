<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function new(Request $request, RequestStack $requestStack, MailerInterface $mailer): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($this->getParameter("mailer_from"))
                ->to("your_email@example.com")
                ->subject("Contact")
                ->html($this->renderView('Email/contactEmail.html.twig', [
                    'form' => $form->createView(),
                ]));

            $this->addFlash('success', 'Formulaire soumis avec succès !');
            $form = $this->createForm(ContactType::class);
            $mailer->send($email);

            return $this->render('contact/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
