<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Entity\ContactSubject;
use App\Service\CategoryService;
use App\Repository\CategoryRepository;
use App\Repository\ContactSujectRepository;
use App\Repository\ContactSubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    
    public function index(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact->setCreatedAt(new \DateTimeImmutable());
            $entityManagerInterface->persist($contact);
            $entityManagerInterface->flush();
            $this->addFlash("success", "Votre message a bien été envoyé");
            return $this->redirectToRoute('app_contact');
        } else if($form->isSubmitted() && !$form->isValid())
            $this->addFlash("danger", "Votre message n'a pas pu être envoyé...");
        
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
                ]);
    }
}
