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

namespace NetAdvising\OxidNext\GraphQL\Shared\DataType;

use NetAdvising\OxidNext\GraphQL\Shared\DataType\Variants as VariantsDataType;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
class VariantSelection
{
    /**
     * @var VariantsDataType[]
     */
    private array $variants;

    /**
     * @var ?string
     */
    private ?string $selectedVariant;

    public function __construct(
        array   $variants,
        ?string $selectedVariant
    )
    {
        $this->variants = $variants;
        $this->selectedVariant = $selectedVariant;
    }

    /**
     * @Field()
     * @return VariantsDataType[]
     */
    public function getVariants(): array
    {
        return $this->variants;
    }

    /**
     * @Field()
     * @return ?string
     */
    public function getSelectedVariant(): ?string
    {
        return $this->selectedVariant;
    }
}