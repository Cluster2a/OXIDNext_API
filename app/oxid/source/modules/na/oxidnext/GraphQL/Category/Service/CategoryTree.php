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

namespace NetAdvising\OxidNext\GraphQL\Category\Service;

use NetAdvising\OxidNext\GraphQL\Category\DataType\CategorySubTree;
use NetAdvising\OxidNext\GraphQL\Category\DataType\CategoryTree as CategoryTreeDataType;
use NetAdvising\OxidNext\GraphQL\Category\Infrastructure\CategoryTree as CategoryTreeInfrastructure;

final class CategoryTree
{
    /** @var CategoryTreeInfrastructure */
    private CategoryTreeInfrastructure $categoryTreeInfrastructure;


    public function __construct(
        CategoryTreeInfrastructure $categoryTreeInfrastructure
    )
    {
        $this->categoryTreeInfrastructure = $categoryTreeInfrastructure;
    }


    /**
     * @return CategoryTreeDataType[]
     */
    public function getCategoryTree(int $langId = 0): array
    {
        $result = [];

        $categoryTree = $this->categoryTreeInfrastructure->getCategoryTree($langId);

        foreach ($categoryTree as $category) {
            if ($category->getIsVisible() !== true) {
                continue;
            }

            $category->loadInLang($langId, $category->getId());

            $subCategoriesCollection = [];

            $subCategories = $category->getSubCats();
            if ($subCategories) {
                foreach ($subCategories as $subCategory) {
                    if ($subCategory->getIsVisible() !== true) {
                        continue;
                    }

                    $subCategory->loadInLang($langId, $subCategory->getId());

                    $subCategoriesCollection[] = new CategorySubTree(
                        $subCategory->getId(),
                        $subCategory->oxcategories__oxtitle->value,
                        $subCategory->getShortLink(),
                    );
                }
            }

            $result[] = new CategoryTreeDataType(
                $category->getId(),
                $category->oxcategories__oxtitle->value,
                $category->getShortLink(),
                $subCategoriesCollection
            );
        }
        return $result;
    }
}
