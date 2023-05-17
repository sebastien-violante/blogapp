<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CategoryService {

    private $categoryRepository;
    private $requestStack;
    private $contactRepository;

    // 
    public function __construct(
        CategoryRepository $categoryRepository,
        ContactRepository $contactRepository,
        RequestStack $requestStack) {
        $this->categoryRepository = $categoryRepository;
        $this->contactRepository = $contactRepository;
        $this->requestStack = $requestStack;
    }

    public function updateSession() {
        $session = $this->requestStack->getSession();
        $categories = $this->categoryRepository->findAll();
        $messagesToReply = count($this->contactRepository->findBy(['consulted' => false]));
        $session->set('categories', $categories);
        $session->set('messagesToReply', $messagesToReply);
    }
}