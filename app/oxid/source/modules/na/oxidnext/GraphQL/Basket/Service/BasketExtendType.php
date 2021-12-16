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

use NetAdvising\OxidNext\GraphQL\Basket\Infrastructure\Basket as BasketInfrastructure;
use OxidEsales\GraphQL\Storefront\Basket\Exception\BasketNotFound;
use OxidEsales\GraphQL\Storefront\Basket\Infrastructure\Repository as BasketRepository;
use OxidEsales\GraphQL\Storefront\Basket\DataType\Basket;
use OxidEsales\GraphQL\Storefront\Shared\Infrastructure\Basket as SharedInfrastructure;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\ExtendType;

/**
 * @ExtendType(class=Basket::class)
 */
final class BasketExtendType
{
    /** @var BasketInfrastructure */
    private BasketInfrastructure $basketInfrastructure;

    /** @var SharedInfrastructure */
    private SharedInfrastructure $sharedInfrastructure;

    public function __construct(
        BasketInfrastructure $basketInfrastructure,
        SharedInfrastructure $sharedInfrastructure
    ) {
        $this->basketInfrastructure = $basketInfrastructure;
        $this->sharedInfrastructure   = $sharedInfrastructure;
    }

    /**
     * @Field()
     * @param Basket $basket
     * @return string
     */
    public function getFormattedNetPrice(Basket $basket): string
    {
        $basket = $this->sharedInfrastructure->getBasket($basket);
        return $this->basketInfrastructure->formattingPrice($basket);
    }
}
