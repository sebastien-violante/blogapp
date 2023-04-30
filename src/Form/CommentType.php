<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                "label" => "Votre nom ou pseudo",
            ])
            ->add('content', TextareaType::class, [
                "label" => "Votre commentaire",
                "attr" => [
                    "rows" => 5,
                ]
            ])
            ->add('quote',CheckboxType::class,[
                "label" => false,
                "required" => false,
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
            'data_class' => Comment::class,
        ]);
    }
}
