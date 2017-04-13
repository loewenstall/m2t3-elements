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

use Prophecy\Prophecy\ObjectProphecy;
use TeamNeustaGmbH\M2T3\Elements\Hooks\TypoLink;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Page\PageRepository;

class TypoLinkTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * typoScriptFrontendController
     *
     * @var TypoScriptFrontendController | ObjectProphecy
     */
    protected $typoScriptFrontendController;

    /**
     * typoLinkHook
     *
     * @var TypoLink
     */
    protected $typoLinkHook;

    /**
     * pageRepository
     *
     * @var PageRepository | ObjectProphecy
     */
    protected $pageRepository;

    /**
     * contentObjectRenderer
     *
     * @var ContentObjectRenderer | ObjectProphecy
     */
    protected $contentObjectRenderer;

    /**
     * encodeUrlShouldModifyTotalUrlFromPageUrl
     *
     * @test
     * @return void
     */
    public function encodeUrlShouldModifyTotalUrlFromPageUrl()
    {
        $encoderParameters = [
            'LD'   => [
                'totalURL' => 'some/typo3/url'
            ],
            'args' => [
                'page' => [
                    'doktype' => 116,
                    'url'     => 'original/url/to/magento',
                ]
            ]
        ];

        $this->typoLinkHook->encodeUrl($encoderParameters);
        $this->assertEquals(
            [
                'LD'   => [
                    'totalURL' => 'original/url/to/magento'
                ],
                'args' => [
                    'page' => [
                        'doktype' => 116,
                        'url'     => 'original/url/to/magento',
                    ]
                ]
            ],
            $encoderParameters
        );
    }

    /**
     * postProcShouldAddMagentoUrl
     *
     * @test
     * @return void
     */
    public function postProcShouldAddMagentoUrl()
    {
        $parameters = [
            'conf'          => [
                'parameter' => 1
            ],
            'finalTag'      => '<a href="some/typo3/url"></a>',
            'finalTagParts' => [
                'url' => 'some/typo3/url'
            ],
        ];
        $page = [
            'doktype' => 116,
            'url'     => 'original/url/to/magento',
        ];
        $this->pageRepository->getPage(1)->shouldBeCalled()->willReturn($page);
        $contentRenderer = $this->contentObjectRenderer->reveal();
        $this->typoLinkHook->postProc($parameters, $contentRenderer);

        $this->assertEquals(
            [
                'conf'          => [
                    'parameter' => 1
                ],
                'finalTag'      => '<a href="original/url/to/magento"></a>',
                'finalTagParts' => [
                    'url'        => 'original/url/to/magento',
                    'magentoUrl' => 'original/url/to/magento'
                ],
            ],
            $parameters
        );
    }

    protected function setUp()
    {
        $this->typoScriptFrontendController = $this->prophesize(TypoScriptFrontendController::class);
        $this->pageRepository = $this->prophesize(PageRepository::class);
        $this->contentObjectRenderer = $this->prophesize(ContentObjectRenderer::class);
        $this->typoScriptFrontendController->sys_page = $this->pageRepository->reveal();

        $this->typoLinkHook = new TypoLink();
        $this->typoLinkHook->injectTypoScriptFrontendController($this->typoScriptFrontendController->reveal());
    }
}