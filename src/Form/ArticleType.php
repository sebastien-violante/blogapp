<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
            ])
            ->add('content', TextareaType::class, [
                "label" => "Contenu",
                /* Be carefull ! Because of use of CKEditor, need to declare this field not required */
                "required" => false,
                /* End of comment */
                "attr" => [
                    "rows" => 20,
                ]
            ])
            ->add('imageFile', FileType::class, [
                "label" => "Image à télécharger"
            ])
            ->add("categories", EntityType::class, [
                "label" => "Catégorie(s)",
                "class" => Category::class,
                "choice_label" => "name",
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'choices_categories'
                ]
                
            ])





        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
