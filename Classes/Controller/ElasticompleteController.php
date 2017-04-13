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

declare(strict_types=1);

namespace TeamNeustaGmbH\M2T3\Elements\Controller;

use TeamNeustaGmbH\M2T3\Elements\Service\ElasticContentService;

class ElasticompleteController
{
    /**
     * elasticContentService
     *
     * @var \TeamNeustaGmbH\M2T3\Elements\Service\ElasticContentService
     */
    protected $elasticContentService;

    public function __construct()
    {
        $this->injectElasticContentService(new ElasticContentService());
    }

    /**
     * injectElasticContentService
     *
     * @param \TeamNeustaGmbH\M2T3\Elements\Service\ElasticContentService $elasticContentService
     * @return void
     */
    public function injectElasticContentService(
        \TeamNeustaGmbH\M2T3\Elements\Service\ElasticContentService $elasticContentService
    ) {
        $this->elasticContentService = $elasticContentService;
    }


    /**
     * Renders the menu so that it can be returned as response to an AJAX call
     *
     * @param array $params Array of parameters from the AJAX interface, currently unused
     * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
     * @return void
     */
    public function renderAjax($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) {
        /** @var \TYPO3\CMS\Core\Http\ServerRequest $request */
        $request = $params['request'];
        $queryParams = $request->getQueryParams();
        $queryString = $queryParams['query'] ?: $queryParams['id'];

        $elements = $this->elasticContentService->findContentElements(
            $queryString,
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_elements']['magento_product_elastic']['index'],
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_elements']['magento_product_elastic']['type']
        );

        if (!empty($elements) && is_array($elements)) {
            $ajaxObj->addContent('items', json_encode(array_values($elements)));
        }
    }
}