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

namespace NetAdvising\OxidNext\Application\Controller\Admin;

use NetAdvising\OxidNext\Core\NaUtilsFile;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use stdClass;

class CategoryStorefront extends AdminDetailsController
{
    public function render()
    {
        parent::render();

        /** @var Category $category */

        $categoryId = $this->getEditObjectId();
        $category = oxNew(Category::class);
        $category->loadInLang($this->_iEditLang, $categoryId);
        if ($category->isDerived()) {
            $this->_aViewData['readonly_fields'] = true;
        }

        $oOtherLang = $category->getAvailableInLangs();
        if (!isset($oOtherLang[$this->_iEditLang])) {
            // echo "language entry doesn't exist! using: ".key($oOtherLang);
            $category->loadInLang(key($oOtherLang), $categoryId);
        }

        // remove already created languages
        $aLang = array_diff(Registry::getLang()->getLanguageNames(), $oOtherLang);
        if (count($aLang)) {
            $this->_aViewData["posslang"] = $aLang;
        }

        foreach ($oOtherLang as $id => $language) {
            $oLang = new stdClass();
            $oLang->sLangDesc = $language;
            $oLang->selected = ($id == $this->_iEditLang);
            $this->_aViewData["otherlang"][$id] = clone $oLang;
        }

        $this->_aViewData["edit"] = $category;
        $this->_aViewData["oxid"] = $categoryId;

        return "category_storefront.tpl";
    }

    /**
     * Saves article category data.
     *
     * @return void
     */
    public function save()
    {
        parent::save();

        $oxId = $this->getEditObjectId();
        $params = Registry::getRequest()->getRequestEscapedParameter("editval");

        $category = oxNew(Category::class);
        $catLang = Registry::getRequest()->getRequestEscapedParameter("catlang");
        $catLang = $catLang ? $catLang : 0;

        if ($oxId != "-1") {
            $category->loadInLang($catLang, $oxId);
        } else {
            $params['oxcategories__oxid'] = null;
        }

        //Disable editing for derived items
        if ($category->isDerived()) {
            return;
        }


        $category->setLanguage(0);
        $category->assign($params);
        $category->setLanguage($catLang);

        $category = $this->updateCategoryOnSave($category, $params);

        $category->save();

        $this->setEditObjectId($category->getId());
    }

    /**
     * Set parameters, language and files to category object.
     *
     * @param Category $category
     * @param array $params
     *
     * @return object
     */
    protected function updateCategoryOnSave(Category $category, array $params): object
    {
        $category->assign($params);
        $category->setLanguage($this->_iEditLang);

        $utilsFile = oxNew(NaUtilsFile::class);

        return $utilsFile->processFiles($category);
    }

    /**
     * Parse parameters prior to saving category.
     *
     * @param array $aReqParams Request parameters.
     *
     * @return array
     */
    protected function parseRequestParametersForSave(array $aReqParams): array // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
    {
        // checkbox handling
        if (!isset($aReqParams['oxcategories__na_sf_banner'])) {
            $aReqParams['oxcategories__na_sf_banner'] = '';
        }

        return $aReqParams;
    }
}