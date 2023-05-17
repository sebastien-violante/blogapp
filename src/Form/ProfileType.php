<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateBirth', TypeDateType::class, [
                "label" => "Date de naissance" ])
            ->add('description', TextareaType::class, [
                "label" => "Décrivez-vous en quelques lignes",
                "required" => false,
                "attr" => [
                    "rows" => 5,
                ]
            ])
            ->add('imageFile', FileType::class, [
                "label" => "Télécharger une image de profil (Maximum 2 Mo)",
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
            'data_class' => Profile::class,
        ]);
    }
}
