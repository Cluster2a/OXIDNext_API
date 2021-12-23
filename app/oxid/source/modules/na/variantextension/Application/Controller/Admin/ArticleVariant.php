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

namespace NetAdvising\VariantExtension\Application\Controller\Admin;

use NetAdvising\VariantExtension\Core\DummyObject;
use NetAdvising\VariantExtension\Core\NaUtilsFile;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\Exception\SystemComponentException;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;

/**
 * ArticleVariant extension
 */
class ArticleVariant extends ArticleVariant_parent
{
    /**
     * @var string
     */
    protected string $imagePath = '';

    /**
     * @throws SystemComponentException
     */
    public function saveVariantExtension()
    {
        $sOXID = Registry::getRequest()->getRequestEscapedParameter("voxid");

        /** @var Article $oArticle */
        $oArticle = oxNew(Article::class);

        if ($sOXID != "-1") {
            $oArticle->loadInLang($this->_iEditLang, $sOXID);

            $currentVariantExtensions = $oArticle->getVariantExtension();

            $this->deleteArticleVariantImages($currentVariantExtensions);

            $uploadedFiles = $this->uploadArticleVariantImages();

            $variantNames = Registry::getRequest()->getRequestEscapedParameter("variantName");
            $variantValues = Registry::getRequest()->getRequestEscapedParameter("variantValue");
            $variantContentTypes = Registry::getRequest()->getRequestEscapedParameter("variantContentType");
            $variantImages = Registry::getRequest()->getRequestEscapedParameter("variantImage");
            $variantColorCodes = Registry::getRequest()->getRequestEscapedParameter("variantColorCode");

            $mergedData = [];
            foreach ($variantNames as $key => $value) {
                $record = new \stdClass();
                $record->id = $key;
                $record->variantName = $value;
                $record->variantValue = $variantValues[$key];
                $record->variantContentType = $variantContentTypes[$key];
                $record->variantColorCode = $variantColorCodes[$key];
                $record->variantImage = empty($uploadedFiles[$key]) === true ? $variantImages[$key] : $uploadedFiles[$key];
                $mergedData[] = $record;
            }

            $oArticle->oxarticles__na_variantextension = new Field(serialize($mergedData), Field::T_RAW);
            $oArticle->save();
        }
    }

    /**
     * @param array $variantExtensions
     * @return void
     */
    private function deleteArticleVariantImages(array $variantExtensions)
    {
        $newImages = [];
        $utilsFile = oxNew(NaUtilsFile::class);
        $aFiles = $_FILES;
        if (isset($aFiles['myfile']['name'])) {
            foreach ($aFiles['myfile']['name'] as $sKey => $sValue) {
                $aFiletype = explode("@", $sKey);
                $sType = $aFiletype[0];
                $index = (int) str_replace("varinat_image", "", $aFiletype[1]);
                $sValue = strtolower($sValue);
                $sImagePath = $utilsFile->getImagePath($sType);

                if (empty($sValue) !== true) {
                    $newImages[$index] = $utilsFile->uniqueImageName($sValue, $sType, false, $sImagePath, true);
                }
            }
        }

        foreach ($variantExtensions as $variantExtension) {
            $id = $variantExtension->id;
            $imageName = $variantExtension->variantImage;

            if(empty($newImages[$id]) !== true && $imageName !== $newImages[$id]) {
                $this->deleteImage($imageName);
            }
        }
    }

    /**
     * @param $imageName
     * @return void
     */
    private function deleteImage($imageName)
    {
        if(empty($this->imagePath) === true) {
            $utilsFile = oxNew(NaUtilsFile::class);
            $this->imagePath = $utilsFile->getImagePath('NA_VARINAT_IMAGES');
        }

        @unlink($this->imagePath . DIRECTORY_SEPARATOR . $imageName);
    }

    /**
     * Saves article variant.
     *
     * @return array
     */
    public function uploadArticleVariantImages(): array
    {

        $utilsFile = oxNew(NaUtilsFile::class);

        $wrapper = new \stdClass();
        $aFiles = $_FILES;
        $wrapper->files = [];
        if (isset($aFiles['myfile']['name'])) {
            foreach ($aFiles['myfile']['name'] as $sKey => $sValue) {
                $aFiletype = explode("@", $sKey);
                $sKey = $aFiletype[1];
                $field = new DummyObject($wrapper, (int) str_replace("varinat_image", "", $sKey));
                $wrapper->{$sKey} = $field;
            }

        }
        $utilsFile->processFiles($wrapper);
        return $wrapper->files;
    }

}