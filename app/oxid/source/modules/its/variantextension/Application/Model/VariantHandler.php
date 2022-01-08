<?php

/**
 * This Software is the property of ITSOUP and is protected by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license is a violation of the license agreement and will be
 * prosecuted by civil and criminal law.
 *
 * @copyright      (C) ITSOUP Alexander Hirschfeld
 * @since              Version 1.0
 * @author             Alexander Hirschfeld <info@itsoup.de>
 * @link               https://www.itsoup.de
 */

declare(strict_types=1);

namespace ITSOUP\VariantExtension\Application\Model;

use OxidEsales\Eshop\Application\Model\SimpleVariant;
use stdClass;

/**
 * VariantHandler extension
 */
class VariantHandler extends VariantHandler_parent
{
    /**
     * @var \OxidEsales\Eshop\Application\Model\Article|null
     */
    private ?\OxidEsales\Eshop\Application\Model\Article $parent = null;

    /**
     * @var array|null
     */
    private ?array $variantExtensions = null;

    /**
     * @param $varSelect
     * @return bool
     */
    private function varSelectExtensionExists($varSelect): bool
    {
        foreach ($this->variantExtensions as $extension) {
            if($extension->variantName === $varSelect) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $variantName
     * @param $variantValue
     * @return stdClass|null
     */
    private function getSelectExtension($variantName, $variantValue): ?stdClass
    {
        foreach ($this->variantExtensions as $extension) {
            if($extension->variantName === $variantName && $extension->variantValue === $variantValue) {
                return $extension;
            }
        }

        return null;
    }

    /**
     * @param array $varSelects
     * @param array $selections
     * @return array
     */
    private function enrichVariant(array $varSelects, array $selections): array
    {
        foreach ($varSelects as $idx => $varSelect) {
            if($this->varSelectExtensionExists($varSelect) === true) {
                foreach ($selections as $idxs => $selection) {
                    $varSelectExtension = $this->getSelectExtension($varSelect, $selection[$idx]['name']);
                    if(is_null($varSelectExtension) !== true) {
                        $selection[$idx]['contentType'] = $varSelectExtension->variantContentType;
                        $selection[$idx]['colorCode'] = $varSelectExtension->variantColorCode;
                        $selection[$idx]['image'] = $varSelectExtension->variantImage;
                        $selections[$idxs] = $selection;
                    }
                }
            }
        }

        return $selections;
    }

    /**
     * Builds variant selections list - array containing oxVariantSelectList
     *
     * @param array $aVarSelects variant selection titles
     * @param array $aSelections variant selections
     *
     * @return array
     */
    protected function buildVariantSelectionsList($aVarSelects, $aSelections)
    {
        $aSelections = $this->enrichVariant($aVarSelects, $aSelections);

        // creating selection lists
        foreach ($aVarSelects as $iKey => $sLabel) {
            $aVariantSelections[$iKey] = oxNew(\OxidEsales\Eshop\Application\Model\VariantSelectList::class, $sLabel, $iKey);
        }

        // building variant selections
        foreach ($aSelections as $aLineSelections) {
            foreach ($aLineSelections as $oPos => $aLine) {
                $aVariantSelections[$oPos]->addVariant(
                    $aLine['name'],
                    $aLine['hash'],
                    $aLine['disabled'],
                    $aLine['active'],
                    (array_key_exists('contentType', $aLine) === true && empty($aLine['contentType']) !== true ? $aLine['contentType'] : null),
                    (array_key_exists('colorCode', $aLine) === true && empty($aLine['colorCode']) !== true ? $aLine['colorCode'] : null),
                    (array_key_exists('image', $aLine) === true && empty($aLine['image']) !== true ? $aLine['image'] : null),
                );

            }
        }

        return $aVariantSelections;
    }

    /**
     * Creates array/matrix with variant selections
     *
     * @param \OxidEsales\Eshop\Application\Model\ArticleList $oVariantList  variant list
     * @param int                                             $iVarSelCnt    possible variant selection count
     * @param array                                           $aFilter       active filter array
     * @param string                                          $sActVariantId active variant id
     *
     * @return array
     */
    protected function fillVariantSelections($oVariantList, $iVarSelCnt, &$aFilter, $sActVariantId)
    {
        foreach ($oVariantList as $oVariant) {
            if (is_null($this->parent) === true) {
                if (is_a($oVariant, SimpleVariant::class) === true) {
                    $this->parent = $oVariant->getParent();
                } else {
                    $this->parent = $oVariant->getParentArticle();
                }

                $this->variantExtensions = $this->parent->getVariantExtension();
            }

            break;
        }

        return parent::fillVariantSelections($oVariantList, $iVarSelCnt, $aFilter, $sActVariantId);
    }
}