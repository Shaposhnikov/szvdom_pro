<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();/** @var array $arParams */
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
?>
<div class="catalog-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>

<?
//$APPLICATION->IncludeFile("/vtorichnaja/listing.php", Array("arResult"=>$arResult), Array());
?>

<div><a href="javascript:void(0)" data-who="podbor_feedback" class="buttonGreen clickPiece allObjects showIt"><span>заявка на подбор квартиры</span></a></div>
<div style="float:left;padding-left: 25px;padding-top:10px;padding-bottom:10px;">Найдено объектов: <? echo count($arResult['ITEMS']); ?></div>

<? if (!empty($arResult['ITEMS'])) { ?>

<table class="summCharTable" width="100%" style="padding:0 25px;">
        <tbody>
            <tr class="boldText titleTable">
                <th width="25px"></th>
				<th width="45px">ID</th>
                <th width="90px">Кол-во комнат</th>
                <th width="100px">Фото</th>
                <th>Адрес</th>
				<th width="120px">S общ./жил.,м<sup>2</sup>/кух</th>
				<th width="120px">Этаж/Этажность</th>
				<th width="120px">Стоимость</th>
				<th width="120px">Узнать подробнее</th>
				<th width="25px"></th>
            </tr>


            <?foreach($arResult['ITEMS'] as $value)
            {
                $item["ID"] = (!empty($value["ID"]))?$value["ID"]:"";
                $item["ROOM_AMOUNT"] = (!empty($value["PROPERTIES"]["ROOM_AMOUNT"]["VALUE"]))?$value["PROPERTIES"]["ROOM_AMOUNT"]["VALUE"]:"";
                
                $item["MORE_PHOTO"] = "<img width='50' height='50' src='/thumb/50x50xin/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png' alt='".$value["NAME"]."' title='".$value["NAME"]."' />";

                if (!empty($value["PROPERTIES"]["MORE_PHOTO"]["VALUE"]))
                {
                    $image = CFile::GetFileArray($value["PROPERTIES"]["MORE_PHOTO"]["VALUE"][0]);
                    $item["MORE_PHOTO"] = "<img class='popupImage' data-src='".$image["SRC"]."' data-alt='".$value["NAME"]."' src='/thumb/50x50xin".$image["SRC"]."' alt='".$value["NAME"]."' title='".$value["NAME"]."' width='50' height='50' />";
                }
                
                $item["ADDRESS"] = (!empty($value["PROPERTIES"]["ADDRESS"]["VALUE"]))?$value["PROPERTIES"]["ADDRESS"]["VALUE"]:"";
                $item["S_ALL"] = (!empty($value["PROPERTIES"]["S_ALL"]["VALUE"]))?$value["PROPERTIES"]["S_ALL"]["VALUE"]."/":"";
                $item["S_LIVE"] = (!empty($value["PROPERTIES"]["S_LIVE"]["VALUE"]))?$value["PROPERTIES"]["S_LIVE"]["VALUE"]."/":"";
                $item["S_KITCHEN"] = (!empty($value["PROPERTIES"]["S_KITCHEN"]["VALUE"]))?$value["PROPERTIES"]["S_KITCHEN"]["VALUE"]:"";
                $item["ETAJ_LEBEL"] = (!empty($value["PROPERTIES"]["ETAJ_LEBEL"]["VALUE"]))?$value["PROPERTIES"]["ETAJ_LEBEL"]["VALUE"]:"";
                $item["COAST"] = (!empty($value["PROPERTIES"]["COAST"]["VALUE"]))?$value["PROPERTIES"]["COAST"]["VALUE"]:"";
            ?>
                <tr>
					<td onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'"></td>
                    <td onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'"><?=$item["ID"];?></td>
					<td onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'"><?= $item["ROOM_AMOUNT"][0];?></td>
					<td onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'" style="padding: 5px 0;"><?=$item["MORE_PHOTO"];?></td>
					<td onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'"><?=$item["ADDRESS"];?></td>
					<td onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'"><?=$item["S_ALL"];?><?=$item["S_LIVE"];?><?=$item["S_KITCHEN"];?></td>
					<td onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'"><?=$item["ETAJ_LEBEL"];?></td>
					<td onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'"><?=$item["COAST"];?></td>
					<td><a class="showIt" data-who="vtorichnaja_feedback">Задать вопрос</a></td>
                    <td></td>
                </tr>
            <?}?>

	</tbody>
	</table>
<div style="clear: both;"></div>

    <div class="buildMainPage">

    <?if ($arParams["DISPLAY_BOTTOM_PAGER"])
{
    ?>
    <? echo $arResult["NAV_STRING"]; ?><?
}?>
    </div>
<?
}
?>