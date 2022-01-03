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

use NetAdvising\OxidNext\GraphQL\Shared\DataType\SelectedVariants;
use NetAdvising\OxidNext\GraphQL\Shared\DataType\VariantList as VariantListDataType;
use NetAdvising\OxidNext\GraphQL\Shared\DataType\Variants as VariantsDataType;
use NetAdvising\OxidNext\GraphQL\Shared\DataType\VariantSelection as VariantSelectionDataType;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\VariantHandler;
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
     */
    public function getIsBuyable(Product $product): bool
    {
        return $product->getEshopModel()->isBuyable();
    }

    /**
     * @Field()
     */
    public function getVarSelection(Product $product): string
    {
        return $product->getEshopModel()->oxarticles__oxvarselect->value;
    }

    /**
     * @Field()
     * @param Product $product
     * @param SelectedVariants[]|null $selectedVariants
     * @return VariantSelectionDataType
     */
    public function getVariantSelection(Product $product, ?array $selectedVariants = null): VariantSelectionDataType
    {
        $currentUserSelection = [];
        if (is_null($selectedVariants) !== true) {
            foreach ($selectedVariants as $variantSelection) {
                $currentUserSelection[] = $variantSelection->getVariant();
            }
        }

        $productId = $product->getEshopModel()->getId();

        $article = oxNew(Article::class);
        $article->load($productId);
        $variants = $article->getVariantSelections($currentUserSelection);
        if ($variants === false) {
            if ($article->isVariant() === true) {
                $parent = $article->getParentArticle();
                $parent->setNoVariantLoading(false);
                //$variants = $parent->getVariantSelections(null, $article->getId());
                $variants = $parent->getVariantSelections($currentUserSelection);
            }
        }

        $variantSelection = [];

        foreach ($variants['selections'] as $variant) {
            $list = [];
            $selections = $variant->getSelections();
            foreach ($selections as $selection) {
                $list[] = new VariantListDataType(
                    $selection->getName(),
                    $selection->getValue(),
                    $selection->isActive() === true,
                    $selection->isDisabled() === true,
                    method_exists($selection, 'getType') ? $selection->getType() : null,
                    method_exists($selection, 'getColorCode') ? $selection->getColorCode() : null,
                    method_exists($selection, 'getImage') ? $selection->getImage() : null
                );
            }

            $activeSelection = $variant->getActiveSelection();
            if (is_null($activeSelection) !== true) {
                $activeSelection = new VariantListDataType(
                    $activeSelection->getName(),
                    $activeSelection->getValue(),
                    $activeSelection->isActive() === true,
                    $activeSelection->isDisabled() === true,
                    method_exists($activeSelection, 'getType') ? $activeSelection->getType() : null,
                    method_exists($activeSelection, 'getColorCode') ? $activeSelection->getColorCode() : null,
                    method_exists($activeSelection, 'getImage') ? $activeSelection->getImage() : null
                );
            }

            $variantSelection[] = new VariantsDataType(
                $variant->getLabel(),
                $list,
                $activeSelection,
                method_exists($variant, 'isEnriched') ? $variant->isEnriched() : false
            );
        }

        $productId = null;
        if ($variants['blPerfectFit'] === true) {
            $productId = $variants['oActiveVariant']->getId();
        }

        return new VariantSelectionDataType($variantSelection, $productId);
    }
}