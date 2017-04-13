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

$EM_CONF[$_EXTKEY] = array(
    'title' => 'm2t3_elements',
    'description' => '',
    'category' => 'fe',
    'author' => '',
    'author_email' => '',
    'author_company' => '',
    'state' => 'stable',
    'version' => '1.0.2',
    'constraints' => array(
        'depends' => array(
            'typo3' => '8.5.0-8.99.99',
            'm2t3_elastictypo' => '1.0.0',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);
