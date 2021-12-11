<?php

/**
 * This Software is the property of netAdvising and is protected by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license is a violation of the license agreement and will be
 * prosecuted by civil and criminal law.
 *
 * @copyright      (C) netAdvising GmbH
 * @since              Version 1.0
 * @author             Alexander Hirschfeld <info@netadvising.de>
 * @link               https://www.netadvising.de
 */

declare(strict_types=1);

namespace NetAdvising\OxidNext\GraphQL\Product\Controller;

use NetAdvising\OxidNext\GraphQL\Product\DataType\SelectedVariants;
use NetAdvising\OxidNext\GraphQL\Product\Service\ProductStorage;
use OxidEsales\GraphQL\Storefront\Product\DataType\Product as ProductDataType;
use OxidEsales\GraphQL\Storefront\Product\Service\Product as ProductService;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Types\ID;

final class Product
{
    /** @var ProductService */
    private ProductService $productService;

    /** @var ProductStorage */
    private ProductStorage $productStorage;

    public function __construct(
        ProductService $productService,
        ProductStorage $productStorage
    ) {
        $this->productService = $productService;
        $this->productStorage = $productStorage;
    }

    /**
     * @Query()
     *
     * @param ID $productId
     * @param SelectedVariants[]|null $selectedVariants
     * @return ProductDataType
     * @throws \OxidEsales\GraphQL\Base\Exception\InvalidLogin
     * @throws \OxidEsales\GraphQL\Storefront\Product\Exception\ProductNotFound
     */
    public function product(
        ID $productId,
        ?array $selectedVariants = null
    ): ProductDataType
    {
        $this->productStorage->setVariantSelection($selectedVariants);
        return $this->productService->product($productId);
    }
}
