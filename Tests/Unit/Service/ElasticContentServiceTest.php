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

namespace TeamNeustaGmbH\M2T3\Elements\Tests\Unit\Service;

use Elastica\Client;
use Elastica\Index;
use Elastica\Response;
use Elastica\Type;
use Prophecy\Argument;
use TeamNeustaGmbH\M2T3\Elastictypo\Service\ElasticService;
use TeamNeustaGmbH\M2T3\Elements\Service\ElasticContentService;

/**
 * Class ElasticContentServiceTest
 *
 * @package TeamNeustaGmbH\M2T3\Elements\Tests\Unit\Service
 */
class ElasticContentServiceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * elasticContentService
     *
     * @var ElasticContentService
     */
    protected $elasticContentService;

    /**
     * elasticService
     *
     * @var ElasticService
     */
    protected $elasticService;

    /**
     * client
     *
     * @var Client
     */
    protected $client;

    /**
     * index
     *
     * @var Index
     */
    protected $index;

    /**
     * type
     *
     * @var Type
     */
    protected $type;

    /**
     * response
     *
     * @var Response
     */
    protected $response;

    /**
     * findContentElementsShouldReturnRowsTest
     *
     * @test
     * @return void
     */
    public function findContentElementsShouldReturnRowsTest()
    {
        $this->elasticService->getClient()->shouldBeCalled()->willReturn($this->client->reveal());
        $this->client->getIndex(Argument::exact('typo3'))->shouldBeCalled()->willReturn($this->index->reveal());
        $this->index->getType('content')->shouldBeCalled()->willReturn($this->type->reveal());
        $this->index->getName()->shouldBeCalled()->willReturn('typo3');
        $this->type->getName()->shouldBeCalled()->willReturn('content');
        $this->client->request(
            Argument::exact('typo3/content/_search'),
            Argument::exact('GET'),
            Argument::exact(["from" => 0, "size" => 10, "query" => ["query_string" => ["query" => "*foo*"]]])
        )->shouldBeCalled()->willReturn(
            $this->response->reveal()
        );
        $this->response->getData()->shouldBeCalled()->willReturn(
            [
                'hits' => [
                    'hits'  => [
                        [
                            '_id'     => 'fooooooo',
                            '_source' => [
                                'some' => 'value'
                            ]
                        ]
                    ],
                    'total' => 2,
                ]
            ]
        );

        $this->assertEquals(
            [
                'fooooooo' => [
                    'some' => 'value'
                ]
            ],
            $this->elasticContentService->findContentElements('foo', 'typo3', 'content')
        );
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        $this->elasticContentService = new ElasticContentService();
        $this->elasticService = $this->prophesize(ElasticService::class);
        $this->elasticContentService->injectElasticService($this->elasticService->reveal());
        $this->client = $this->prophesize(Client::class);
        $this->index = $this->prophesize(Index::class);
        $this->type = $this->prophesize(Type::class);
        $this->response = $this->prophesize(Response::class);
    }
}