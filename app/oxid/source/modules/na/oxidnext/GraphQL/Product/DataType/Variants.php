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

namespace NetAdvising\OxidNext\GraphQL\Product\DataType;

use NetAdvising\OxidNext\GraphQL\Product\DataType\VariantList as VariantListDataType;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class Variants
{
    /**
     * @var string
     */
    private string $label;

    /**
     * @var array
     */
    private array $list;

    /**
     * @var ?VariantListDataType
     */
    private ?VariantListDataType $activeSelection;

    public function __construct(
        string $label,
        array $list,
        ?VariantListDataType $activeSelection
    ) {
        $this->label  = $label;
        $this->list = $list;
        $this->activeSelection = $activeSelection;
    }

    /**
     * @Field()
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @Field()
     * @return VariantListDataType[]
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @Field()
     * @return ?VariantListDataType
     */
    public function getActiveSelection(): ?VariantListDataType
    {
        return $this->activeSelection;
    }
}
