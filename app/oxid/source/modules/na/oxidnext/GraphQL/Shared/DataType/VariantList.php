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

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class VariantList
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $value;

    /**
     * @var bool
     */
    private bool $active;

    /**
     * @var bool
     */
    private bool $disabled;


    public function __construct(
        string $name,
        string $value,
        bool   $active,
        bool   $disabled
    )
    {
        $this->name = $name;
        $this->value = $value;
        $this->active = $active;
        $this->disabled = $disabled;
    }

    /**
     * @Field()
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @Field()
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @Field()
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @Field()
     */
    public function getDisabled(): bool
    {
        return $this->disabled;
    }
}
