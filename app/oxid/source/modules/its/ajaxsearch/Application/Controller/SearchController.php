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

namespace ITSOUP\AjaxSearch\Application\Controller;

use OxidEsales\Eshop\Core\Registry;

class SearchController extends SearchController_parent
{
    /**
     * Smarty instance
     *
     * @var smarty
     */
    protected $_oSmarty = null;

    protected $_aArticleList = null;
    protected $_iAllArtCnt = 0;
    protected $_sAjaxSearchTemplate = "its_ajaxsearch.tpl";


    /**
     * Smarty instance getter, assigns this oxEmail instance to "oEmailView" variable
     *
     * @return smarty
     */
    protected function _getSmarty()
    {
        if ($this->_oSmarty === null) {
            $this->_oSmarty = Registry::get("oxUtilsView")->getSmarty();
        }

        //setting default view
        $this->_oSmarty->assign("oView", $this);

        return $this->_oSmarty;
    }

    public function getAjaxSearchDisabled()
    {
        $oConfig = Registry::getConfig();
        return $oConfig->getConfigParam('bl_NaMod_disableSearch');
    }


    /**
     * Forms search navigation URLs, executes parent::render() and
     * returns name of template to render search::_sThisTemplate.
     *
     * @return  string  current template file name
     */
    public function render()
    {
        // nA - Modenizer - AH - 2017/10/31 -> BEGIN
        $this->ajaxSearch();
        // nA - Modenizer - AH - 2017/10/31 <- END

        parent::render();

        $oConfig = \OxidEsales\Eshop\Core\Registry::getConfig();
        if ($oConfig->getConfigParam('bl_rssSearch')) {
            $oRss = oxNew(\OxidEsales\Eshop\Application\Model\RssFeed::class);
            $sSearch = Registry::getRequest()->getRequestParameter('searchparam');
            $sCnid = Registry::getRequest()->getRequestParameter('searchcnid');
            $sVendor = Registry::getRequest()->getRequestParameter('searchvendor');
            $sManufacturer = Registry::getRequest()->getRequestParameter('searchmanufacturer');
            $sSearchArticlesTitle = $oRss->getSearchArticlesTitle($sSearch, $sCnid, $sVendor, $sManufacturer);
            $sSearchArticlesUrl = $oRss->getSearchArticlesUrl($sSearch, $sCnid, $sVendor, $sManufacturer);
            $this->addRssFeed($sSearchArticlesTitle, $sSearchArticlesUrl, 'searchArticles');
        }

        // processing list articles
        $this->processListArticles();

        return $this->_sThisTemplate;
    }


    public function ajaxSearch()
    {
        $oConfig = $this->getConfig();

        $bAjax = (bool)Registry::getRequest()->getRequestParameter('doAjax', true);
        if ($bAjax == true) {
            $sSearchParamForQuery = trim(Registry::getRequest()->getRequestParameter('searchparam', true));

            $oxUBase = oxNew('oxUBase');
            // searching ..
            /** @var oxSearch $oSearchHandler */
            $oSearchHandler = oxNew('oxsearch');

            $iAmountResults = $oConfig->getConfigParam('naAmountSearchResults');
            if (is_numeric($iAmountResults) && $iAmountResults > 0)
                $iAmountResults = $iAmountResults;
            else
                $iAmountResults = 10;

            $oSearchList = $oSearchHandler->itsGetSearchArticles(
                $sSearchParamForQuery,
                null,
                null,
                null,
                $oxUBase->getSortingSql($oxUBase->getSortIdent()),
                $iAmountResults
            );

            // list of found articles
            $this->_aArticleList = $oSearchList;
            $this->_iAllArtCnt = 0;

            // skip count calculation if no articles in list found
            if ($oSearchList->count()) {
                $this->_iAllArtCnt = $oSearchHandler->getSearchArticleCount(
                    $sSearchParamForQuery,
                    null,
                    null,
                    null
                );
            }


            $oSmarty = $this->_getSmarty();
            $oxViewConfig = oxNew('oxViewConfig');
            $oSmarty->assign("oViewConf", $oxViewConfig);
            $oSmarty->assign("oSearchList", $oSearchList);

            if ($this->_iAllArtCnt > $iAmountResults) {
                $oSmarty->assign("bShowMoreButton", true);
                $oSmarty->assign("bMoreButtonURL", $oConfig->getShopHomeURL() . 'cl=search&searchparam=' . $sSearchParamForQuery);

            }

            if ($oSmarty->template_exists($this->_sAjaxSearchTemplate)) {
                $sHtmlContentAjaxSearch = $oSmarty->fetch($this->_sAjaxSearchTemplate);
            }

            Registry::getUtils()->showMessageAndExit(
                json_encode(
                    array(
                        "success" => true,
                        "html" => $sHtmlContentAjaxSearch,
                        "itemcount" => $oSearchList->count(),
                        "totalresults" => $this->_iAllArtCnt,
                    )
                )
            );
        }


    }
}