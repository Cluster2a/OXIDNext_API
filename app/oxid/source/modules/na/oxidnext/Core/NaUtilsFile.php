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

namespace NetAdvising\OxidNext\Core;

use OxidEsales\Eshop\Core\Exception\ExceptionToDisplay;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsFile;
use OxidEsales\EshopCommunity\Internal\Framework\FileSystem\Bridge\MasterImageHandlerBridgeInterface;
use OxidEsales\Facts\Facts;
use Webmozart\PathUtil\Path;

class NaUtilsFile extends UtilsFile
{
    public function __construct()
    {
        parent::__construct();
        $this->_aTypeToPath['NA_SF_BANNER'] = 'master/category/na_sf_banner';
    }
}