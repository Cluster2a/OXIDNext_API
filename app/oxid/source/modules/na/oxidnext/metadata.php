<?php

/**
 * This Software is the property of ESYON and is protected by copyright law - it is NOT Freeware.
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
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = [
    'id'          => 'na/oxidnext',
    'title'       => 'netAdvising OxidNext',
    'description' =>  '',
    'thumbnail'   => '/out/pictures/logo.png',
    'version'     => '0.0.1',
    'author'      => 'NetAdvising',
    'url'         => '',
    'email'       => '',
    'extend'      => [
        \OxidEsales\Eshop\Application\Model\Category::class => \NetAdvising\OxidNext\Application\Model\Category::class
    ],
    'controllers' => [],
    'templates'   => [],
    'blocks'      => [],
    'settings'    => [],
];
