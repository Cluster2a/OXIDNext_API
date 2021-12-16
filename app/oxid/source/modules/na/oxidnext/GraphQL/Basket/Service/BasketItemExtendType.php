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

namespace NetAdvising\OxidNext\GraphQL\Basket\Service;

use NetAdvising\OxidNext\GraphQL\Basket\Infrastructure\BasketItem as BasketItemInfrastructure;
use OxidEsales\GraphQL\Storefront\Basket\DataType\BasketItem;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\ExtendType;

/**
 * @ExtendType(class=BasketItem::class)
 */
final class BasketItemExtendType
{
    /** @var BasketItemInfrastructure */
    private BasketItemInfrastructure $basketItemInfrastructure;

    public function __construct(
        BasketItemInfrastructure $basketItemInfrastructure
    ) {
        $this->basketItemInfrastructure = $basketItemInfrastructure;
    }

    /**
     * @Field()
     */
    public function getFormattedNetPrice(BasketItem $basketItem): string
    {
        return $this->basketItemInfrastructure->formattingPrice($basketItem);
    }
}
