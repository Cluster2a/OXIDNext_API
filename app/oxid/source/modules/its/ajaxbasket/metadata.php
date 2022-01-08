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

/**
 * Metadata version
 */

use ITSOUP\AjaxBasket\Application\Component\BasketComponent;

$style = '<style>.its-img {display:none;} .listitemfloating .its-img {display: block; position: absolute; top: -5px; left: -8px; height: 20px; margin: 2px;} .listitemfloating span {padding-left: 15px;} </style>';

$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = [
    'id'          => 'its/ajaxbasket',
    'title'       => $style . '<span style="position: relative;"><img class="its-img" src="../out/modules/its/ajaxbasket/out/src/img/soup.png" alt="ITSOUP Ajax Warenkorb" title="ITSOUP Ajax Warenkorb">ITSOUP Ajax Warenkorb</span>',
    'description' => [
        'de' => 'Fügt Artikel via Ajax zum Warenkorb hinzu.',
        'en' => 'Add articles to basket via ajax.',
    ],
    'thumbnail'   => '/out/src/img/logo.png',
    'version' => '0.0.1',
    'author'      => 'ITSOUP',
    'url'         => 'https://www.itsoup.de',
    'email'       => 'info@itsoup.de',
    'extend'      => [
        \OxidEsales\Eshop\Application\Component\BasketComponent::class => BasketComponent::class,
    ],
    'controllers' => [],
    'templates'   => [
        'its_item_added_to_basket_modal.tpl'		=> 'Application/views/blocks/its_item_added_to_basket_modal.tpl',
        'its_item_added_to_basket_minibasket.tpl'	=> 'Application/views/blocks/its_item_added_to_basket_minibasket.tpl',
    ],
    'events'      => [],
    'blocks'      => [
        [
            'template'  => 'layout/base.tpl',
            'block'     => 'base_js',
            'file'      => 'Application/views/blocks/base_js.tpl'
        ],
        [
            'template'  => 'layout/footer.tpl',
            'block'     => 'footer_main',
            'file'      => 'Application/views/blocks/footer_main.tpl'
        ],
        [
            'template'  => 'page/details/inc/productmain.tpl',
            'block'     => 'details_productmain_tobasket',
            'file'      => 'Application/views/blocks/details_productmain_tobasket.tpl'
        ],
        [
            'template'  => 'widget/header/minibasket.tpl',
            'block'     => 'dd_layout_page_header_icon_menu_minibasket_button',
            'file'      => 'Application/views/blocks/dd_layout_page_header_icon_menu_minibasket_button.tpl'
        ],
        [
            'template'  => 'widget/product/listitem_grid.tpl',
            'block'     => 'widget_product_listitem_grid_tobasket',
            'file'      => 'Application/views/blocks/widget_product_listitem_grid_tobasket.tpl'
        ],
        [
            'template'  => 'widget/product/listitem_infogrid.tpl',
            'block'     => 'widget_product_listitem_infogrid_tobasket',
            'file'      => 'Application/views/blocks/widget_product_listitem_infogrid_tobasket.tpl'
        ],
        [
            'template'  => 'widget/product/listitem_line.tpl',
            'block'     => 'widget_product_listitem_line_tobasket',
            'file'      => 'Application/views/blocks/widget_product_listitem_line_tobasket.tpl'
        ],
    ],
    'settings'    => []
];
