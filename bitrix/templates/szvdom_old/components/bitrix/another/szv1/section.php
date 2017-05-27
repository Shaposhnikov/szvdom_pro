<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
if (isset($arParams["USE_NEWS_TEMP"]) && $arParams["USE_NEWS_TEMP"] == "Y"){
    $temp = "szv";
    $count = 10;
}else{
    $temp = "";
    $count = $arParams["NEWS_COUNT"];
}
$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $arParams["SECTION_ID"] );
$ar_result = $ipropValues->getValues();
if (!empty($ar_result["SECTION_META_KEYWORDS"])){
    $APPLICATION->SetPageProperty("keywords", $ar_result["SECTION_META_KEYWORDS"]);
}else{
    $APPLICATION->SetPageProperty("keywords", $arParams["PAGER_TITLE"]);
}
if (!empty($ar_result["SECTION_META_DESCRIPTION"])){
    $APPLICATION->SetPageProperty("description", $ar_result["SECTION_META_DESCRIPTION"]);
}else{
    $APPLICATION->SetPageProperty("description", $arParams["PAGER_TITLE"]);
}
if (!empty($ar_result["SECTION_META_TITLE"])){
    $APPLICATION->SetPageProperty("title", $ar_result["SECTION_META_TITLE"]);
}else{
    $APPLICATION->SetPageProperty("title", $arParams["PAGER_TITLE"]);
}
if (!empty($ar_result["SECTION_PAGE_TITLE"])){
    $arParams["PAGER_TITLE"] = $ar_result["SECTION_PAGE_TITLE"];
}

$APPLICATION->IncludeComponent(
	"bitrix:another.section",
    $temp,
	Array(
		"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
        "SECTION_ID" => $arParams["SECTION_ID"],
        "CRUNCH_ARRAY" => $arParams["CRUNCH_ARRAY"],
		"NEWS_COUNT"	=>	 $count,
        "USE_NEWS_TEMP" => (isset($arParams["USE_NEWS_TEMP"]) && $arParams["USE_NEWS_TEMP"] == "Y")? "Y" : "N",
		"SORT_BY1"	=>	$arParams["SORT_BY1"],
		"SORT_ORDER1"	=>	$arParams["SORT_ORDER1"],
		"SORT_BY2"	=>	$arParams["SORT_BY2"],
		"SORT_ORDER2"	=>	$arParams["SORT_ORDER2"],
		"FIELD_CODE"	=>	$arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE"	=>	$arParams["LIST_PROPERTY_CODE"],
		"DISPLAY_PANEL"	=>	$arParams["DISPLAY_PANEL"],
		"SET_TITLE"	=>	$arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN"	=>	$arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"ADD_SECTIONS_CHAIN"	=>	$arParams["ADD_SECTIONS_CHAIN"],
		"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
		"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
		"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"DISPLAY_TOP_PAGER"	=>	$arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER"	=>	$arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE"	=>	$arParams["PAGER_TITLE"],
		"PAGER_TEMPLATE"	=>	$arParams["PAGER_TEMPLATE"],
		"PAGER_SHOW_ALWAYS"	=>	$arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING"	=>	$arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME"	=>	$arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"DISPLAY_DATE"	=>	$arParams["DISPLAY_DATE"],
		"DISPLAY_NAME"	=>	"Y",
		"DISPLAY_PICTURE"	=>	$arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT"	=>	$arParams["DISPLAY_PREVIEW_TEXT"],
		"PREVIEW_TRUNCATE_LEN"	=>	$arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT"	=>	$arParams["LIST_ACTIVE_DATE_FORMAT"],
		"USE_PERMISSIONS"	=>	$arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS"	=>	$arParams["GROUP_PERMISSIONS"],
		"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
		"HIDE_LINK_WHEN_NO_DETAIL"	=>	$arParams["HIDE_LINK_WHEN_NO_DETAIL"],
		"CHECK_DATES"	=>	$arParams["CHECK_DATES"],
		"PARENT_SECTION"	=>	$arResult["VARIABLES"]["SECTION_ID"],
		"PARENT_SECTION_CODE"	=>	$arResult["VARIABLES"]["SECTION_CODE"],
		"DETAIL_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SECTION_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"IBLOCK_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
	),
	$component
);?>


<?php if ($_SERVER['REQUEST_URI']=="/pokupateljam/"): ?>
<div style="margin: 20px 0 0 50px;"><!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>

<script type="text/javascript">
  VK.init({apiId: 5241283, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Poll block will be -->
<div id="vk_poll"></div>

<script type="text/javascript">
VK.Widgets.Poll("vk_poll", {width: "300"}, "211380024_50bdf441427f896352");
	</script></div>
<?php endif; ?>   
