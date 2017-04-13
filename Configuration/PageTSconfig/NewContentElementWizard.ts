mod.wizards.newContentElement.wizardItems.common {
    elements {
            shop_item {
                iconIdentifier = content-m2t3-single
                title = LLL:EXT:m2t3_elements/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.shop_item_title
                description = LLL:EXT:m2t3_elements/Resources/Private/Language/locallang_db_new_content_el.xlf:wizards.newContentElement.shop_item_description
                tt_content_defValues {
                    CType = m2t3elements_shop_item
                }
            }
    }
    show := addToList(shop_item)
}
