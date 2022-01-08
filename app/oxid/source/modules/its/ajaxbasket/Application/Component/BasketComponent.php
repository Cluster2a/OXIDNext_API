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

namespace ITSOUP\AjaxBasket\Application\Component;

use OxidEsales\Eshop\Application\Component\Widget\ArticleDetails;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;
use Psr\Log\LoggerInterface;
use stdClass;

class BasketComponent extends BasketComponent_parent
{
    /**
     * template for added Item (modal)
     *
     * @var string
     */
    protected $_itemAddedToBasketTemplate = "its_item_added_to_basket_modal.tpl";

    /**
     * template for added Item (minibasket)
     *
     * @var string
     */
    protected $_itemAddedToBasketMinibasketTemplate = "its_item_added_to_basket_minibasket.tpl";

    /**
     * Basket content update controller.
     * Before adding article - check if client is not a search engine. If
     * yes - exits method by returning false. If no - executes
     * oxcmp_basket::_addItems() and puts article to basket.
     * Returns position where to redirect user browser.
     *
     * @param string $sProductId Product ID (default null)
     * @param double $dAmount    Product amount (default null)
     * @param array  $aSel       (default null)
     * @param array  $aPersParam (default null)
     * @param bool   $blOverride If true amount in basket is replaced by $dAmount otherwise amount is increased by
     *                           $dAmount (default false)
     *
     * @return mixed
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    public function toBasket($sProductId = null, $dAmount = null, $aSel = null, $aPersParam = null, $blOverride = false)
    {
        if (
            Registry::getSession()->getId() &&
            Registry::getSession()->isActualSidInCookie() &&
            !Registry::getSession()->checkSessionChallenge()
        ) {
            $this->getContainer()->get(LoggerInterface::class)->warning('EXCEPTION_NON_MATCHING_CSRF_TOKEN');
            Registry::getUtilsView()->addErrorToDisplay('ERROR_MESSAGE_NON_MATCHING_CSRF_TOKEN');
            return;
        }

        // adding to basket is not allowed ?
        $myConfig = \OxidEsales\Eshop\Core\Registry::getConfig();
        if (\OxidEsales\Eshop\Core\Registry::getUtils()->isSearchEngine()) {
            return;
        }

        // adding articles
        if ($aProducts = $this->getItems($sProductId, $dAmount, $aSel, $aPersParam, $blOverride)) {
            $this->setLastCallFnc('tobasket');

            $database = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
            $database->startTransaction();
            try {
                $oBasketItem = $this->addItems($aProducts);
                //reserve active basket
                if (Registry::getConfig()->getConfigParam('blPsBasketReservationEnabled')) {
                    $basket = Registry::getSession()->getBasket();
                    Registry::getSession()->getBasketReservations()->reserveBasket($basket);
                }
            } catch (\Exception $exception) {
                $database->rollbackTransaction();
                unset($oBasketItem);
                throw $exception;
            }
            $database->commitTransaction();

            // new basket item marker
            if ($oBasketItem && $myConfig->getConfigParam('iNewBasketItemMessage') != 0) {
                $oNewItem = new stdClass();
                $oNewItem->sTitle = $oBasketItem->getTitle();
                $oNewItem->sId = $oBasketItem->getProductId();
                $oNewItem->dAmount = $oBasketItem->getAmount();
                $oNewItem->dBundledAmount = $oBasketItem->getdBundledAmount();

                // passing article
                Registry::getSession()->setVariable('_newitem', $oNewItem);
            }

            // redirect to basket
            $redirectUrl = $this->getRedirectUrl();
            $this->dispatchEvent(new \OxidEsales\EshopCommunity\Internal\Transition\ShopEvents\BasketChangedEvent($this));

            // nA - AjaxBasket - AH - 2019/05/25 -> BEGIN
            $sItemId = key($aProducts);
            $this->sendAjaxResponse($sItemId);
            // nA - AjaxBasket - AH - 2019/05/25 <- END

            return $redirectUrl;
        }
    }

    /**
     * Sends Ajax-Response for addToBasket
     *
     * @param string $sItemId Product ID
     */
    protected function sendAjaxResponse(string $sItemId): void
    {
        $isAjax = (boolean) Registry::getRequest()->getRequestParameter('doAjax');

        if($isAjax === true) {
            $oSmarty = Registry::getUtilsView()->getSmarty();

            $oArticle = oxNew(Article::class);

            $oArticle->load($sItemId);
            $oSmarty->assign("oDetailsProduct", $oArticle);

            $oxwArticleDetails = oxNew(ArticleDetails::class);
            $oSmarty->assign("oxwArticleDetails", $oxwArticleDetails);

            $htmlContentModal = "";
            if ($oSmarty->template_exists($this->_itemAddedToBasketTemplate)) {
                $htmlContentModal = $oSmarty->fetch($this->_itemAddedToBasketTemplate);
            }

            $basket = Registry::getSession()->getBasket();
            $basket->calculateBasket();
            //take params
            $iBasketItemsAmount = $basket->getItemsCount();

            $oSmarty->assign("oxcmp_basket", $basket);

            $oxViewConfig = oxNew(ViewConfig::class);
            $oSmarty->assign("oViewConf", $oxViewConfig);
            $oSmarty->assign("oView", $oxViewConfig);

            $htmlContentMiniBasket = "";
            if ($oSmarty->template_exists($this->_itemAddedToBasketMinibasketTemplate)) {
                $htmlContentMiniBasket = $oSmarty->fetch($this->_itemAddedToBasketMinibasketTemplate);
            }

            Registry::getUtils()->showMessageAndExit(
                json_encode(
                    array(
                        "success"               => true,
                        "contentModal"          => $htmlContentModal,
                        "itemAmount"            => $iBasketItemsAmount,
                        "contentMiniBasket"     => $htmlContentMiniBasket
                    )
                )
            );
        }
    }
}