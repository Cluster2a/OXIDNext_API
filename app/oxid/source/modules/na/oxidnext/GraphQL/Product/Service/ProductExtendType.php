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

namespace NetAdvising\OxidNext\GraphQL\Product\Service;

use NetAdvising\OxidNext\GraphQL\Product\DataType\VariantSelection as VariantSelectionDataType;
use NetAdvising\OxidNext\GraphQL\Product\DataType\VariantSelectionList as VariantSelectionListDataType;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\GraphQL\Storefront\Product\DataType\Product;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\ExtendType;

/**
 * @ExtendType(class=Product::class)
 */
final class ProductExtendType
{
    /**
     * @Field()
     */
    public function shortLink(Product $product): string
    {
        return $product->getEshopModel()->getBaseSeoShortLink();
    }

    /**
     * @Field()
     */
    public function formattedPrice(Product $product): string
    {
        return $product->getEshopModel()->getFormattedPrice();
    }

    /**
     * @Field()
     */
    public function getRatingAverage(Product $product): float
    {
        return $product->getEshopModel()->getArticleRatingAverage(false);
    }

    /**
     * @Field()
     * @return VariantSelectionDataType[]
     */
    public function getVariantSelections(Product $product): array
    {
        $productId = $product->getEshopModel()->getId();

        $article = oxNew(Article::class);
        $article->load($productId);
        $variants = $article->getVariantSelections();

        if (!is_iterable($variants) || count($variants) === 0) {
            return [];
        }

        $variantSelection = [];

        foreach ($variants['selections'] as $variant) {
            $list = [];
            $selections = $variant->getSelections();
            foreach ($selections as $selection) {
                $list[] = new VariantSelectionListDataType(
                    $selection->getName(),
                    $selection->getValue(),
                    $selection->isActive() === true,
                    $selection->isDisabled() === true
                );
            }
            $variantSelection[] = new VariantSelectionDataType(
                $variant->getLabel(),
                $list
            );


        }


        return $variantSelection;
    }

}