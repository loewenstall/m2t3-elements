/*
 * This file is part of the TeamNeustaGmbH/m2t3 package.
 *
 * Copyright (c) 2017 neusta GmbH | Ein team neusta Unternehmen
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @license https://opensource.org/licenses/BSD-3-Clause  BSD-3-Clause License
 */

/**
 * Created by bennsel on 30.01.17.
 */
define(['jquery', 'jquery/autocomplete'], function($) {
    var Elasticomplete = {};

    Elasticomplete.preload = function (id) {
        $.get(TYPO3.settings.ajaxUrls['ElasticompleteController::renderItems'], { id: id }, function(data) {
            $('.elasticomplete').val(data[0].name + ' ('+data[0].sku+')');
        }, 'json');

    };

    Elasticomplete.build = function (hiddenElementName) {
        var hiddenEl =  $('[name="'+hiddenElementName+'"]');
        Elasticomplete.preload(hiddenEl.val());
        $('.elasticomplete').autocomplete({
            serviceUrl: TYPO3.settings.ajaxUrls['ElasticompleteController::renderItems'],
            dataType: 'json',
            transformResult: function(response) {
                return {
                    suggestions: $.map(response, function(dataItem) {
                        return { value: dataItem.name + ' ('+dataItem.sku+')', data: dataItem.id };
                    })
                };
            },
            formatResult: function(suggestion, value) {
                return $('<div>').append(
                    $('<a class="autocomplete-suggestion-link" href="#">' +
                        suggestion.value +
                        '</a></div>')).html();
            },
            onSelect: function (suggestion) {
                hiddenEl.val(suggestion.data);
            },
            noSuggestionNotice: '<div class="autocomplete-info">No results</div>',
            containerClass: 'autocomplete-results',
        });
    };



    return Elasticomplete;
});