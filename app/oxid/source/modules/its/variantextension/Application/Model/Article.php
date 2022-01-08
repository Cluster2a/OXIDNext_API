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
 * Article extension
 */
class Article extends Article_parent
{
    /**
     * @return string
     */
    public function getVariantExtensionJSON(): string
    {
        return json_encode($this->getVariantExtension());
    }

    /**
     * @return array
     */
    public function getVariantExtension(): array
    {
        $variantExtension = $this->oxarticles__na_variantextension->rawValue;
        return is_null($variantExtension) !== true ? unserialize($variantExtension) : [];
    }
}