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

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'content-m2t3-single',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:m2t3_elements/Resources/Public/Icons/ContentElements/magento-icon.svg']
);

$GLOBALS['TCA']['pages']['types'][(string)116] = $GLOBALS['TCA']['pages']['types'][(string)\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_LINK];

call_user_func(
    function ($extKey) {
        $magentoCategoryDoktype = 116;

        // Add new page type:
        $GLOBALS['PAGES_TYPES'][$magentoCategoryDoktype] = [
            'type' => 'web',
            'allowedTables' => '*',
        ];

        // Provide icon for page tree, list view, ... :
        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class)
            ->registerIcon(
                'apps-pagetree-magento-category',
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/ContentElements/magento-icon.svg',
                ]
            );

        // Allow backend users to drag and drop the new page type:
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
            'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $magentoCategoryDoktype . ')'
        );
    },
    'm2t3_elements'
);

// Register URL handler for external pages.
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['urlProcessing']['urlHandlers']['frontendExternalUrl'] = [
    'handler' => \TeamNeustaGmbH\M2T3\Elements\Page\ExternalPageUrlHandler::class,
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler (
    'ElasticompleteController::renderItems',
    \TeamNeustaGmbH\M2T3\Elements\Controller\ElasticompleteController::class.'->renderAjax'
);
