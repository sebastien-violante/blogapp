<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\ContactSubject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options): void
    {
        $builder
            ->add('full_name', TextType::class, [
                "label" => "Votre nom ou pseudo :",
                "required" => true,
                ]
            )
            ->add("email", EmailType::class,  [
                "label" => "Votre adresse mail :",
                "required" => true,])
            ->add("message", TextareaType::class, [
                "label" => "Votre message :",
                "attr" => [
                    "placeholder" => "Soyez concis(e). 2000 caractères devraient suffire...",
                    "rows" => 10
                ],
                "required" => true,
            ])    
            ->add("contactSubject", EntityType::class, [
                "label" => "Le sujet de votre message :",
                "class" => ContactSubject::class,
                "choice_label" => "item",
                'multiple' => false,
                'expanded' => false,
            ])
            ->add("envoyer", SubmitType::class, [
                "label" => "Envoyer",
                "attr" => [
                    "class" => "btn btn-primary form-btn",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
