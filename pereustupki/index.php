<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "Переуступки");
$APPLICATION->SetPageProperty("description", "Переуступки");
$APPLICATION->SetTitle("Переуступки");
CModule::IncludeModule("iblock");
$APPLICATION->AddChainItem("Главная", "/");
$APPLICATION->AddChainItem("Переуступки", "");
?><div class="pereustupkiMainDescr">
	<h1>Переуступка</h1>
    <div class="notMainPageMenu" style="margin-left: -38px; width: 1056px;">

        <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"ver1", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "ver1"
	),
	false
);
        ?>
    </div>
	<div class="firstAnotherDescription">
		<p>
			 Переуступка - это договор уступки права требования или договор цессии. Это единственный способ продать квартиру в строящемся доме, не оформляя ее в собственность. Откуда возникают переуступки? <a href="#down">подробнее</a>
		</p>
	</div>
</div>
<?if (dirname($APPLICATION->GetCurPage()) == "/") :

    $APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter",
        "szv",
        array(
            "IBLOCK_TYPE" => "negotiation",
            "IBLOCK_ID" => "5",
            "SECTION_ID" => "13",
            "SECTION_CODE" => "all",
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
endif;?>

 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog",
	"szv",
	Array(
		"IBLOCK_TYPE" => "negotiation",
		"IBLOCK_ID" => "5",
		"SECTION_ID" => "13",
		"USE_SELECT_TEMP" => "Y",
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
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
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
		"PRICE_CODE" => array(),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(),
		"SHOW_TOP_ELEMENTS" => "N",
		"TOP_ELEMENT_COUNT" => "6",
		"TOP_LINE_ELEMENT_COUNT" => "4",
		"TOP_ELEMENT_SORT_FIELD" => "sort",
		"TOP_ELEMENT_SORT_ORDER" => "asc",
		"TOP_ELEMENT_SORT_FIELD2" => "id",
		"TOP_ELEMENT_SORT_ORDER2" => "desc",
		"TOP_PROPERTY_CODE" => array("","undefined",""),
		"SECTION_COUNT_ELEMENTS" => "Y",
		"SECTION_TOP_DEPTH" => "2",
		"SECTIONS_VIEW_MODE" => "LIST",
		"SECTIONS_SHOW_PARENT_NAME" => "Y",
		"PAGE_ELEMENT_COUNT" => "19",
		"LINE_ELEMENT_COUNT" => "4",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"LIST_PROPERTY_CODE" => array("","undefined",""),
		"INCLUDE_SUBSECTIONS" => "Y",
		"LIST_META_KEYWORDS" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_BROWSER_TITLE" => "-",
		"DETAIL_PROPERTY_CODE" => array("","undefined",""),
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
		"SEF_FOLDER" => "/pereustupki/",
		"VARIABLE_ALIASES" => Array("sections"=>Array(),"section"=>Array(),"element"=>Array(),"element_inner_page"=>Array(),"compare"=>Array("ACTION_CODE"=>"action"),),
		"FILTER_NAME" => "",
		"FILTER_FIELD_CODE" => array("","undefined",""),
		"FILTER_PROPERTY_CODE" => array("","undefined",""),
		"FILTER_PRICE_CODE" => array(),
		"SEF_URL_TEMPLATES" => Array("sections"=>"","section"=>"","element"=>"#ELEMENT_CODE#/","element_inner_page"=>"#ELEMENT_CODE#/#INNER_PAGE_CODE#/","compare"=>"compare.php?action=#ACTION_CODE#"),
		"VARIABLE_ALIASES" => Array(
		)
	)
);?>
<div class="pereustupkiMainDescr" id="down">
<h3>Откуда возникают переуступки?</h3>
<img src="/bitrix/templates/szvdom/images/pereusBigPic.jpg" alt="Переуступки" title="Переуступки" style="padding: 20px 0 0; width:690px">
	<p>
 <span class="bold">Первая причина</span> – это инвестиционные сделки на первичном рынке. Стоимость жилья с момента начала строительства и до приемки дома государственной комиссией возрастает на 30-50%. В некоторых случаях данная величина может отличаться от заявленных цифр в большую сторону. Все зависит от спроса и предложения в данный момент времени.
	</p>
	<p>
 <span class="bold">Вторая причина</span> – это изменение обстоятельств у клиентов, которые решили купить квартиру для проживания.
	</p>
	<p>
		 Если вторая причина не зависит от времени и является субъективной причиной, то инвесторы ждут максимальной цены на объекте и начинают реализовывать квартиры на стадии, близкой к сдаче дома и подписанию акта приема- передачи. Как правило, это быстрые сделки, не размазанные во времени. Они ограничены законом во времени. Вот здесь-то, как раз, и кроятся плюсы для будущих покупателей. Для реализации квартир нужна реклама. Биться с рекламными бюджетами строительных компаний клиенты не в состоянии. Соответственно, для того, чтобы быстро продать свою квартиру (переуступить права требования), им приходится скидывать цену по сравнению с ценами застройщика. Иногда разница в цене очень значительна.
	</p>
	<p>
		 Переуступить можно как договор долевого участия (ДДУ), так и договор паевого взноса (ЖСК). В случае с ДДУ - уступка проходит государственную регистрацию в УФРС, так как является неотъемлемой частью основного договора.
	</p>
	<p>
 <span class="bold">Уступка права требования</span> по закону об участии в долевом строительстве разрешается только в случае, если первоначальный договор долевого участия был зарегистрирован, и при условии полной оплаты дольщиком всей суммы договора. Либо в случае неуплаты всей суммы договора долевого участия уступка допускается только лишь с переводом долга на нового дольщика
	</p>
	<p>
		 В соответствии с законом долевого участия <span class="bold">переуступка права требования</span> по договору долевого участия допускается с момента регистрации договора долевого участия и до момента подписания сторонами акта прямой передачи квартиры.
	</p>
	<p>
		 ЖСК же регистрирует сам Застройщик, являясь гарантом сделки.
	</p>

</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>