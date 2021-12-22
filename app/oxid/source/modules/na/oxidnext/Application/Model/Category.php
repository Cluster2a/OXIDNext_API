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
     * @param ?int $iLang language id
     * @return string
     */
    public function getBaseSeoShortLink(?int $iLang = null): string
    {
        if ($iLang === null) {
            $languageService = Registry::getLang();
            $iLang = $languageService->getBaseLanguage();
        }
        $oEncoder = Registry::get(SeoEncoderCategory::class);
        return $oEncoder->getCategoryUri($this, $iLang);
    }

    /**
     * Returns category preview picture url if exist, false - if not
     *
     * @return bool|string|null
     */
    public function getPreviewImage()
    {
        $preview = $this->oxcategories__na_sf_banner->value;
        if (empty($preview) === true) {
            $parentcategory = oxNew(\OxidEsales\Eshop\Application\Model\Category::class);
            $parentcategory->load($this->oxcategories__oxrootid->value);
            $preview = $parentcategory->oxcategories__na_sf_banner->value;
        }

        if (empty($preview) !== true) {
            $sSize = '1094*730'; // ToDo: Parametrisierung
            return Registry::getPictureHandler()->getPicUrl("category/na_sf_banner/", $preview, $sSize);
        }

        return "";
    }

    public function save()
    {
        $ret = parent::save();

        $languageService = Registry::getLang();
        $languages = $languageService->getLanguageArray();

        $genCategory = oxNew(\OxidEsales\Eshop\Application\Model\Category::class);

        foreach ($languages as $language) {
            $genCategory->loadInLang($language->id, $this->getId());
            $genCategory->getLink();
        }

        return $ret;
    }
}