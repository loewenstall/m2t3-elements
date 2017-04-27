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

use TeamNeustaGmbH\M2T3\Elements\Service\SuggestWizardShopItemReceiver;

$tempColumns = [
    'tx_m2t3elements_item_id' =>
        [
            'config'  =>
                [
                    'type'                             => 'text',
                    'renderType' => 'elasticomplete',
                    'format' => 'html',
                    'rows' => 42,
                ],
            'exclude' => '1',
            'label'   => 'LLL:EXT:m2t3_elements/Resources/Private/Language/locallang_db.xlf:tt_content.tx_m2t3elements_item_id',
        ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:m2t3_elements/Resources/Private/Language/locallang_db.xlf:tt_content.CType.div._m2t3elements_',
    '--div--',
];
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:m2t3_elements/Resources/Private/Language/locallang_db.xlf:tt_content.CType.m2t3elements_shop_item',
    'm2t3elements_shop_item',
    'content-m2t3-single'
];
$tempTypes = [
    'm2t3elements_shop_item' =>
        [
            'columnsOverrides' =>
                [
                    'bodytext' =>
                        [
                            'defaultExtras' => 'richtext:rte_transform[mode=ts_css]',
                        ],
                ],
            'showitem'         => '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,tx_m2t3elements_item_id,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended,--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,categories',
        ],
];
$GLOBALS['TCA']['tt_content']['types'] += $tempTypes;
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['m2t3elements_shop_item'] = 'content-m2t3-single';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'm2t3_elements',
    'Configuration/TypoScript/',
    'm2t3_elements'
);
