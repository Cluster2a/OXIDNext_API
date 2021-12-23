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

/**
 * article extension
 */
class Article extends Article_parent
{
    /**
     * @return string
     */
    public function getVariantExtensionJSON(): string
    {
        $variantExtension = $this->oxarticles__na_variantextension->rawValue;
        if(is_null($variantExtension) !== true) {
            $variantExtension = unserialize($variantExtension);
        } else {
            $variantExtension = [];
        }

        return json_encode($variantExtension);
    }

    /**
     * @return array
     */
    public function getVariantExtension(): array
    {
        $variantExtension = $this->oxarticles__na_variantextension->rawValue;
        if(is_null($variantExtension) !== true) {
            $variantExtension = unserialize($variantExtension);
        } else {
            $variantExtension = [];
        }

        return $variantExtension;
    }
}