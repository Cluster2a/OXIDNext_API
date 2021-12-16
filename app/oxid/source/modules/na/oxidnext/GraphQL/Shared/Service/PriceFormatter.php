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

namespace NetAdvising\OxidNext\GraphQL\Shared\Service;

use OxidEsales\Eshop\Core\Registry;

final class PriceFormatter
{
    /**
     * returns formatted price according to oxprice (smarty)
     *
     * @param $price
     * @return string
     */
    public function formatPrice($price): string
    {
        $currency = Registry::getConfig()->getActShopCurrencyObject();

        $output = '';
        $decimals = 2;
        $decimalsSeparator = ',';
        $thousandSeparator = '.';
        $currencySign = '';
        $side = '';

        $price = $price->getPrice();

        if (!is_null($currency)) {
            $decimalsSeparator = $currency->dec ?? $decimalsSeparator;
            $thousandSeparator = $currency->thousand ?? $thousandSeparator;
            $currencySign = $currency->sign ?? $currencySign;
            $side = $currency->side ?? $side;
            $decimals = isset($currency->decimal) ? (int)$currency->decimal : $decimals;
        }

        if (is_numeric($price)) {
            if ((float)$price > 0) {
                $sPrice = number_format($price, $decimals, $decimalsSeparator, $thousandSeparator);
                $output = ($side == 'Front') ? $currencySign . $sPrice : $sPrice . ' ' . $currencySign;
            }

            $output = trim($output);
        }

        return $output;
    }
}
