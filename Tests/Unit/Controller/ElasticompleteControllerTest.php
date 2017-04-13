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

namespace TeamNeustaGmbH\M2T3\Elements\Tests\Unit\Controller;

use Prophecy\Argument;
use TeamNeustaGmbH\M2T3\Elements\Controller\ElasticompleteController;
use TeamNeustaGmbH\M2T3\Elements\Service\ElasticContentService;

/**
 * Class ElasticompleteControllerTest
 *
 * @backupGlobals
 * @package TeamNeustaGmbH\M2T3\Elements\Tests\Unit\Controller
 */
class ElasticompleteControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * controller
     *
     * @var ElasticompleteController
     */
    protected $controller;

    /**
     * elasticService
     *
     * @var ElasticContentService | \Prophecy\Prophecy\ObjectProphecy
     */
    protected $elasticService;

    /**
     * ajaxHandler
     *
     * @var \TYPO3\CMS\Core\Http\AjaxRequestHandler | \Prophecy\Prophecy\ObjectProphecy
     */
    protected $ajaxHandler;

    /**
     * request
     *
     * @var \TYPO3\CMS\Core\Http\ServerRequest | \Prophecy\Prophecy\ObjectProphecy
     */
    protected $request;

    /**
     * fixture
     *
     * @var array
     */
    protected $fixture = [
        14 =>
            [
                'id'   => '14',
                'name' => 'Push It Messenger Bag',
                'sku'  => '24-WB04',
            ],
        8  =>
            [
                'id'   => '8',
                'name' => 'Voyage Yoga Bag',
                'sku'  => '24-WB01',
            ],
        4  =>
            [
                'id'   => '4',
                'name' => 'Wayfarer Messenger Bag',
                'sku'  => '24-MB05',
            ],
        1  =>
            [
                'id'   => '1',
                'name' => 'Joust Duffle Bag',
                'sku'  => '24-MB01',
            ],
    ];

    /**
     * renderAjaxShouldAddJsonDataToContentIfElementsAreFound
     *
     * @test
     * @return void
     */
    public function renderAjaxShouldAddJsonDataToContentIfElementsAreFound()
    {
        $ajaxHandler = $this->ajaxHandler->reveal();
        $this->elasticService->findContentElements(
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('string')
        )->willReturn($this->fixture);

        $this->controller->renderAjax(['request' => $this->request->reveal()], $ajaxHandler);
        $this->ajaxHandler->addContent('items', json_encode(array_values($this->fixture)))->shouldBeCalled();
    }

    /**
     * renderAjaxShouldCallFindContenElements
     *
     * @test
     * @return void
     */
    public function renderAjaxShouldCallFindContenElements()
    {
        $ajaxHandler = $this->ajaxHandler->reveal();
        $this->controller->renderAjax(['request' => $this->request->reveal()], $ajaxHandler);
        $this->elasticService->findContentElements(
            'foo',
            'm2t3',
            'm2t3_type'
        )->shouldBeCalled();
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        $this->controller = new ElasticompleteController();
        $this->elasticService = $this->prophesize(ElasticContentService::class);
        $this->controller->injectElasticContentService($this->elasticService->reveal());
        $this->ajaxHandler = $this->prophesize(\TYPO3\CMS\Core\Http\AjaxRequestHandler::class);
        $this->request = $this->prophesize(\TYPO3\CMS\Core\Http\ServerRequest::class);
        $this->request->getQueryParams()->willReturn(
            [
                'query' => 'foo'
            ]
        );
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_elements']['magento_product_elastic']['index'] = 'm2t3';
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_elements']['magento_product_elastic']['type'] = 'm2t3_type';
    }
}