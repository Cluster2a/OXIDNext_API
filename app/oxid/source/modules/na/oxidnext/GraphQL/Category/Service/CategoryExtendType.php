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

use OxidEsales\GraphQL\Storefront\Category\DataType\Category;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\ExtendType;

/**
 * @ExtendType(class=Category::class)
 */
final class CategoryExtendType
{
    /**
     * @Field()
     */
    public function shortLink(Category $category): string
    {
        return $category->getEshopModel()->getBaseSeoShortLink();
    }

    /**
     * @Field()
     */
    public function getPreviewImage(Category $category): string
    {
        return $category->getEshopModel()->getPreviewImage();
    }

}