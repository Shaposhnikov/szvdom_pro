<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;
if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
	?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
<?
	}
}
if (isset($templateData['JS_OBJ']))
{
?><script type="text/javascript">
BX.ready(BX.defer(function(){
	if (!!window.<? echo $templateData['JS_OBJ']; ?>)
	{
		window.<? echo $templateData['JS_OBJ']; ?>.allowViewedCount(true);
	}
}));
</script><?
}
$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID"=>1,"ID" => $arResult["ID"]);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
 	$arFields = $ob->GetFields();
 	$prop = $ob->GetProperties();
 	$arFields["PROPERTIES"] = $prop;
 	$thisObj = $arFields;
}





$description = "***";
if ($APPLICATION->GetCurPage() == $arResult["DETAIL_PAGE_URL"] . "pohozhie-obekty/") {
	$description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_OBJECT"]["VALUE"]["TEXT"]);
} elseif ($APPLICATION->GetCurPage() == $arResult["DETAIL_PAGE_URL"] . "hod-stroitelstva/") {
	$description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_WORK"]["VALUE"]["TEXT"]);
} elseif ($APPLICATION->GetCurPage() == $arResult["DETAIL_PAGE_URL"] . "foto/") {
	$description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_PHOTO"]["VALUE"]["TEXT"]);
} elseif ($APPLICATION->GetCurPage() == $arResult["DETAIL_PAGE_URL"] . "ipoteka/") {
	$description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_IPOTEKY"]["VALUE"]["TEXT"]);
} elseif ($APPLICATION->GetCurPage() == $arResult["DETAIL_PAGE_URL"] . "zachet-zhilja/") {
	$description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_ZACHET"]["VALUE"]["TEXT"]);
} elseif ($APPLICATION->GetCurPage() == $arResult["DETAIL_PAGE_URL"] . "tseny-na-kvartiry/") {
	$description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_PRICE"]["VALUE"]["TEXT"]);
} elseif ($APPLICATION->GetCurPage() == $arResult["DETAIL_PAGE_URL"] . "planirovki/") {
	$description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_PLAN"]["VALUE"]["TEXT"]);
} elseif ($APPLICATION->GetCurPage() == $arResult["DETAIL_PAGE_URL"]) {
	$description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_MAIN"]["VALUE"]["TEXT"]);
}

$GLOBALS["description"] = $description;// . $APPLICATION->GetCurPage() . ' == ' .$arResult["DETAIL_PAGE_URL"];

	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#KRUGOMIKI#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
										echo $GLOBALS["description"];
										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);




