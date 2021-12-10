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

namespace NetAdvising\OxidNext\GraphQL\Product\DataType;

use NetAdvising\OxidNext\GraphQL\Product\DataType\VariantSelectionList as VariantSelectionListDataType;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class VariantSelection
{
    /**
     * @var string
     */
    private string $label;

    /**
     * @var array
     */
    private array $list;

    public function __construct(
        string $label,
        array $list
    ) {
        $this->label  = $label;
        $this->list = $list;
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
     * @return VariantSelectionListDataType[]
     */
    public function getList(): array
    {
        return $this->list;
    }
}
