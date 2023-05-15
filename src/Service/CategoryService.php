<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CategoryService {

    private $categoryRepository;
    private $requestStack;

    // 
    public function __construct(CategoryRepository $categoryRepository, RequestStack $requestStack) {
        $this->categoryRepository = $categoryRepository;
        $this->requestStack = $requestStack;
    }

    public function updateSession() {
        $session = $this->requestStack->getSession();
        $categories = $this->categoryRepository->findAll();
        $session->set('categories', $categories);

    }
}