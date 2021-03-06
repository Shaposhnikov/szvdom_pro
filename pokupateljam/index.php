<?//vybiraem-kvartiru
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CModule::IncludeModule("iblock");

$arFilter = Array('IBLOCK_ID' => 3, 'GLOBAL_ACTIVE'=>'Y', 'ID' => array(5,9,7));
$arSelect = array(
    "ID",
    "IBLOCK_ID",
    "NAME",
    "PICTURE",
    "DESCRIPTION",
    "CODE",
    "DETAIL_PICTURE",
    "UF_DESCRIPTION"
);
$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false,$arSelect,false);
while($ar_result = $db_list->GetNext()){
    $image = CFile::GetFileArray($ar_result["PICTURE"]);
    $arCrunch[] = array(
        "NAME" => $ar_result["NAME"],
        "URL" => "/".$ar_result["CODE"]."/",
        "IMG" => $image["SRC"]
    );
}


$APPLICATION->IncludeComponent(
    "bitrix:another",
    "szv",
    Array(
        "IBLOCK_TYPE" => "another_page",
        "IBLOCK_ID" => "3",
        "SECTION_ID" => "8",
        "USE_SEARCH" => "N",
        "USE_RSS" => "N",
        "USE_RATING" => "N",
        "USE_CATEGORIES" => "N",
        "USE_FILTER" => "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "CHECK_DATES" => "Y",
        "SEF_MODE" => "Y",
        "AJAX_MODE" => "N",
        "CRUNCH_ARRAY" => $arCrunch,
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "ADD_ELEMENT_CHAIN" => "Y",
        "USE_PERMISSIONS" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "USE_SHARE" => "N",
        "PREVIEW_TRUNCATE_LEN" => "",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "LIST_FIELD_CODE" => array("","undefined",""),
        "LIST_PROPERTY_CODE" => array("","undefined",""),
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "DISPLAY_NAME" => "Y",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "Покупателям",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_FIELD_CODE" => array("","undefined",""),
        "DETAIL_PROPERTY_CODE" => array("","undefined",""),
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PAGER_TEMPLATE" => "",
        "DETAIL_PAGER_SHOW_ALL" => "Y",
        "PAGER_TEMPLATE" => ".default",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Покупателям",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "SEF_FOLDER" => "/pokupateljam/",
        "VARIABLE_ALIASES" => Array("news"=>Array(),"section"=>Array(),"detail"=>Array(),),
        "SEF_URL_TEMPLATES" => Array("news"=>"","section"=>"","detail"=>"#ELEMENT_CODE#/"),
        "VARIABLE_ALIASES" => Array(
            "news" => Array(),
            "section" => Array(),
            "detail" => Array(),
        )
    )
);
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>