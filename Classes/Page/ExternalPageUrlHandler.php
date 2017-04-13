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

namespace TeamNeustaGmbH\M2T3\Elements\Page;

use TYPO3\CMS\Core\Utility\HttpUtility;

class ExternalPageUrlHandler extends \TYPO3\CMS\Frontend\Page\ExternalPageUrlHandler
{

    /**
     * Checks if external URLs are enabled and if the current page points to an external URL.
     *
     * @return bool
     */
    public function canHandleCurrentUrl(): bool
    {
        $tsfe = $this->getTypoScriptFrontendController();

        if (!empty($tsfe->config['config']['disablePageExternalUrl'])) {
            return false;
        }

        $this->externalUrl = $this->returnExternalUrl($tsfe->page, $tsfe);
        if (empty($this->externalUrl)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * getExternalUrl
     *
     * @return string
     */
    public function getExternalUrl(): string
    {
        return $this->externalUrl;
    }

    /**
     * getExternalUrl
     *
     * @param $pagerow
     * @return string
     */
    public function returnExternalUrl(array $pagerow, $tsfe): string
    {
        if ((int)$pagerow['doktype'] === 116) {
            return $pagerow['url'];
        }
        $extUrl = $tsfe->sys_page->getExtURL($pagerow);

        return empty($extUrl) || !is_string($extUrl) ? '' : $extUrl;
    }
}