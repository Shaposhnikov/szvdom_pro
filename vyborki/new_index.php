<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Выборки");

$uri = preg_replace("/\?.*/i",'', $_SERVER['REQUEST_URI']);
if (strlen($uri)>1) {// если не главная страница...
    if (rtrim($uri,'/')."/"!=$uri) {
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: http://'.$_SERVER['SERVER_NAME'].str_replace($uri, $uri.'/', $_SERVER['REQUEST_URI']));
        exit();
    }
}
?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"szv", 
	array(
		"IBLOCK_TYPE" => "vyborki",
		"IBLOCK_ID" => "2",
		"NEWS_COUNT" => "19",
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
		"CACHE_TYPE" => "N",
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
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Выборки",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"SEF_FOLDER" => "/vyborki/",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
);
?>
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
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
