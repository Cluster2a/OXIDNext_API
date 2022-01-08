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

/**
 * VariantSelectList extension
 */
class VariantSelectList extends VariantSelectList_parent
{
    /**
     * @var bool
     */
    private bool $isEnriched = false;

    /**
     * Returns variant selection list label
     *
     * @return bool
     */
    public function isEnriched(): bool
    {
        return $this->isEnriched;
    }

    /**
     * Adds given variant info to current variant selection list
     *
     * @param string $sName      selection name
     * @param string $sValue     selection value
     * @param string $blDisabled selection state - disabled/enabled
     * @param string $blActive   selection state - active/inactive
     */
    public function addVariant(
        $sName,
        $sValue,
        $blDisabled,
        $blActive,
        $type = null,
        $colorCode = null,
        $image = null
    )
    {
        if(empty($colorCode) !== true || empty($image) !== true) {
            $this->isEnriched = true;
        }

        $sName = trim($sName);
        //#6053 Allow "0" as a valid value.
        if (!empty($sName) || $sName === '0') {
            $sKey = $sValue;

            // creating new
            if (!isset($this->_aList[$sKey])) {
                $this->_aList[$sKey] = oxNew(
                    \OxidEsales\Eshop\Application\Model\Selection::class,
                    $sName,
                    $sValue,
                    $blDisabled,
                    $blActive,
                    $type,
                    $colorCode,
                    $image
                );
            } else {
                // overriding states
                if ($this->_aList[$sKey]->isDisabled() && !$blDisabled) {
                    $this->_aList[$sKey]->setDisabled($blDisabled);
                }

                if (!$this->_aList[$sKey]->isActive() && $blActive) {
                    $this->_aList[$sKey]->setActiveState($blActive);
                }
            }

            // storing active selection
            if ($this->_aList[$sKey]->isActive()) {
                $this->_oActiveSelection = $this->_aList[$sKey];
            }
        }
    }
}