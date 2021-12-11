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


use NetAdvising\OxidNext\GraphQL\Product\DataType\SelectedVariants;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\ExtendType;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 *
 */
final class ProductStorage
{
    /** @var SelectedVariants[]|null */
    private ?array $selectedVariants;

    /**
     * @param SelectedVariants[]|null $selectedVariants
     */
    public function setVariantSelection(?array $selectedVariants): void
    {
        $this->selectedVariants = $selectedVariants;
    }

    /**
     * @return SelectedVariants[]|null
     */
    public function getVariantSelection(): ?array
    {
        return $this->selectedVariants;
    }
}