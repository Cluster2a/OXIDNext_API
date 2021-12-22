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

namespace NetAdvising\VariantExtension\Application\Model;

use NetAdvising\VariantExtension\Core\NaUtilsFile;
use OxidEsales\Eshop\Core\Registry;

class Selection extends Selection_parent
{
    protected ?string $colorCode = null;

    protected ?string $image = null;

    protected ?string $type = null;

    /**
     * Initializes oxSelection object
     *
     * @param string $sName      selection name
     * @param string $sValue     selection value
     * @param string $blDisabled selection state - disabled/enabled
     * @param string $blActive   selection state - active/inactive
     */
    public function __construct(
        $sName,
        $sValue,
        $blDisabled,
        $blActive,
        $type = null,
        $colorCode = null,
        $image = null
    )
    {
        $this->_sName = $sName;
        $this->_sValue = $sValue;
        $this->_blDisabled = $blDisabled;
        $this->_blActive = $blActive;
        $this->type = $type;
        $this->colorCode = $colorCode;
        $this->image = $image;

        if(empty($image) !== true) {
            $utilsFile = oxNew(NaUtilsFile::class);
            $imagePath = $utilsFile->getImagePathRaw('NA_VARINAT_IMAGES');
            $oConfig = Registry::getConfig();

            $this->image = $oConfig->getPictureUrl($imagePath . DIRECTORY_SEPARATOR . $image);
        }
    }

    public function getColorCode()
    {
        return $this->colorCode;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getType()
    {
        return $this->type;
    }
}