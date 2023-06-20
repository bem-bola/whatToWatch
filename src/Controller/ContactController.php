<?php

namespace App\Controller;

use App\Entity\Search;
use App\Entity\Contact;
use App\Form\SearchType;
use App\Form\ContactType;
use Symfony\Component\Mime\Address;
use App\Repository\ContactRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/send/message", name="send", methods={"GET"})
     */
    public function send_message(): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        return $this->render('contact/send.html.twig', [
            'formSearch' => $formSearch->createView(),
        ]);
    }

    /**
     * @Route("/new", name="contact_new", methods={"GET","POST"})
     */
    public function new(Request $request,  MailerInterface $mailer): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            
            $emailUser = $form->get("email")->getData();

            $email = (new TemplatedEmail())
                
                ->from($this->getParameter('email_admin'))
                ->to(new Address('contact@bem-bola.fr'))
                ->addTo($emailUser)
                ->subject('Contact - w2w')

                // path of the Twig template to render
                ->htmlTemplate('emails/message.html.twig')

                // pass variables (name => value) to the template
                ->context([
                   'user'       => $emailUser, /*recupere email renseigné*/ 
                   'message'    => $form->get("message")->getData(),
                ])
            ;
            
            $send = $mailer->send($email);

            return $this->redirectToRoute('send');
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/{id}", name="contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/{id}", name="contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_index');
    }
}
