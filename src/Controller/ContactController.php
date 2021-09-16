<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $message = (new TemplatedEmail())
                ->from($contact['email'])
                ->to('perrotguillaume@hotmail.fr')
                ->subject('[OCTOGONE] Message de '. $contact['name'])
                ->text('Sender: '.$contact['name'].\PHP_EOL.$contact['content'],'text/plain')
                ;

            $mailer->send($message);

            $this->addFlash(
                'message',
                'Votre message a été transmit, nous vous répondrons dans les meilleurs délais'
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
