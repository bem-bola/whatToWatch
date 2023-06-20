<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Search;
use App\Form\SearchType;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{

      /**
     * @Route("/register/confirm", name="register_confirm")
     */
    public function confirm(): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);
       

        return $this->render('registration/confirm.html.twig',[
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,  MailerInterface $mailer): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $emailUser = $form->get("email")->getData();

            // do anything else you need here, like send an email
            


            $email = (new TemplatedEmail())
                
            ->from($this->getParameter('email_admin'))
            ->to(new Address($emailUser))
            ->subject('Confirmation d\'inscription sur W2W')

            // path of the Twig template to render
            ->htmlTemplate('emails/registration.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'user'      => $emailUser, /*recupere email renseigné*/ 
                'password'  => $form->get("plainPassword")->getData(),
                'lastname'  => $form->get("nom")->getData(),
                'firstname' => $form->get("prenom")->getData(),

            ])
        ;
        
            $send = $mailer->send($email);


            return $this->redirectToRoute('register_confirm');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'formSearch' => $formSearch->createView(), 
        ]);
    }
}
