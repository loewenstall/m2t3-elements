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

namespace TeamNeustaGmbH\M2T3\Elements\Tests\Unit\Page;


use Prophecy\Prophecy\ObjectProphecy;
use TeamNeustaGmbH\M2T3\Elements\Page\ExternalPageUrlHandler;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Class ExternalPageUrlHandlerTest
 *
 * @backupGlobals
 * @package TeamNeustaGmbH\M2T3\Elements\Tests\Unit\Page
 */
class ExternalPageUrlHandlerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * externalPageUrlHandler
     *
     * @var ExternalPageUrlHandler
     */
    protected $externalPageUrlHandler;

    /**
     * typoScriptFrontendController
     *
     * @var TypoScriptFrontendController | ObjectProphecy
     */
    protected $typoScriptFrontendController;

    /**
     * pageRepository
     *
     * @var PageRepository | ObjectProphecy
     */
    protected $pageRepository;

    /**
     * canHandleCurrentUrlReturnFalseIfDisablePageExternalUrlAreSet
     *
     * @test
     * @return void
     */
    public function canHandleCurrentUrlReturnFalseIfDisablePageExternalUrlAreSet()
    {
        $GLOBALS['TSFE']->config = [
            'config' => [
                'disablePageExternalUrl' => true
            ]
        ];
        $this->assertFalse($this->externalPageUrlHandler->canHandleCurrentUrl());
    }

    /**
     * canHandleCurrentUrlReturnFalseIfNoExternalUrlAreReturned
     *
     * @test
     * @return void
     */
    public function canHandleCurrentUrlReturnFalseIfNoExternalUrlAreReturned()
    {
        $GLOBALS['TSFE']->page['doktype'] = 200;
        $this->pageRepository->getExtURL($GLOBALS['TSFE']->page)->shouldBeCalled()->willReturn();
        $this->assertFalse($this->externalPageUrlHandler->canHandleCurrentUrl());
    }

    /**
     * canHandleCurrentUrlReturnTrueIfExternalUrlAreSet
     *
     * @test
     * @return void
     */
    public function canHandleCurrentUrlReturnTrueIfExternalUrlAreSet()
    {
        $this->assertTrue($this->externalPageUrlHandler->canHandleCurrentUrl());
    }

    /**
     * canHandleCurrentUrlReturnTrueIfExternalUrlAreSet
     *
     * @test
     * @return void
     */
    public function canHandleCurrentUrlShouldSetExternalUrlToMagentoUrl()
    {
        $this->externalPageUrlHandler->canHandleCurrentUrl();
        $this->assertSame($GLOBALS['TSFE']->page['url'], $this->externalPageUrlHandler->getExternalUrl());

    }

    protected function setUp()
    {
        $this->externalPageUrlHandler = new ExternalPageUrlHandler();
        $this->typoScriptFrontendController = $this->prophesize(TypoScriptFrontendController::class);
        $this->pageRepository = $this->prophesize(PageRepository::class);
        $this->typoScriptFrontendController->sys_page = $this->pageRepository->reveal();
        $GLOBALS['TSFE'] = $this->typoScriptFrontendController->reveal();
        $GLOBALS['TSFE']->config = [
            'config' => [
                'disablePageExternalUrl' => false
            ]
        ];
        $GLOBALS['TSFE']->page = [
            'doktype' => 116,
            'url'     => 'some/magento/url'
        ];
    }

}