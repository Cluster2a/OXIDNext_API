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

namespace ITSOUP\AjaxSearch\Application\Model;


class Search extends Search_parent
{
    /**
     * Returns a list of articles according to search parameters. Returns matched
     *
     * @param string $sSearchParamForQuery query parameter
     * @param string $sInitialSearchCat initial category to seearch in
     * @param string $sInitialSearchVendor initial vendor to seearch for
     * @param string $sInitialSearchManufacturer initial Manufacturer to seearch for
     * @param string $sSortBy sort by
     *
     * @return oxarticlelist
     */
    public function itsGetSearchArticles($sSearchParamForQuery = false, $sInitialSearchCat = false, $sInitialSearchVendor = false, $sInitialSearchManufacturer = false, $sSortBy = false, $iItemAmount = 10)
    {
        $oArtList = oxNew('oxarticlelist');
        $oArtList->setSqlLimit(0, $iItemAmount);

        $sSelect = $this->getSearchSelect($sSearchParamForQuery, $sInitialSearchCat, $sInitialSearchVendor, $sInitialSearchManufacturer, $sSortBy);
        if ($sSelect) {
            $oArtList->selectString($sSelect);
        }

        return $oArtList;
    }
}