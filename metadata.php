<?php

/**
 * Cache-Optimization for OXID eShop
 *
 * @link      https://github.com/maximilian-walter/oxid-cache
 * @copyright Copyright (c) 2014 Maximilian Walter
 * @license   http://opensource.org/licenses/MIT MIT
 */

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'cache',
    'title'       => 'Cache',
    'description' => array(
        'en' => 'This module enables HTTP-Caching for configured controllers',
        'de' => 'Das Modul aktiviert HTTP-Caching für die konfigurierten Controller',
    ),
    'version'     => '1.0.0',
    'author'      => 'Maximilian Walter',
    'url'         => 'http://max-walter.net/',
    'email'       => 'github@max-walter.net',
    'extend'      => array(
        'oxoutput' => 'mw/cache/core/mwcacheoxoutput',
    ),
    'settings'    => array(
        array('group' => 'mw_cache', 'name' => 'aMwCacheCacheableControllers', 'position' => 1, 'type' => 'aarr', 'value' => array(
            'info'       => '3600',
            'start'      => '3600',
            'details'    => '3600',
            'alist'      => '3600',
            'vendorlist' => '3600',
        )),
    ),
);