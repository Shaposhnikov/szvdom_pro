<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");?><? 

$APPLICATION->SetTitle("");
$APPLICATION->SetTitle("Срочные продажи"); 

?>

<? $GLOBALS['arrFilter'] = array("PROPERTY_FAST_SALE_VALUE"=>"Да"); ?>

<div class="similarOnePage">
	<h1>Срочные продажи</h1>




<?CModule::IncludeModule("iblock"); ?>

<? $APPLICATION->IncludeComponent("bitrix:catalog","vtorichnaja",
        array(
            "IBLOCK_TYPE" => "vtorichnaja",
            "IBLOCK_ID" => "8",
            "SECTION_ID" => "78",
            "TEMPLATE_THEME" => "blue",
            "MESS_BTN_BUY" => "Купить",
            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
            "MESS_BTN_COMPARE" => "Сравнение",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_NOT_AVAILABLE" => "Нет в наличии",
            "DETAIL_USE_VOTE_RATING" => "N",
            "DETAIL_USE_COMMENTS" => "N",
            "DETAIL_BRAND_USE" => "N",
            "SEF_MODE" => "Y",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "SET_STATUS_404" => "Y",
            "SET_TITLE" => "Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_ELEMENT_CHAIN" => "N",
            "USE_ELEMENT_COUNTER" => "Y",
            "USE_FILTER" => "Y",
            "FILTER_VIEW_MODE" => "HORIZONTAL",
            "ACTION_VARIABLE" => "action",
            "PRODUCT_ID_VARIABLE" => "id",
            "USE_COMPARE" => "N",
            "PRICE_CODE" => array(
            ),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "0",
            "PRICE_VAT_INCLUDE" => "Y",
            "PRICE_VAT_SHOW_VALUE" => "Y",
            "BASKET_URL" => "/personal/basket.php",
            "USE_PRODUCT_QUANTITY" => "N",
            "ADD_PROPERTIES_TO_BASKET" => "N",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "PRODUCT_PROPERTIES" => array(
            ),
            "SHOW_TOP_ELEMENTS" => "N",
            "TOP_ELEMENT_COUNT" => "6",
            "TOP_LINE_ELEMENT_COUNT" => "4",
            "TOP_ELEMENT_SORT_FIELD" => "sort",
            "TOP_ELEMENT_SORT_ORDER" => "asc",
            "TOP_ELEMENT_SORT_FIELD2" => "id",
            "TOP_ELEMENT_SORT_ORDER2" => "desc",
            "TOP_PROPERTY_CODE" => array(
                0 => "",
                1 => "undefined",
                2 => "",
            ),
            "SECTION_COUNT_ELEMENTS" => "Y",
            "SECTION_TOP_DEPTH" => "2",
            "SECTIONS_VIEW_MODE" => "LIST",
            "SECTIONS_SHOW_PARENT_NAME" => "Y",
            "PAGE_ELEMENT_COUNT" => "11",
            "LINE_ELEMENT_COUNT" => "4",
            "ELEMENT_SORT_FIELD" => "sort",
            "ELEMENT_SORT_ORDER" => "asc",
            "ELEMENT_SORT_FIELD2" => "id",
            "ELEMENT_SORT_ORDER2" => "desc",
            "LIST_PROPERTY_CODE" => array(
                0 => "",
                1 => "undefined",
                2 => "",
            ),
            "INCLUDE_SUBSECTIONS" => "Y",
            "LIST_META_KEYWORDS" => "-",
            "LIST_META_DESCRIPTION" => "-",
            "LIST_BROWSER_TITLE" => "-",
            "DETAIL_PROPERTY_CODE" => array(
                0 => "TYPE_ObJECT",
                1 => "ADDRES",
                2 => "ST_METRO",
                3 => "TYPE_OPERATION",
                4 => "COUNT_ROOM",
                5 => "RAION",
                6 => "S_ALL",
                7 => "S_LIVE",
                8 => "S_ROOM",
                9 => "S_KITCHEN",
                10 => "ETAJ_LEBEL",
                11 => "TYPE_HOUSE",
                12 => "HEIGHT_POTOLOK",
                13 => "",
            ),
            "DETAIL_META_KEYWORDS" => "-",
            "DETAIL_META_DESCRIPTION" => "-",
            "DETAIL_BROWSER_TITLE" => "-",
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
            "DETAIL_DISPLAY_NAME" => "Y",
            "DETAIL_DETAIL_PICTURE_MODE" => "POPUP",
            "DETAIL_ADD_DETAIL_TO_SLIDER" => "Y",
            "DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
            "LINK_IBLOCK_TYPE" => "undefined",
            "LINK_IBLOCK_ID" => "undefined",
            "LINK_PROPERTY_SID" => "undefined",
            "USE_STORE" => "N",
            "PAGER_TEMPLATE" => ".default",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Товары",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "ADD_PICT_PROP" => "MORE_PHOTO",
            "LABEL_PROP" => "-",
            "TOP_VIEW_MODE" => "SECTION",
            "SEF_FOLDER" => "/vtorichnaja/",
            //"FILTER_NAME" => "arrFilter",
            "FILTER_FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "FILTER_PROPERTY_CODE" => array(
                0 => "ADDRES",
                1 => "ST_METRO",
                2 => "TYPE_OPERATION",
                3 => "COUNT_ROOM",
                4 => "RAION",
                5 => "S_ALL",
                6 => "PRICE",
                7 => "S_LIVE",
                8 => "S_ROOM",
                9 => "S_KITCHEN",
                10 => "ETAJ_LEBEL",
                11 => "TYPE_HOUSE",
                12 => "HEIGHT_POTOLOK",
                13 => "",
            ),
            "FILTER_PRICE_CODE" => array(
            ),
            "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
            "AJAX_OPTION_ADDITIONAL" => "",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "SEF_URL_TEMPLATES" => Array

("sections"=>"","section"=>"","element"=>"#ELEMENT_CODE#/","element_inner_page"=>"#ELEMENT_CODE#/#INNER_PAGE

_CODE#/","compare"=>"compare.php?action=#ACTION_CODE#"),
            "VARIABLE_ALIASES" => array(
                "compare" => array(
                    "ACTION_CODE" => "action",
                ),
            )
        ),
        false
    );?>

</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>