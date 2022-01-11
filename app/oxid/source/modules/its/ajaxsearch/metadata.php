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

use ITSOUP\AjaxSearch\Application\Controller\SearchController;
use ITSOUP\AjaxSearch\Application\Model\Search;

$style = '<style>.its-img {display:none;} .listitemfloating .its-img {display: block; position: absolute; top: -5px; left: -8px; height: 20px; margin: 2px;} .listitemfloating span {padding-left: 15px;} </style>';

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = [
	'id'	=> 'its/ajaxsearch',
    'title'       => $style . '<span style="position: relative;"><img class="its-img" src="../out/modules/its/ajaxsearch/out/src/img/soup.png" alt="ITSOUP Ajax Suche" title="ITSOUP Ajax Suche">ITSOUP Ajax Suche</span>',
	'description' => [
		'de' => 'Realisiert die Suche via Ajax.',
		'en' => 'Realizes the search by Ajax.',
	],
    'thumbnail' => '/out/src/img/logo.png',
    'version'   => '0.0.1',
	'author'    => 'ITSOUP',
	'url'       => 'https://www.itsoup.de',
	'email'     => 'info@itsoup.de',
	'extend'    => [
        OxidEsales\Eshop\Application\Controller\SearchController::class => SearchController::class,
        \OxidEsales\Eshop\Application\Model\Search::class => Search::class
	],
	'blocks'      => [
		[
			'template' 	=> 'layout/base.tpl',
			'block' 	=> 'base_js',
			'file' 		=> 'Application/views/blocks/base_js.tpl'
		],
		[
			'template' 	=> 'layout/base.tpl',
			'block' 	=> 'base_style',
			'file' 		=> 'Application/views/blocks/base_css.tpl'
		],
		[
			'template' 	=> 'widget/header/search.tpl',
			'block' 	=> 'widget_header_search_form',
			'file' 		=> 'Application/views/blocks/its_ajax_search_container.tpl'
		],
		[
			'template' 	=> 'widget/header/search.tpl',
			'block' 	=> 'header_search_field',
			'file' 		=> 'Application/views/blocks/its_change_ajax_searchbox.tpl'
		],
	],
	'templates'   => [
		'its_ajaxsearch.tpl'	=> 'Application/views/frontend/tpl/its_ajaxsearch.tpl',
	],
	'settings'    => [
		[
			'group' => 'itsAjaxSearchGroup',
			'name' 	=> 'itsAmountSearchResults',
			'type' 	=> 'str', 
			'value' => '10'
		],
	]
];
