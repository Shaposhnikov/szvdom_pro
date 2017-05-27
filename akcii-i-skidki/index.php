<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->AddChainItem("Главная", "/");
$APPLICATION->AddChainItem("Акции и скидки", "");
CModule::IncludeModule("iblock");
$APPLICATION->AddHeadString('<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>', true);
$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");

/*
$iblockId = 3;
$sectionId = 14;
$arFilter = Array('IBLOCK_ID' => $iblockId, 'GLOBAL_ACTIVE' => 'Y', 'ID' => $sectionId);
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
$db_list = CIBlockSection::GetList(Array($by => $order), $arFilter, false, $arSelect, false);
while ($ar_result = $db_list->GetNext()) {
    $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(
        $iblockId,
        $sectionId
    );
    $ar_result["SEO"] = $ipropValues->getValues();
    $section = $ar_result;
}
if (!empty($section["SEO"]["SECTION_META_KEYWORDS"])) {
    $APPLICATION->SetPageProperty("keywords", $section["SEO"]["SECTION_META_KEYWORDS"]);
} else {
    $APPLICATION->SetPageProperty("keywords", $section["NAME"]);
}
if (!empty($section["SEO"]["SECTION_META_DESCRIPTION"])) {
    $APPLICATION->SetPageProperty("description", $section["SEO"]["SECTION_META_DESCRIPTION"]);
} else {
    $APPLICATION->SetPageProperty("description", $section["NAME"]);
}
if (!empty($section["SEO"]["SECTION_META_TITLE"])) {
    $APPLICATION->SetPageProperty("title", $section["SEO"]["SECTION_META_TITLE"]);
} else {
    $APPLICATION->SetPageProperty("title", $section["NAME"]);
}

echo "<div class='specOfferMainPage similarOnePage'><ul>";
$arSelect = Array(
    "ID",
    "NAME",
    "ACTIVE",
    "DETAIL_PAGE_URL",
    "PREVIEW_PICTURE",
    "PREVIEW_TEXT"
);
$arFilter = Array("IBLOCK_ID" => 1, "SECTION_ID" => 1, "ACTIVE" => "Y");
if (isset($_REQUEST["page"])) {
    for ($i = 0; $i < 25; $i++) {
        $limitArray[] = 25 * ($_REQUEST["page"] - 1) + $i;
    }
} else {
    for ($i = 0; $i < 26; $i++) {
        $limitArray[] = $i;
    }
}
print_pre($limitArray,true);
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
$coutPage = 0;


while ($ob = $res->GetNextElement()) {
    $buffo = $ob->GetFields();
    $bufProp = $ob->GetProperties($propSelect);
    $buffo["PROPERTIES"] = $bufProp;
    if (!empty($buffo["PROPERTIES"]["SPECIAL_OFFER"]["VALUE"]) && strtolower($buffo["PROPERTIES"]["NOT_SHOW_ON_OFFER"]["VALUE"]) != "да") {
        $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $buffo["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
        if (!empty($buffo["PREVIEW_PICTURE"])) {
            $image = CFile::GetFileArray($buffo["PREVIEW_PICTURE"]);
        } else {
            if (empty($blocks[0]["avatar"])) {
                $image = CFile::GetFileArray($buffo["PROPERTIES"]["MULTI_IMAGES"]["VALUE"][0]);
            } else {
                $image["SRC"] = "/include/images/" . (string)$blocks[0]["avatar"];
            }

        }
        $buffo["PREVIEW_PICTURE"] = $image["SRC"];
        $arMap[] = array(
            "X" => $buffo["PROPERTIES"]["LATITUDE"]["VALUE"],
            "Y" => $buffo["PROPERTIES"]["LONGITUDE"]["VALUE"],
            "REGION" => $buffo["PROPERTIES"]["REGION"]["VALUE"][0],
            "ADDRESS" => $buffo["PROPERTIES"]["ADDRESS"]["VALUE"],
            "NAME" => $buffo["NAME"],
            "URL" => $buffo["DETAIL_PAGE_URL"],
            "IMG" => $image["SRC"]
        );
        $bufi[] = $buffo;
        $coutPage++;
    }

}
//*/
?><?
//$GLOBALS['arMyFilter'] = array("IBLOCK_ID" => 5, "SECTION_ID" => 4, "ACTIVE" => "N");
$GLOBALS['arMyFilter'] = array("!PROPERTY_NOT_SHOW_ON_OFFER_VALUE"=>'Да');


?> <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"acii-i-skidki",
	Array(
		"IBLOCK_TYPE" => "obekty",
		"IBLOCK_ID" => "1",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "all",
		"SECTION_USER_FIELDS" => array(0=>"",1=>"undefined",2=>"",),
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arMyFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "N",
		"PAGE_ELEMENT_COUNT" => "25",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(0=>"",1=>"undefined",2=>"",),
		"OFFERS_LIMIT" => "5",
		"TEMPLATE_THEME" => "blue",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "Y",
		"META_DESCRIPTION" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"SET_STATUS_404" => "N",
		"CACHE_FILTER" => "N",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRICE_CODE" => array(),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(),
		"DISPLAY_COMPARE" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"MESS_BTN_COMPARE" => "Сравнить",
		"AJAX_OPTION_ADDITIONAL" => "",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity"
	)
);?>
<div class="detail_feedback feedbackWrap">
	<div class="feedbackBody">
		 <?$APPLICATION->IncludeComponent(
	"szv:main.feedback_szv",
	"detail",
	Array(
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "sendmail@szvdom.ru",
		"REQUIRED_FIELDS" => array(0=>"PHONE",),
		"EVENT_MESSAGE_ID" => array(0=>"12",),
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "detail",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CATEGORY_TO" => ""
	)
);?>
	</div>
</div>
<br>
<?
/*seo start*/
//$APPLICATION->SetPageProperty("h1", "***");
$iblockId = 3;
$sectionId = 14;
$arFilter = Array('IBLOCK_ID' => $iblockId, 'GLOBAL_ACTIVE' => 'Y', 'ID' => $sectionId);
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
$db_list = CIBlockSection::GetList(Array($by => $order), $arFilter, false, $arSelect, false);
while ($ar_result = $db_list->GetNext()) {
    $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(
        $iblockId,
        $sectionId
    );
    $ar_result["SEO"] = $ipropValues->getValues();
    $section = $ar_result;
}
if (!empty($section["SEO"]["SECTION_META_KEYWORDS"])) {
    $APPLICATION->SetPageProperty("keywords", $section["SEO"]["SECTION_META_KEYWORDS"]);
} else {
    $APPLICATION->SetPageProperty("keywords", $section["NAME"]);
}
if (!empty($section["SEO"]["SECTION_META_DESCRIPTION"])) {
    $APPLICATION->SetPageProperty("description", $section["SEO"]["SECTION_META_DESCRIPTION"]);
} else {
    $APPLICATION->SetPageProperty("description", $section["NAME"]);
}
if (!empty($section["SEO"]["SECTION_META_TITLE"])) {
    $APPLICATION->SetPageProperty("title", $section["SEO"]["SECTION_META_TITLE"]);
} else {
    $APPLICATION->SetPageProperty("title", $section["NAME"]);
}
$APPLICATION->SetPageProperty("h1", $section["SEO"]["SECTION_PAGE_TITLE"]);
/*seo end */  

?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>