$GLOBALS["ALL_RESULT"] = $arResult; 
$GLOBALS["SEO"] = $thisObj;
if ($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL'].'pohozhie-obekty/'){
	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#DYNAMIC#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
										$GLOBALS["APPLICATION"]->IncludeComponent(
								            "szv:element.sim",
								            "",
								            array(
								                "MAP" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["MAP_OBJECTS"]["VALUE"],
								                "OBJECT" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["OBJECTS_FOR_THIS"]["VALUE"],
								                "SELECTS" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["OBJECT_SELECTIONS"]["VALUE"]
								            ),
								            false
								        );
										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);
	$arResult["CACHED_TPL"] = preg_replace_callback(
		"/#SEO#/is".BX_UTF_PCRE_MODIFIER,
		create_function('$matches', 'ob_start();
									$GLOBALS["APPLICATION"]->IncludeComponent(
							            "szv:element.seo",
							            "",
							            array(
							         		"SEO" => $GLOBALS["SEO"],
							         		"PAGE" => "OBJ"
							            ),
							            false
							        );
									$retrunStr = @ob_get_contents();
									ob_get_clean();
									return $retrunStr;'),
									$arResult["CACHED_TPL"]);

	echo $arResult["CACHED_TPL"];
}elseif ($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL'].'foto/'){

    $APPLICATION->AddChainItem($APPLICATION->GetTitle(), '');

	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#DYNAMIC#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
										$GLOBALS["APPLICATION"]->IncludeComponent(
								            "szv:element.photo",
								            "",
								            array(
								                "MULTI_IMAGE" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["MULTI_IMAGES"]["VALUE"],
								                "MULTI_IMAGE_DESC" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["DESCRIPTION_MULTI_IMAGES"]["VALUE"]
								            ),
								            false
								        );
										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);
	$arResult["CACHED_TPL"] = preg_replace_callback(
		"/#SEO#/is".BX_UTF_PCRE_MODIFIER,
		create_function('$matches', 'ob_start();
									$GLOBALS["APPLICATION"]->IncludeComponent(
							            "szv:element.seo",
							            "",
							            array(
							         		"SEO" => $GLOBALS["SEO"],
							         		"PAGE" => "FOTO"
							            ),
							            false
							        );
									$retrunStr = @ob_get_contents();
									ob_get_clean();
									return $retrunStr;'),
									$arResult["CACHED_TPL"]);

	echo $arResult["CACHED_TPL"];
}elseif ($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL'].'hod-stroitelstva/'){
	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#DYNAMIC#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
										$GLOBALS["APPLICATION"]->IncludeComponent(
								            "szv:element.job",
								            "",
								            array(
								                "MULTI_IMAGE_JOB" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["MULTI_IMAGES_JOB"]["VALUE"],
								                "MULTI_IMAGE_DESC_JOB" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["DESCRIPTION_MULTI_IMAGES_JOB"]["VALUE"] 
								            ),
								            false
								        );
										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);
	$arResult["CACHED_TPL"] = preg_replace_callback(
		"/#SEO#/is".BX_UTF_PCRE_MODIFIER,
		create_function('$matches', 'ob_start();
									$GLOBALS["APPLICATION"]->IncludeComponent(
							            "szv:element.seo",
							            "",
							            array(
							         		"SEO" => $GLOBALS["SEO"],
							         		"PAGE" => "JOB"
							            ),
							            false
							        );
									$retrunStr = @ob_get_contents();
									ob_get_clean();
									return $retrunStr;'),
									$arResult["CACHED_TPL"]);

	echo $arResult["CACHED_TPL"];
}elseif (($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL'] . "tseny-na-kvartiry/") || ($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL'] . "planirovki/")){
    if ($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL'] . "tseny-na-kvartiry/") {
         $GLOBALS["TYPE_HTML"] = "price";
         $GLOBALS["TYPE_SEO"] = "PRC";
    } elseif ($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL'] . "planirovki/") {
         $GLOBALS["TYPE_HTML"] = "plan";
         $GLOBALS["TYPE_SEO"] = "PLAN";
    }
    $GLOBALS["IDS"] = $arResult["ID"];
    if (strtolower($arResult["PROPERTIES"]["DONT_SHOW_PRICE"]["VALUE"]) != "да") {  $GLOBALS["DONT_SHOW_PRICE"] = "N"; }else{  $GLOBALS["DONT_SHOW_PRICE"] = "Y"; }
	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#DYNAMIC#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
									    echo "<div class=\'elementFilterDiv\'>";
									    echo "<div>";
									    $GLOBALS["APPLICATION"]->IncludeComponent(
									        "bitrix:element.filter",
									        "szv",
									        array(
									            "IBLOCK_TYPE" => "obekty",
									            "IBLOCK_ID" => "1",
									            "SECTION_ID" => "1",
									            "ID_LINK_ZHK" => $GLOBALS["IDS"],
									            "SECTION_CODE" => "all",
									            "FILTER_NAME" => "arrFilter",
									            "TEMPLATE_THEME" => "blue",
									            "FILTER_VIEW_MODE" => "vertical",
									            "CACHE_TYPE" => "A",
									            "CACHE_TIME" => "36000000",
									            "CACHE_GROUPS" => "Y",
									            "SAVE_IN_SESSION" => "N",
									            "INSTANT_RELOAD" => "N",
									            "DONT_SHOW_PRICE" => $GLOBALS["DONT_SHOW_PRICE"],
									            "XML_EXPORT" => "Y",
									            "SECTION_TITLE" => "-",
									            "SECTION_DESCRIPTION" => "-",
									            "POPUP_POSITION" => "left",
									            "TYPE_HTML" => $GLOBALS["TYPE_HTML"],
									            "DISPLAY_ELEMENT_COUNT" => "N",
									            "XML_ID" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["SECOND_ID"]["VALUE"]

									        ),
									        false
									    );
									    echo "</div>";
										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);
	$arResult["CACHED_TPL"] = preg_replace_callback(
		"/#SEO#/is".BX_UTF_PCRE_MODIFIER,
		create_function('$matches', 'ob_start();
									$GLOBALS["APPLICATION"]->IncludeComponent(
							            "szv:element.seo",
							            "",
							            array(
							         		"SEO" => $GLOBALS["SEO"],
							         		"PAGE" => $GLOBALS["TYPE_SEO"]
							            ),
							            false
							        );
									$retrunStr = @ob_get_contents();
									ob_get_clean();
									return $retrunStr;'),
									$arResult["CACHED_TPL"]);

	echo $arResult["CACHED_TPL"];
}elseif ($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL'] . "ipoteka/") {
	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#DYNAMIC#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
										$GLOBALS["APPLICATION"]->IncludeComponent(
								            "szv:element.ipoteka",
								            "",
								            array(
								                "BANKS" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["BANKS"]["VALUE"]
								            ),
								            false
								        );
										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);
	$arResult["CACHED_TPL"] = preg_replace_callback(
		"/#SEO#/is".BX_UTF_PCRE_MODIFIER,
		create_function('$matches', 'ob_start();
									$GLOBALS["APPLICATION"]->IncludeComponent(
							            "szv:element.seo",
							            "",
							            array(
							         		"SEO" => $GLOBALS["SEO"],
							         		"PAGE" => "SLAVE"
							            ),
							            false
							        );
									$retrunStr = @ob_get_contents();
									ob_get_clean();
									return $retrunStr;'),
									$arResult["CACHED_TPL"]);

	echo $arResult["CACHED_TPL"];
}elseif ($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL'] . "zachet-zhilja/") {
	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#DYNAMIC#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
										$GLOBALS["APPLICATION"]->IncludeComponent(
								            "szv:element.zach",
								            "",
								            array(
								            ),
								            false
								        );
										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);
	$arResult["CACHED_TPL"] = preg_replace_callback(
		"/#SEO#/is".BX_UTF_PCRE_MODIFIER,
		create_function('$matches', 'ob_start();
									$GLOBALS["APPLICATION"]->IncludeComponent(
							            "szv:element.seo",
							            "",
							            array(
							         		"SEO" => $GLOBALS["SEO"],
							         		"PAGE" => "CALC"
							            ),
							            false
							        );
									$retrunStr = @ob_get_contents();
									ob_get_clean();
									return $retrunStr;'),
									$arResult["CACHED_TPL"]);





	echo $arResult["CACHED_TPL"];
}elseif ($APPLICATION->GetCurPage() == $thisObj['DETAIL_PAGE_URL']) {
	$GLOBALS["TYPE_HTML"] = "price";$GLOBALS["TYPE_SEO"] = "PRC";

	/* вызываем нужный шаблон если жк Легенда  */

if (preg_match('#/obekty/zhk-legenda-na-komendantskom-58/.*#siU', $_SERVER['REQUEST_URI'])) {

	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#DYNAMIC#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
//echo"----cut----";
										$GLOBALS["APPLICATION"]->IncludeComponent(
								            "szv:element.main.leg58",
								            "",
								            array(
								         		"ALL" => $GLOBALS["ALL_RESULT"]
								            ),
								            false
								        );
//echo"----end cut----";

									    echo "<div class=\'priceTable\'><div class=\'heading\'>Смотрите цены и планировки</div><div class=\'elementFilterDiv\'>";
									    echo "<div>";
									    $GLOBALS["APPLICATION"]->IncludeComponent(
									        "bitrix:element.filter",
									        "leg58",
									        array(
									            "IBLOCK_TYPE" => "obekty",
									            "IBLOCK_ID" => "1",
									            "SECTION_ID" => "1",
									            "ID_LINK_ZHK" => $GLOBALS["IDS"],
									            "SECTION_CODE" => "all",
									            "FILTER_NAME" => "arrFilter",
									            "TEMPLATE_THEME" => "blue",
									            "FILTER_VIEW_MODE" => "vertical",
									            "CACHE_TYPE" => "A",
									            "CACHE_TIME" => "36000000",
									            "CACHE_GROUPS" => "Y",
									            "SAVE_IN_SESSION" => "N",
									            "INSTANT_RELOAD" => "N",
									            "DONT_SHOW_PRICE" => $GLOBALS["DONT_SHOW_PRICE"],
									            "XML_EXPORT" => "Y",
									            "SECTION_TITLE" => "-",
									            "SECTION_DESCRIPTION" => "-",
									            "POPUP_POSITION" => "left",
									            "TYPE_HTML" => $GLOBALS["TYPE_HTML"],
									            "DISPLAY_ELEMENT_COUNT" => "N",
									            "XML_ID" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["SECOND_ID"]["VALUE"]

									        ),
									        false
									    );
echo "</div></div>";



										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);

} elseif (preg_match('#/obekty/zhk-legenda-na-dalnevostochnom-12/.*#siU', $_SERVER['REQUEST_URI'])) {

	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#DYNAMIC#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
//echo"----cut----";
										$GLOBALS["APPLICATION"]->IncludeComponent(
								            "szv:element.main.leg12",
								            "",
								            array(
								         		"ALL" => $GLOBALS["ALL_RESULT"]
								            ),
								            false
								        );
//echo"----end cut----";

									    echo "<div class=\'priceTable\'><div class=\'heading\'>Смотрите цены и планировки</div><div class=\'elementFilterDiv\'>";
									    echo "<div>";
									    $GLOBALS["APPLICATION"]->IncludeComponent(
									        "bitrix:element.filter",
									        "leg12",
									        array(
									            "IBLOCK_TYPE" => "obekty",
									            "IBLOCK_ID" => "1",
									            "SECTION_ID" => "1",
									            "ID_LINK_ZHK" => $GLOBALS["IDS"],
									            "SECTION_CODE" => "all",
									            "FILTER_NAME" => "arrFilter",
									            "TEMPLATE_THEME" => "blue",
									            "FILTER_VIEW_MODE" => "vertical",
									            "CACHE_TYPE" => "A",
									            "CACHE_TIME" => "36000000",
									            "CACHE_GROUPS" => "Y",
									            "SAVE_IN_SESSION" => "N",
									            "INSTANT_RELOAD" => "N",
									            "DONT_SHOW_PRICE" => $GLOBALS["DONT_SHOW_PRICE"],
									            "XML_EXPORT" => "Y",
									            "SECTION_TITLE" => "-",
									            "SECTION_DESCRIPTION" => "-",
									            "POPUP_POSITION" => "left",
									            "TYPE_HTML" => $GLOBALS["TYPE_HTML"],
									            "DISPLAY_ELEMENT_COUNT" => "N",
									            "XML_ID" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["SECOND_ID"]["VALUE"]

									        ),
									        false
									    );
echo "</div></div>";



										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);


} else {


	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#DYNAMIC#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
//echo"----cut----";
										$GLOBALS["APPLICATION"]->IncludeComponent(
								            "szv:element.main",
								            "",
								            array(
								         		"ALL" => $GLOBALS["ALL_RESULT"]
								            ),
								            false
								        );
//echo"----end cut----";

									    echo "<div class=\'elementFilterDiv\'>";
									    echo "<div>";
									    $GLOBALS["APPLICATION"]->IncludeComponent(
									        "bitrix:element.filter",
									        "szv",
									        array(
									            "IBLOCK_TYPE" => "obekty",
									            "IBLOCK_ID" => "1",
									            "SECTION_ID" => "1",
									            "ID_LINK_ZHK" => $GLOBALS["IDS"],
									            "SECTION_CODE" => "all",
									            "FILTER_NAME" => "arrFilter",
									            "TEMPLATE_THEME" => "blue",
									            "FILTER_VIEW_MODE" => "vertical",
									            "CACHE_TYPE" => "A",
									            "CACHE_TIME" => "36000000",
									            "CACHE_GROUPS" => "Y",
									            "SAVE_IN_SESSION" => "N",
									            "INSTANT_RELOAD" => "N",
									            "DONT_SHOW_PRICE" => $GLOBALS["DONT_SHOW_PRICE"],
									            "XML_EXPORT" => "Y",
									            "SECTION_TITLE" => "-",
									            "SECTION_DESCRIPTION" => "-",
									            "POPUP_POSITION" => "left",
									            "TYPE_HTML" => $GLOBALS["TYPE_HTML"],
									            "DISPLAY_ELEMENT_COUNT" => "N",
									            "XML_ID" => $GLOBALS["ALL_RESULT"]["PROPERTIES"]["SECOND_ID"]["VALUE"]

									        ),
									        false
									    );
									    echo "</div>";



										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);


}

	$arResult["CACHED_TPL"] = preg_replace_callback(
			"/#SEO#/is".BX_UTF_PCRE_MODIFIER,
			create_function('$matches', 'ob_start();
										$GLOBALS["APPLICATION"]->IncludeComponent(
								            "szv:element.seo",
								            "",
								            array(
								         		"SEO" => $GLOBALS["SEO"],
								         		"PAGE" => "MAIN"
								            ),
								            false
								        );
										$retrunStr = @ob_get_contents();
										ob_get_clean();
										return $retrunStr;'),
										$arResult["CACHED_TPL"]);

	echo $arResult["CACHED_TPL"];
}			   
?>