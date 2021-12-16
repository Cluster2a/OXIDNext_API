<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace NetAdvising\OxidNext\GraphQL\Basket\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\FormatPriceLogic;
use OxidEsales\Eshop\Application\Model\Basket as EshopBasketModel;

final class Basket
{
    public function formattingPrice(EshopBasketModel $basket): string
    {
        $basket->calculateBasket();
        $nettoSum = $basket->getNettoSum();
        $priceFormatter = new FormatPriceLogic();

        return $priceFormatter->formatPrice(['price' => $nettoSum]);
    }
}
