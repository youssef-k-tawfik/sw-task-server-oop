<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver;

use App\Service\CategoryService;

/**
 * Resolver for fetching categories in GraphQL.
 */
class CategoryResolver
{
    /**
     * @var CategoryService The service for retrieving categories.
     */
    private CategoryService $categoryService;

    /**
     * @param CategoryService $categoryService The service for retrieving categories.
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Resolve all categories.
     *
     * @return array The list of all categories.
     */
    public function getCategories(): array
    {
        return $this->categoryService->getAllCategories();
    }
}
