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

namespace TeamNeustaGmbH\M2T3\Elements\Service;

use Elastica\Request;
use TeamNeustaGmbH\M2T3\Elastictypo\Service\ElasticService;

class ElasticContentService
{
    /**
     * elasticService
     *
     * @var \TeamNeustaGmbH\M2T3\Elastictypo\Service\ElasticService
     */
    protected $elasticService;

    public function __construct()
    {
        $this->injectElasticService(new ElasticService());
    }

    /**
     * injectElasticService
     *
     * @param \TeamNeustaGmbH\M2T3\Elastictypo\Service\ElasticService $elasticService
     * @return void
     */
    public function injectElasticService(\TeamNeustaGmbH\M2T3\Elastictypo\Service\ElasticService $elasticService)
    {
        $this->elasticService = $elasticService;
    }

    public function findContentElements($queryString, string $index, string $type, int $limit = 10)
    {
        $client = $this->elasticService->getClient();

        $index = $client->getIndex($index);
        $type = $index->getType($type);

        $query = $this->generateElasticQuery($queryString, $limit);

        $path = $index->getName().'/'.$type->getName().'/_search';

        $response = $client->request($path, Request::GET, $query);
        $responseArray = $response->getData();

        $rows = [];

        if (!empty($responseArray['hits']['hits']) && !empty($responseArray['hits']['total'])) {
            foreach ($responseArray['hits']['hits'] as $hit) {
                $rows[$hit['_id']] = $hit['_source'];
            }
        }

        return $rows;
    }

    /**
     * generateElasticQuery
     *
     * @param string $queryString
     * @param int $limit
     * @return array
     */
    protected function generateElasticQuery(string $queryString, int $limit): array
    {
        $query = [
            'from'  => 0,
            'size'  => $limit,
            'query' => [
                'query_string' => [
                    'query' => '*'.$queryString.'*',
                ]
            ]
        ];

        if (is_numeric($queryString)) {
            $query = [
                'query' => [
                    'match' => [
                        'id' => $queryString,
                    ]
                ]
            ];

            return $query;
        }

        return $query;
    }
}
