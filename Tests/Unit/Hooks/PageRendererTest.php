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

use \TeamNeustaGmbH\M2T3\Elements\Hooks\PageRenderer;

/**
 * Class PageRendererTest
 *
 * @backupGlobals
 * @package TeamNeustaGmbH\M2T3\Elements\Tests\Unit\Hooks
 */
class PageRendererTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * pageRenderer
     *
     * @var \TYPO3\CMS\Core\Page\PageRenderer
     */
    protected $pageRendererCore;

    /**
     * pageRendererHook
     *
     * @var \TeamNeustaGmbH\M2T3\Elements\Hooks\PageRenderer
     */
    protected $pageRendererHook;

    protected function setUp()
    {
        $this->pageRendererCore = $this->prophesize(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $this->pageRendererHook = new PageRenderer();
        $GLOBALS['TSFE'] = new \stdClass();
        $GLOBALS['TSFE']->no_cache = true;
    }

    public function preHeaderRenderHookShouldCallSetTemplateFileDataProvider()
    {
        return [
            'cssHeader' => [
                'pageInformation' => 'CssHeader',
                'expectedFilename' => 'EXT:m2t3_elements/Resources/Private/Templates/General/OnlyCssHeader.html'
            ],
            'JsHeader' => [
                'pageInformation' => 'JsHeader',
                'expectedFilename' => 'EXT:m2t3_elements/Resources/Private/Templates/General/OnlyJsHeader.html'
            ],
            'JsFooter' => [
                'pageInformation' => 'JsFooter',
                'expectedFilename' => 'EXT:m2t3_elements/Resources/Private/Templates/General/OnlyJsFooter.html'
            ]
        ];
    }

    /**
     * preHeaderRenderHookShouldCallSetTemplateFile
     *
     * @test
     * @dataProvider preHeaderRenderHookShouldCallSetTemplateFileDataProvider
     * @param string $pageInformation
     * @param string $expectedFilename
     * @return void
     */
    public function preHeaderRenderHookShouldCallSetTemplateFile(string $pageInformation, string $expectedFilename)
    {
        $_GET['pageInformation'] = $pageInformation;
        $this->pageRendererHook->preHeaderRenderHook([], $this->pageRendererCore->reveal());

        $this->pageRendererCore->setTemplateFile($expectedFilename)->shouldBeCalled();
    }

}