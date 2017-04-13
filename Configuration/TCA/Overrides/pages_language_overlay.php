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

call_user_func(
    function ($extKey, $table) {
        $magentoCategoryDoktype = 116;

        // Add new page type as possible select item:
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            $table,
            'doktype',
            [
                'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang.xlf:magento_category_page_type',
                $magentoCategoryDoktype,
                'EXT:' . $extKey . 'Resources/Public/Icons/ContentElements/magento-icon.svg'
            ],
            '1',
            'after'
        );
    },
    'm2t3_elements',
    'pages_language_overlay'
);