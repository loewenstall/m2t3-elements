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

namespace TeamNeustaGmbH\M2T3\Elements\Tests\Unit\Hooks;


use TeamNeustaGmbH\M2T3\Elements\Hooks\DrawBackendItem;
use TeamNeustaGmbH\M2T3\Elements\Service\ElasticContentService;
use TYPO3\CMS\Backend\View\PageLayoutView;

/**
 * Class DrawBackendItemTest
 *
 * @package TeamNeustaGmbH\M2T3\Elements\Tests\Unit\Hooks
 */
class DrawBackendItemTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * drawBackendItem
     *
     * @var DrawBackendItem
     */
    protected $drawBackendItem;

    /**
     * elasticContentService
     *
     * @var ElasticContentService
     */
    protected $elasticContentService;

    /**
     * pageLayoutView
     *
     * @var PageLayoutView
     */
    protected $pageLayoutView;

    /**
     * shouldModifyHeaderAndItemContentTest
     *
     * @test
     * @return void
     */
    public function shouldModifyHeaderAndItemContentTest()
    {
        $pageLayout = $this->pageLayoutView->reveal();
        $drawItem = '';
        $headerContent = '';
        $itemContent = '';
        $row = [
            'CType'                => 'm2t3elements',
            'm2t3elements_id' => 55,
        ];

        $this->elasticContentService->findContentElements(55, 'typo3', 'content')->shouldBeCalled()->willReturn(
            [
                [
                    'name'     => 'content_title',
                    'sku' => 'content_bodytexts',
                ]
            ]
        );

        $this->drawBackendItem->preProcess($pageLayout, $drawItem, $headerContent, $itemContent, $row);

        $this->assertSame('<strong>content_title</strong><br />', $headerContent);
        $this->assertSame('content_bodytexts', $itemContent);
        $this->assertFalse($drawItem);
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_elements']['magento_product_elastic']['index'] = 'typo3';
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_elements']['magento_product_elastic']['type'] = 'content';
        $this->drawBackendItem = new DrawBackendItem();
        $this->elasticContentService = $this->prophesize(ElasticContentService::class);
        $this->pageLayoutView = $this->prophesize(PageLayoutView::class);
        $this->drawBackendItem->injectElasticContentService($this->elasticContentService->reveal());
    }
}