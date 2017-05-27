<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
CModule::IncludeModule("iblock");
$APPLICATION->IncludeComponent(
    "bitrix:another",
    "szv",
    Array(
        "IBLOCK_TYPE" => "another_page",
        "IBLOCK_ID" => "3",
        "SECTION_ID" => "2",
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
        "BROWSER_TITLE" => "-",
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
        "PAGER_TITLE" => "Ипотека",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "SEF_FOLDER" => "/ipoteka/",
        "VARIABLE_ALIASES" => Array("news"=>Array(),"section"=>Array(),"detail"=>Array(),),
        "SEF_URL_TEMPLATES" => Array("news"=>"","section"=>"","detail"=>"#ELEMENT_CODE#/"),
        "VARIABLE_ALIASES" => Array(
            "news" => Array(),
            "section" => Array(),
            "detail" => Array(),
        )
    )
);
?><div class="whatAreQuestion">
    <p class="whatAreQuestionText">
        <span class="watqtBig">Возникли вопросы? Позвоните!</span>
        <br>
        <span class="watqtLittle">Бесплатная консультация по способам покупки и действующим программам:
        <br>
       <span class="ya-elama-phone call_phone_1">+7(812) 902-50-50</span> <a data-who="footer_feedback" class="showIt">оставить заявку</a></span>
    </p>
	<div class="QW_block_ph point_border showIt" data-who="footer_feedback" ></div>
	<div data-who="footer_feedback" class="showIt" style="background: url('/bitrix/templates/szvdom/images/contact_us4.png')no-repeat; cursor:pointer; width: 100px;height: 100px;position: absolute;display: inline-block;right: 26px;top: 40px;"></div>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>