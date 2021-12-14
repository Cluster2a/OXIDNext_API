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

namespace NetAdvising\OxidNext\GraphQL\Variants\Controller;

use NetAdvising\OxidNext\GraphQL\Shared\DataType\SelectedVariants;
use NetAdvising\OxidNext\GraphQL\Shared\DataType\VariantSelection as VariantSelectionDataType;
use NetAdvising\OxidNext\GraphQL\Variants\Service\Variants as VariantsService;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Types\ID;

final class Variants
{
    /** @var VariantsService */
    private VariantsService $variantsService;

    public function __construct(
        VariantsService $variantsService
    )
    {
        $this->variantsService = $variantsService;
    }

    /**
     * @Query()
     *
     * @param ID $productId
     * @param SelectedVariants[]|null $selectedVariants
     * @return VariantSelectionDataType
     */
    public function variants(
        ID     $productId,
        ?array $selectedVariants = null
    ): VariantSelectionDataType
    {
        return $this->variantsService->variants($productId, $selectedVariants);
    }
}
