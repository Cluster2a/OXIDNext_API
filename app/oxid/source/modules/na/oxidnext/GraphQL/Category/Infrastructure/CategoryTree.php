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

namespace NetAdvising\OxidNext\GraphQL\Category\Infrastructure;

use OxidEsales\Eshop\Application\Model\CategoryList;

final class CategoryTree
{
    public function getCategoryTree(int $langId = 0): CategoryList
    {
        /** @var CategoryList $oCategoryTree */
        $oCategoryTree = oxNew(CategoryList::class);
        $oCategoryTree->buildTree(0);

        return $oCategoryTree;
    }
}
