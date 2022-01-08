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

use ITSOUP\VariantExtension\Application\Model\VariantHandler;
use OxidEsales\Eshop\Application\Controller\Admin\ArticleVariant;
use OxidEsales\Eshop\Application\Model\Selection;
use OxidEsales\Eshop\Application\Model\VariantSelectList;

$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = [
    'id' => 'its/variantextension',
    'title' => 'ITSOUP Varianten-Erweiterung',
    'description' => 'Dieses Modul erweitert Varianten um Farbcodes und Bilder.',
    'thumbnail' => '/out/src/img/logo.png',
    'version' => '0.0.1',
    'author' => 'ITSOUP',
    'url' => 'https://www.itsoup.de',
    'email' => 'info@itsoup.de',
    'extend' => [
        ArticleVariant::class => \ITSOUP\VariantExtension\Application\Controller\Admin\ArticleVariant::class,
        \OxidEsales\Eshop\Application\Model\Article::class => \ITSOUP\VariantExtension\Application\Model\Article::class,
        Selection::class => \ITSOUP\VariantExtension\Application\Model\Selection::class,
        VariantSelectList::class => \ITSOUP\VariantExtension\Application\Model\VariantSelectList::class,
        OxidEsales\Eshop\Application\Model\VariantHandler::class => VariantHandler::class,
    ],
    'controllers' => [],
    'templates' => [
        'variant_extension_selectbox.tpl' => 'Application/views/tpl/variant_extension_selectbox.tpl',
    ],
    'blocks' => [
        [
            'template' => 'article_variant.tpl',
            'block' => 'admin_article_variant_bottom_extended',
            'file' => 'Application/views/admin/tpl/admin_article_variant_bottom_extended.tpl'
        ],
        [
            'template' => 'page/details/inc/productmain.tpl',
            'block' => 'details_productmain_variantselections',
            'file' => 'Application/views/blocks/page/details/inc/details_productmain_variantselections.tpl'
        ]
    ],
    'settings' => [],
];
