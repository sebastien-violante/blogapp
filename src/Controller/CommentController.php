<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{// The commentById method allows to write a comment about an article
    #[Route('/comment/{id}', name: 'app_comment')]
    public function commentById(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        ArticleRepository $articleRepository,
        int $id,
    ): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new DateTimeImmutable());
            $article = $articleRepository->findOneById($id);
            $comment->setArticle($article);
            $entityManagerInterface->persist($comment);
            $entityManagerInterface->flush();
            
            return $this->redirectToRoute('app_home');
        }
        
        return $this->renderForm('comment/index.html.twig', [
            'form' => $form,
        ]);
    }
}
