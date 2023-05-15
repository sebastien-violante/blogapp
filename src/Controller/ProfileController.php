<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Service\ManageFile;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    // The $File constant and the constructeur are used to allow author image downloading
    private $File;
    public function __construct(ManageFile $manageFile) {
        $this->manageFile = $manageFile;
    }
    
    // The profileCompletion method allows to complete informations about the author by filling a form
    #[Route('/profile', name: 'app_profile')]
    public function profileCompletion(
        Request $request,
        ProfileRepository $profileRepository,
        EntityManagerInterface $entityManagerInterface,
    ): Response
    {
        $user = $this->getUser();
        $profile = $profileRepository->findOneByUser($user);     
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['imageFile']->getData();
            if ($file) {
                $file_url = $this->manageFile->update_file($file, $profile->getCoverPicture());
                $profile->setCoverPicture($file_url);
            }
            $entityManagerInterface->persist($profile);
            $entityManagerInterface->flush();
            
            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('profile/index.html.twig', [
            'profile' => $profile,
            'form' => $form,
            'user' => $user,
        ]);
    }
}
