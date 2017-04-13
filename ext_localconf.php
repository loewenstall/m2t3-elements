<?php
/**
 * This file is part of the TeamNeustaGmbH/m2t3 package.
 *
 * Copyright (c) 2017 neusta GmbH | Ein team neusta Unternehmen
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @license https://opensource.org/licenses/BSD-3-Clause  BSD-3-Clause License
 */

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:m2t3_elements/Configuration/PageTSconfig/NewContentElementWizard.ts">'
);

// m2t3_elements
if (empty($TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['magento_product_elastic'])) {
    $TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY] = [
        'magento_product_elastic' => [
            'index'        => '',
            'type' => ''
        ]
    ];
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY] = \TeamNeustaGmbH\M2T3\Elements\Hooks\DrawBackendItem::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$_EXTKEY] = \TeamNeustaGmbH\M2T3\Elements\Hooks\PageRenderer::class.'->preHeaderRenderHook';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['typoLink_PostProc'][$_EXTKEY] = \TeamNeustaGmbH\M2T3\Elements\Hooks\TypoLink::class.'->postProc';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tstemplate.php']['linkData-PostProc'][$_EXTKEY] = \TeamNeustaGmbH\M2T3\Elements\Hooks\TypoLink::class.'->encodeUrl';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1485713216] = array(
    'nodeName' => 'elasticomplete',
    'priority' => 50,
    'class' => \TeamNeustaGmbH\M2T3\Elements\Form\Element\ElasticompleteElement::class,
);