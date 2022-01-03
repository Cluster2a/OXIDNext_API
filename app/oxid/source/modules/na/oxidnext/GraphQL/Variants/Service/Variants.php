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

namespace NetAdvising\OxidNext\GraphQL\Variants\Service;

use NetAdvising\OxidNext\GraphQL\Shared\DataType\SelectedVariants;
use NetAdvising\OxidNext\GraphQL\Shared\DataType\VariantList as VariantListDataType;
use NetAdvising\OxidNext\GraphQL\Shared\DataType\Variants as VariantsDataType;
use NetAdvising\OxidNext\GraphQL\Shared\DataType\VariantSelection as VariantSelectionDataType;
use OxidEsales\Eshop\Application\Model\Article;
use TheCodingMachine\GraphQLite\Types\ID;

class Variants
{
    /**
     * @Field()
     * @param ID $productId
     * @param SelectedVariants[]|null $selectedVariants
     * @return VariantSelectionDataType
     */
    public function variants(ID $productId, array $selectedVariants): VariantSelectionDataType
    {
        $currentUserSelection = [];
        if (is_null($selectedVariants) !== true) {
            foreach ($selectedVariants as $variantSelection) {
                $currentUserSelection[] = $variantSelection->getVariant();
            }
        }

        $article = oxNew(Article::class);
        $article->load($productId);
        $variants = $article->getVariantSelections($currentUserSelection);

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