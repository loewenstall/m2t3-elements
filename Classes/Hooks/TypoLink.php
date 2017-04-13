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

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class TypoLink
{
    /**
     * typoScriptFrontendController
     *
     * @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected $typoScriptFrontendController;

    /**
     * Entry point for the URL encoder.
     *
     * @param array $encoderParameters
     * @return void
     */
    public function encodeUrl(array &$encoderParameters)
    {
        $page = $encoderParameters['args']['page'];
        if ($page['doktype'] === 116 && !empty($page['url'])) {
            $encoderParameters['LD']['totalURL'] = $page['url'];
        }
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $this->typoScriptFrontendController ?: $GLOBALS['TSFE'];
    }

    /**
     * injectTypoScriptFrontendController
     *
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $typoScriptFrontendController
     * @return void
     */
    public function injectTypoScriptFrontendController(
        \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $typoScriptFrontendController
    ) {
        $this->typoScriptFrontendController = $typoScriptFrontendController;
    }

    /**
     * postProc
     *
     * @param array $parameters
     * @param \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $pObj
     * @return void
     */
    public function postProc(array &$parameters, ContentObjectRenderer &$pObj)
    {
        if (!empty($parameters['conf']['parameter']) && is_int($parameters['conf']['parameter'])) {
            $tsfe = $this->getTypoScriptFrontendController();
            $page = $tsfe->sys_page->getPage($parameters['conf']['parameter']);
            if ($page['doktype'] === 116 && !empty($page['url'])) {
                $originalUrl = $parameters['finalTagParts']['url'];

                $parameters['finalTag'] = str_replace($originalUrl, $page['url'], $parameters['finalTag']);
                $parameters['finalTagParts']['url'] = $page['url'];
                $parameters['finalTagParts']['magentoUrl'] = $page['url'];
            }
        }
    }
}