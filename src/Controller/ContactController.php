<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Contact;
use App\Form\AnswerType;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use App\Repository\ContactRepository;
use Symfony\Component\Mailer\Transport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    // The sendContact method allows to send a contact email to the site's administrator
    #[Route('/contact', name: 'app_contact')]
    public function sendContact(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        MailerInterface $mailer,
        ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // Some informations are retrieved from the form to be displayed in the email
            $fullname = $form->getData()->getFullname();
            $fromEmail = $form->getData()->getEmail();
            $content = $form->getData()->getMessage();
            // the environment variables are retrieved to be used in the mail
            $from = $this->getParameter('MAIL_BLOG');
            $to = $this->getParameter('MAIL_ADMIN');
            $email = (new Email())
                ->from($from)
                ->to($to)
                ->subject('Nouveau message de '.$fullname)
                ->text('Blogapp : nouveau message de '.$fullname)
                ->html("<p>".$content."</p><p>Vous pouvez répondre à ".$fullname." à l'adresse suivante : ".$fromEmail."</p>");
            $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
            $mailer = new Mailer($transport);
            $mailer->send($email);
            $contact->setCreatedAt(new \DateTimeImmutable());
            $entityManagerInterface->persist($contact);
            $entityManagerInterface->flush();
            $this->addFlash("success", "Votre message a bien été envoyé");
            return $this->redirectToRoute('app_home');
        } else if($form->isSubmitted() && !$form->isValid())
            $this->addFlash("danger", "Votre message n'a pas pu être envoyé...");
        
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
                ]);
    }

    // The contactList method allows to retrieve all the contacts send via the form contact
    #[Route('/contact/list', name: 'app_contact_list')]
    #[IsGranted('ROLE_ADMIN')]
    public function contactList(
        ContactRepository $contactRepository,
        ): Response
    {
        return $this->render('contact/list.html.twig', [
            'contacts' => $contactRepository->findAll(),
                ]);
    }

    // The contactAnswer method allows te answer someone who send a message via the form contact
    #[Route('/contact/answer/{id}', name: 'app_contact_answer')]
    #[IsGranted('ROLE_ADMIN')]
    public function contactAnswer(
        Request $request,
        ContactRepository $contactRepository,
        EntityManagerInterface $entityManagerInterface,
        Contact $contact,
        int $id,
        ): Response
    {
        $contact = $contactRepository->findOneById($id);
        $form = $this->createForm(AnswerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $answer = ($form->getData())['answer'];
            $contact->setUpdatedAt(new DateTimeImmutable());
            // Each time a contact is answered, it's attribute consulted is set to true
            $contact->setConsulted('true');
            $from = $this->getParameter('MAIL_BLOG');
            $email = (new Email())
                ->from($from)
                ->to($contact->getEmail())
                ->subject('Réponse à votre message du '.date_format($contact->getCreatedAt(), "d/m/Y à h:i:s"))
                ->text('Vous avez un message de Blog-app / Dev-uptoyou')
                ->html("
                <h3>Bonjour ".$contact->getFullname()."</h3>
                <p>Nouv avons bien reçu votre message du ".date_format($contact->getCreatedAt(), "d/m/Y à h:i:s")." et nous vous en remerçions</p>
                <p>Voici la réponse que nous pouvons vous apporter :</p>
                <p><i>'".$answer."'</i></p>
                <p><strong>L'équipe d'App-Blog / Dev-uptoyou vous souhaite une bonne journée.</strong></p>");
            $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
            $mailer = new Mailer($transport);
            $mailer->send($email);
            $entityManagerInterface->persist($contact);
            $entityManagerInterface->flush();
            
            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('contact/answer.html.twig', [
            'contact' => $contact,
            'form' => $form,
                ]);
    }
}
