<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "Объекты");
$APPLICATION->SetPageProperty("description", "Объекты");
$APPLICATION->SetTitle("Объекты");

$uri = preg_replace("/\?.*/i",'', $_SERVER['REQUEST_URI']);
if (strlen($uri)>1) {// если не главная страница...
    if (rtrim($uri,'/')."/"!=$uri) {
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: http://'.$_SERVER['SERVER_NAME'].str_replace($uri, $uri.'/', $_SERVER['REQUEST_URI']));
        exit();
    }
}
/*if ((isset($_GET["PAGEN_1"]) && !empty($_GET["PAGEN_1"])) || (isset($_GET["page"]) && !empty($_GET["page"]))){
	$APPLICATION->AddHeadString('<link href="http://szvdom.ru'.$APPLICATION->GetCurDir().'" rel="canonical" />',true);
}*/
CModule::IncludeModule("iblock");
if ($APPLICATION->GetCurPage() === "/obekty/"){
    ?><h1 style="font-family: Bold; font-size: 22px; text-transform: uppercase; vertical-align: baseline; line-height: 58px;  padding: 0 0 20px 38px;">Новостройки</h1><?
}
$APPLICATION->IncludeComponent(
    "bitrix:menu",
    ".default",
    array(
        "ROOT_MENU_TYPE" => "top",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => array(),
        "MAX_LEVEL" => "1",
        "CHILD_MENU_TYPE" => "left",
        "USE_EXT" => "N",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N"
    ),
    false
);

if (dirname($APPLICATION->GetCurPage()) == "/") :
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.smart.filter",
		"szv",
		array(
			"IBLOCK_TYPE" => "obekty",
			"IBLOCK_ID" => "1",
			"SECTION_ID" => "1",
			"SECTION_CODE" => "all",
			"FILTER_NAME" => "arrFilter",
			"TEMPLATE_THEME" => "blue",
			"FILTER_VIEW_MODE" => "vertical",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_GROUPS" => "Y",
			"SAVE_IN_SESSION" => "N",
			"INSTANT_RELOAD" => "N",
			"XML_EXPORT" => "Y",
			"SECTION_TITLE" => "-",
			"SECTION_DESCRIPTION" => "-",
			"POPUP_POSITION" => "left",
			"DISPLAY_ELEMENT_COUNT" => "N"
		),
		false
	);
endif;


?>
<?
//определяет показ скрытых объектов.
// если переменная существует показывает скрытые объекты
// если она равна 'all' то покажет все
$cShowActiveOnly = (!isset($_REQUEST["hidden"]))?"Y":"N";
if( $_REQUEST["hidden"] == 'all' ) $cShowActiveOnly = '';
?>
<?$APPLICATION->IncludeComponent(
	"aak:catalog", 
	"byflats", 
	array(
		"IBLOCK_TYPE" => "obekty",
		"ACTIVE" => $cShowActiveOnly,
		"IBLOCK_ID" => "1",
		"SECTION_ID" => "1",
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
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "Y",
		"USE_ELEMENT_COUNTER" => "Y",
		"USE_FILTER" => "Y",
		"FILTER_VIEW_MODE" => "HORIZONTAL",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_COMPARE" => "N",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
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
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_BROWSER_TITLE" => "-",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
		"LINK_IBLOCK_TYPE" => "undefined",
		"LINK_IBLOCK_ID" => "undefined",
		"LINK_PROPERTY_SID" => "undefined",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_STORE" => "N",
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
		"TOP_VIEW_MODE" => "SECTION",
		"SEF_FOLDER" => "/obekty/",
		"FILTER_NAME" => "",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"FILTER_PRICE_CODE" => array(
		),
		"AJAX_OPTION_ADDITIONAL" => "",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "",
			"element" => "#ELEMENT_CODE#/",
			"compare" => "compare.php?action=#ACTION_CODE#",
		),
		"VARIABLE_ALIASES" => array(
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		)
	),
	false
);?>
    <div class="detail_feedback feedbackWrap" >
        <div class="feedbackBody">
            <?$APPLICATION->IncludeComponent(
	"szv:main.feedback_szv", 
	"detail", 
	array(
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "sendmail@szvdom.ru",
		"REQUIRED_FIELDS" => array(
			0 => "PHONE",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "11",
		),
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "detail",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CATEGORY_TO" => ""
	),
	false
);?>
        </div>
    </div>

    <div class="query_feedback feedbackWrap" >
        <div class="feedbackBody">
            <?$APPLICATION->IncludeComponent(
	"szv:main.feedback_szv", 
	"quer", 
	array(
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "sendmail@szvdom.ru",
		"REQUIRED_FIELDS" => array(
			0 => "PHONE",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "13",
		),
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "detail",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CATEGORY_TO" => ""
	),
	false
);?>
        </div>
    </div>


    <div class="price_feedback feedbackWrap" >
        <div class="feedbackBody">
            <?$APPLICATION->IncludeComponent(
	"szv:main.feedback_szv", 
	"price", 
	array(
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "sendmail@szvdom.ru",
		"REQUIRED_FIELDS" => array(
			0 => "PHONE",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "12",
		),
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "price",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CATEGORY_TO" => ""
	),
	false
);?>
        </div>
    </div>

       <div class="price_plan feedbackWrap" >
        <div class="feedbackBody">
            <?$APPLICATION->IncludeComponent(
	"szv:main.feedback_szv", 
	"price_plan", 
	array(
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "sendmail@szvdom.ru",
		"REQUIRED_FIELDS" => array(
			0 => "PHONE",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "21",
		),
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "price",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CATEGORY_TO" => ""
	),
	false
);?>
        </div>
    </div>

	<div class="calculate_feedback feedbackWrap" >
		<div class="feedbackBody">
			<?$APPLICATION->IncludeComponent(
	"szv:main.feedback_szv", 
	"calc", 
	array(
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "sendmail@szvdom.ru",
		"REQUIRED_FIELDS" => array(
			0 => "PHONE",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "14",
		),
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "price",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CATEGORY_TO" => ""
	),
	false
);?>
		</div>
	</div>

    <div id="elementPopUp">
        <div id="elementPopUpWindow"></div>
    </div>
    <div id="elementPopUpWindowOverlay" onclick="$('#elementPopUp').fadeOut(500);$(this).fadeOut(500);"></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>