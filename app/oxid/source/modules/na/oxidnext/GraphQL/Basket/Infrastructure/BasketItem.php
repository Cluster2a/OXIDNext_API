<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace NetAdvising\OxidNext\GraphQL\Basket\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\FormatPriceLogic;
use OxidEsales\GraphQL\Storefront\Basket\DataType\BasketItem as BasketItemDataType;

final class BasketItem
{
    public function formattingPrice(BasketItemDataType $basketItem): string
    {
        $userBasketItem = $basketItem->getEshopModel();
        $price = $userBasketItem->getArticle('')->getPrice();
        $priceFormatter = new FormatPriceLogic();

        return $priceFormatter->formatPrice(['price' => $price]);
    }
}
