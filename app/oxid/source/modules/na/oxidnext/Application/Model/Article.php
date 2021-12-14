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

namespace NetAdvising\OxidNext\Application\Model;

use OxidEsales\Eshop\Application\Model\SeoEncoderArticle;
use OxidEsales\Eshop\Core\Registry;

/**
 * extension of aricle model
 */
class Article extends Article_parent
{
    /**
     * returns the url of the article
     *
     * @param int|null $iLang language id
     *
     * @return string
     */
    public function getShortLink(int $iLang = null): string
    {
        if ($iLang === null) {
            $iLang = $this->getLanguage();
        }

        if (!isset($this->_aSeoUrls[$iLang])) {
            $this->_aSeoUrls[$iLang] = $this->getBaseSeoShortLink($iLang);
        }

        return $this->_aSeoUrls[$iLang];
    }

    /**
     * returns formatted price according to oxprice (smarty)
     *
     * @return string
     */
    public function getFormattedPrice(): string
    {
        $price = $this->getPrice();
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

    /**
     * Returns raw category seo url
     *
     * @param ?int $iLang language id
     * @return string
     */
    public function getBaseSeoShortLink(?int $iLang = null): string
    {
        if ($iLang === null) {
            $languageService = Registry::getLang();
            $iLang = $languageService->getBaseLanguage();
        }

        $oEncoder = Registry::get(SeoEncoderArticle::class);
        return $oEncoder->getArticleUri($this, $iLang);
    }
}