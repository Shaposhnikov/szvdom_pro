<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<? $APPLICATION->AddChainItem("Главная", "/"); ?>
<? $APPLICATION->AddChainItem("Вторичная", "/vtorichnaja/"); ?>

<? CModule::IncludeModule("iblock"); ?>

<?

$iblockId = 3;
$sectionId = 16;
$arFilter = Array('IBLOCK_ID' => $iblockId, 'ID' => $sectionId);

$arSelect = array("ID","IBLOCK_ID","NAME","PICTURE","DESCRIPTION","CODE","DETAIL_PICTURE","UF_DESCRIPTION");
    
$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false,$arSelect,false);
while($ar_result = $db_list->GetNext())
{
    $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(
        $iblockId,
        $sectionId
    );
    $ar_result["SEO"] = $ipropValues->getValues();
    $section = $ar_result;
}
?>
<div class="similarOnePage">
    
<? if ($APPLICATION->GetCurPage() == '/vtorichnaja/') : ?>
    <h1><?=$section["SEO"]["SECTION_PAGE_TITLE"];?> </h1>
<? endif; ?>

<?  if (($APPLICATION->GetCurPage() == '/vtorichnaja/') && (count($_GET) == 0)) { ?>

    <div class="similarOnePageDescription"><?=$section["DESCRIPTION"];?></div>
    
<? } ?>
	<div class="notMainPageMenu">

<? $APPLICATION->IncludeComponent(
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

<? if (dirname($APPLICATION->GetCurPage()) == "/") : ?>
<? $APPLICATION->IncludeComponent(
		"bitrix:catalog.smart.filter",
		"vtorichnaja",
		array(
			"IBLOCK_TYPE" => "vtorichnaja",
			"IBLOCK_ID" => "8",
			"SECTION_ID" => "78",
			"SECTION_CODE" => "vtorichnaja",
            "USE_FILTER" => "Y",
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

<? $curpage = $APPLICATION->GetCurPage();

global $arrFilter;
$arrFilter = $_SESSION['filter'];

$show_catalog = false;
$show_catalog = ($curpage == "/vtorichnaja/") && (count($_GET) != 0);
$show_catalog = $show_catalog || ((dirname($curpage) == "/vtorichnaja") && (count($_GET) == 0));

if ($show_catalog)
{

?>
<?

$APPLICATION->IncludeComponent("bitrix:catalog", "vtorichnaja", Array(
	"IBLOCK_TYPE" => "vtorichnaja",	// Тип инфоблока
		"IBLOCK_ID" => "8",	// Инфоблок
		"SECTION_ID" => "78",
		"USE_SELECT_TEMP" => "Y",
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
		"MESS_BTN_COMPARE" => "Сравнение",	// Текст кнопки "Сравнение"
		"MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
		"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
		"DETAIL_USE_VOTE_RATING" => "N",	// Включить рейтинг товара
		"DETAIL_USE_COMMENTS" => "N",	// Включить отзывы о товаре
		"DETAIL_BRAND_USE" => "N",	// Использовать компонент "Бренды"
		"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"CACHE_TYPE" => "N",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"SET_STATUS_404" => "Y",	// Устанавливать статус 404, если не найдены элемент или раздел
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
		"ADD_ELEMENT_CHAIN" => "Y",	// Включать название элемента в цепочку навигации
		"USE_ELEMENT_COUNTER" => "Y",	// Использовать счетчик просмотров
		"USE_FILTER" => "Y",	// Показывать фильтр
		"FILTER_VIEW_MODE" => "HORIZONTAL",	// Вид отображения умного фильтра
		"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"USE_COMPARE" => "N",	// Разрешить сравнение товаров
		"PRICE_CODE" => "",	// Тип цены
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
		"BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
		"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
		"PRODUCT_PROPERTIES" => "",	// Характеристики товара, добавляемые в корзину
		"SHOW_TOP_ELEMENTS" => "N",	// Выводить топ элементов
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
		"SECTION_COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
		"SECTION_TOP_DEPTH" => "2",	// Максимальная отображаемая глубина разделов
		"SECTIONS_VIEW_MODE" => "LIST",	// Вид списка подразделов
		"SECTIONS_SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
		"PAGE_ELEMENT_COUNT" => "19",	// Количество элементов на странице
		"LINE_ELEMENT_COUNT" => "4",	// Количество элементов, выводимых в одной строке таблицы
		"ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем товары в разделе
		"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки товаров в разделе
		"ELEMENT_SORT_FIELD2" => "id",	// Поле для второй сортировки товаров в разделе
		"ELEMENT_SORT_ORDER2" => "desc",	// Порядок второй сортировки товаров в разделе
		"LIST_PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
		"LIST_META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства раздела
		"LIST_META_DESCRIPTION" => "-",	// Установить описание страницы из свойства раздела
		"LIST_BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства раздела
		"DETAIL_PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"DETAIL_META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"DETAIL_META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"DETAIL_BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",	// Использовать код группы из переменной, если не задан раздел элемента
		"DETAIL_DISPLAY_NAME" => "Y",	// Выводить название элемента
		"DETAIL_DETAIL_PICTURE_MODE" => "IMG",	// Режим показа детальной картинки
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",	// Добавлять детальную картинку в слайдер
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",	// Показ описания для анонса на детальной странице
		"LINK_IBLOCK_TYPE" => "undefined",	// Тип инфоблока, элементы которого связаны с текущим элементом
		"LINK_IBLOCK_ID" => "undefined",	// ID инфоблока, элементы которого связаны с текущим элементом
		"LINK_PROPERTY_SID" => "undefined",	// Свойство, в котором хранится связь
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",	// URL на страницу, где будет показан список связанных элементов
		"USE_STORE" => "N",	// Показывать блок "Количество товара на складе"
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"PAGER_TITLE" => "Товары",	// Название категорий
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
"ADD_PICT_PROP" => "MORE_PHOTO", // Дополнительная картинка основного товара
		"LABEL_PROP" => "-",	// Свойство меток товара
		"TOP_VIEW_MODE" => "SECTION",
		"SEF_FOLDER" => "/vtorichnaja/",	// Каталог ЧПУ (относительно корня сайта)
		"VARIABLE_ALIASES" => array(
			"sections" => "",
			"section" => "",
			"element" => "",
			"element_inner_page" => "",
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		),
		"FILTER_NAME" => "",	// Фильтр
		"FILTER_FIELD_CODE" => array(	// Поля
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"FILTER_PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "undefined",
			2 => "",
		),
		"FILTER_PRICE_CODE" => "",	// Тип цены
		"SEF_URL_TEMPLATES" => Array("sections"=>"","section"=>"","element"=>"#ELEMENT_CODE#/","element_inner_page"=>"#ELEMENT_CODE#/#INNER_PAGE_CODE#/","compare"=>"compare.php?action=#ACTION_CODE#")
	),
	false
);

?>

<? } ?>


<? if (($APPLICATION->GetCurPage() == "/vtorichnaja/") && (count($_GET) == 0)): ?>
<? require_once('carousel_fast_sale.php'); ?>
<? endif; ?>

<? if ($APPLICATION->GetCurPage() == "/vtorichnaja/") :

?> 
	<div class="firstAnotherDescription" style="width: 976px;">
		 <?=htmlspecialchars_decode($section["UF_DESCRIPTION"]);?>
	</div>
<? endif; ?>
</div>

    <div id="elementPopUp">
        <div id="elementPopUpWindow"></div>
    </div>
    <div id="elementPopUpWindowOverlay" onclick="$('#elementPopUp').fadeOut(500);$(this).fadeOut(500);"></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>