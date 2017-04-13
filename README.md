# Work in Progress - M2T3 - TYPO3 Elements

## Requirements

- php 7
- TYPO3 > 8.2
- team-neusta-gmbh/m2t3-elastictypo

## Explaination

- TYPO3 content element for shop data
- TYPO3 get single content element
- TYPO3 add magento header
- TYPO3 add magento page type
- TYPO3 get only css header
- TYPO3 get only js header
- TYPO3 get only js footer

## Installation

- add following to your composer.json

```javascript
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/teamneusta/m2t3-elements.git"
    }
  ],
  "require": {
    "TeamNeustaGmbH/m2t3-elements": "^1.0"
  }
}
```

- after that make an `composer update`  

## Configuration

- Needed Configuration for AdditionalConfiguration
```
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['magento_product_elastic']['magento_product_elastic']['index'] = 'magentypo';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['magento_product_elastic']['magento_product_elastic']['type'] = 'product';
```

Explain:

| option | description | example
| ------------ | ------------- | -------------
| index | elastic index to the magentypo index | magentypo
| type | elastic index to the magento product type | content

#### TYPOSCRIPT

Constants:

```
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:m2t3_elements/Configuration/TypoScript/constants.txt">
```

Setup:

```
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:m2t3_elements/Configuration/TypoScript/setup.txt">
```

### Usage

to get single content element

```
?contentId=1
```

to get css header

```
?pageInformation=CssHeader&no_cache=1
```

to get js header

```
?pageInformation=JsHeader&no_cache=1
```

to get js footer

```
?pageInformation=JsFooter&no_cache=1
```

The magento page type can be used to create an direct link to the magento page

The Magento content type can be used to place single shop items in TPYO3