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


use TeamNeustaGmbH\M2T3\Elements\Service\ElasticContentService;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;

class DrawBackendItem implements PageLayoutViewDrawItemHookInterface
{

    /**
     * elasticContentService
     *
     * @var \TeamNeustaGmbH\M2T3\Elements\Service\ElasticContentService
     */
    protected $elasticContentService;

    /**
     * DrawBackendItem constructor.
     */
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
     * Preprocesses the preview rendering of a content element.
     *
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject Calling parent object
     * @param bool $drawItem Whether to draw the item using the default functionalities
     * @param string $headerContent Header content
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     * @return void
     */
    public function preProcess(
        \TYPO3\CMS\Backend\View\PageLayoutView &$parentObject,
        &$drawItem,
        &$headerContent,
        &$itemContent,
        array &$row
    ) {
        if (strpos($row['CType'], 'm2t3elements') !== false) {
            $filtered = array_filter(
                $row,
                function ($value, $key) {
                    return (strpos($key, 'm2t3elements') !== false && !empty($value));
                },
                ARRAY_FILTER_USE_BOTH
            );
            $contentShopId = current($filtered);
            if ($contentShopId) {
                $element = $this->elasticContentService->findContentElements(
                    $contentShopId,
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_elements']['magento_product_elastic']['index'],
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_elements']['magento_product_elastic']['type']
                );
                if (!empty($element)) {
                    $element = current($element);
                    $drawItem = false;
                    $headerContent = '<strong>'.$element['name'].'</strong><br />';
                    $itemContent = $element['sku'];
                }
            }
        }
    }
}