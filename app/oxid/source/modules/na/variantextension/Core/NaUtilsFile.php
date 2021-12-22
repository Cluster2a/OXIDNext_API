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

namespace NetAdvising\VariantExtension\Core;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsFile;

class NaUtilsFile extends UtilsFile
{
    public function __construct()
    {
        parent::__construct();
        $this->_aTypeToPath['NA_VARINAT_IMAGES'] = 'master/na_variantImages';
    }

    public function uniqueImageName($sValue, $sType, $blDemo, $sImagePath, $blUnique = true):string {
        return $this->prepareImageName($sValue, $sType, $blDemo, $sImagePath, $blUnique = true);
    }

    /**
     * Returns image storage path
     *
     * @param string $sType image type
     *
     * @return string
     */
    public function getImagePath($sType): string
    {
        $sFolder = array_key_exists($sType, $this->_aTypeToPath) ? $this->_aTypeToPath[$sType] : '0';

        return $this->normalizeDir(Registry::getConfig()->getPictureDir(false)) . "{$sFolder}/";
    }
}