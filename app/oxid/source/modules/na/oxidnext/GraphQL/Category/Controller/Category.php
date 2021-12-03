<?php

/**
 * This Software is the property of ESYON and is protected by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license is a violation of the license agreement and will be
 * prosecuted by civil and criminal law.
 *
 * @copyright      (C) netAdvising GmbH
 * @since              Version 1.0
 * @author             Alexander Hirschfeld <info@netadvising.de>
 * @link               https://www.netadvising.de
 */

declare(strict_types=1);

namespace NetAdvising\OxidNext\GraphQL\Category\Controller;

use NetAdvising\OxidNext\GraphQL\Category\DataType\CategoryTree as CategoryTreeDataType;
use OxidEsales\GraphQL\Storefront\Category\Service\Category as CategoryService;
use NetAdvising\OxidNext\GraphQL\Category\Service\CategoryTree as CategoryTreeService;
use TheCodingMachine\GraphQLite\Annotations\Query;

/**
 *
 */
final class Category
{
    /** @var CategoryTreeService */
    private CategoryTreeService $categoryTreeService;

    /**
     * @param CategoryService $categoryService
     * @param CategoryTreeService $categoryTreeService
     */
    public function __construct(
        CategoryService $categoryService,
        CategoryTreeService $categoryTreeService
    ) {
        $this->categoryTreeService = $categoryTreeService;
    }

    /**
     * Returns the category tree to second level.
     *
     * @Query
     *
     * @return CategoryTreeDataType[]
     */
    public function categorieTree(int $langId): array
    {
        return $this->categoryTreeService->getCategoryTree($langId);
    }
}
