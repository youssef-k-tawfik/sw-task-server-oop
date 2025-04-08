<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Factory\CategoryFactory;
use App\Utils\CustomLogger;

/**
 * Service for handling category-related operations.
 */
class CategoryService
{
    /**
     * @var CategoryRepository The repository for fetching categories.
     */
    private CategoryRepository $categoryRepository;

    /**
     * Constructor to initialize the CategoryService.
     *
     * @param CategoryRepository $categoryRepository The repository for categories.
     */
    public function __construct(
        CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Fetch and process all categories.
     *
     * @return array      The list of processed categories.
     * @throws \Exception If an error occurs while fetching categories.
     */
    public function getAllCategories(): array
    {
        try {
            $results = $this->categoryRepository->fetchAllCategories();
            $categories = $this->processCategoryResults($results);

            CustomLogger::debug(__FILE__, __LINE__, $categories);
            return $categories;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching categories: " . $e->getMessage());
        }
    }

    /**
     * Process raw category results into structured categories.
     *
     * @param array $results The raw category data from the repository.
     * @return array         The structured list of categories.
     */
    private function processCategoryResults(array $results): array
    {
        $categories = [];

        foreach ($results as $row) {
            $category = CategoryFactory::create($row['name']);
            $categories[] = $category;
        }

        return $categories;
    }
}
