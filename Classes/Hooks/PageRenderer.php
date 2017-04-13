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

declare(strict_types = 1);

namespace TeamNeustaGmbH\M2T3\Elements\Hooks;

class PageRenderer
{
    /**
     * preHeaderRenderHook
     *
     * @param $args
     * @param \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer
     * @return void
     */
    public function preHeaderRenderHook($args, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer)
    {
        if (!empty($_GET['pageInformation']) && $GLOBALS["TSFE"]->no_cache) {
            $filename = '';
            $template = 'EXT:m2t3_elements/Resources/Private/Templates/General/';
            switch ($_GET['pageInformation']) {
                case 'CssHeader':
                    $filename = 'OnlyCssHeader.html';
                    break;
                case 'JsHeader':
                    $filename = 'OnlyJsHeader.html';
                    break;
                case 'JsFooter':
                    $filename = 'OnlyJsFooter.html';
                    break;
            }
            if ($filename) {
                $pageRenderer->setTemplateFile($template.$filename);
            }
        }
    }
}