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

/**
 * Metadata version
 */

use OxidEsales\Eshop\Application\Controller\Admin\ArticleVariant;

$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = [
    'id' => 'na/variantextension',
    'title' => 'netAdvising variant extension',
    'description' => '',
    'thumbnail' => '/out/pictures/logo.png',
    'version' => '0.0.1',
    'author' => 'NetAdvising',
    'url' => '',
    'email' => '',
    'extend' => [
        ArticleVariant::class => \NetAdvising\VariantExtension\Application\Controller\Admin\ArticleVariant::class,
        \OxidEsales\Eshop\Application\Model\Article::class => \NetAdvising\VariantExtension\Application\Model\Article::class,
    ],
    'controllers' => [],
    'templates' => [],
    'blocks' => [
        [
            'template' => 'article_variant.tpl',
            'block' => 'admin_article_variant_bottom_extended',
            'file' => 'Application/views/admin/tpl/admin_article_variant_bottom_extended.tpl'
        ]
    ],
    'settings' => [],
];
