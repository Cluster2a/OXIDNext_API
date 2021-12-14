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

use TheCodingMachine\GraphQLite\Annotations\Factory;
use TheCodingMachine\GraphQLite\Annotations\Field;

class SelectedVariants
{
    /**
     * @var string
     */
    private string $variant;

    public function __construct(
        string $variant
    )
    {
        $this->variant = $variant;
    }

    /**
     * @Field()
     */
    public function getVariant(): string
    {
        return $this->variant;
    }

    /**
     * @Factory(name="SelectedVariants", default=true)
     */
    public static function createSelectedVariants(string $variant): self
    {
        return new self($variant);
    }
}