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

namespace TeamNeustaGmbH\M2T3\Elements\Form\Element;


use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;

class ElasticompleteElement extends AbstractFormElement
{

    /**
     * Handler for single nodes
     *
     * @return array As defined in initializeResultArray() of AbstractNode
     */
    public function render()
    {
        /**
         * $parameterArray = $this->data['parameterArray'];
        $resultArray = $this->initializeResultArray();

        $resultArray['additionalHiddenFields'][] = '<input type="hidden" name="' . $parameterArray['itemFormElName'] . '" value="' . htmlspecialchars($parameterArray['itemFormElValue']) . '" />';

        return $resultArray;
         */
        $parameterArray = $this->data['parameterArray'];

        return [
            'additionalJavaScriptPost' => [
                'require(["TYPO3/CMS/M2t3Elements/Elasticomplete"], function(Elasticomplete) { 
                    Elasticomplete.build("'.$parameterArray['itemFormElName'].'") 
                });'
            ],
            'additionalJavaScriptSubmit' => [],
            'additionalHiddenFields' => [
                '<input type="hidden" name="' . $parameterArray['itemFormElName'] . '" value="' . htmlspecialchars($parameterArray['itemFormElValue']) . '" />'
            ],
            'additionalInlineLanguageLabelFiles' => [],
            'stylesheetFiles' => [],
            // can hold strings or arrays,
            // string = requireJS module,
            // array = requireJS module + callback e.g. array('TYPO3/Foo/Bar', 'function() {}')
            'requireJsModules' => [],
            'inlineData' => [],
            'html' => '
                <div class="t3js-formengine-field-item">
                    <div class="autocomplete t3-form-suggest-container">
                        <input type="text" name="elasticomplete" class="elasticomplete form-control" />
                    </div>
                </div>
            ',
        ];
    }
}