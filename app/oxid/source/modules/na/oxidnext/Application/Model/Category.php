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

use OxidEsales\Eshop\Application\Model\SeoEncoderCategory;
use OxidEsales\Eshop\Core\Registry;

class Category extends Category_parent
{
    /**
     * returns the url of the category
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
     * Returns raw category seo url
     *
     * @param int $iLang language id
     * @return string
     */
    public function getBaseSeoShortLink(int $iLang): string
    {
        $oEncoder = Registry::get(SeoEncoderCategory::class);
        return $oEncoder->getCategoryUri($this, $iLang);
    }
}