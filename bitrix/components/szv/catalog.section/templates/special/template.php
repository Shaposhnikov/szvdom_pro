<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$APPLICATION->AddHeadString('<!--noindex--><script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script><!--/noindex-->', true);
$xml = simplexml_load_file("http://szv.ayers.ru/include/xml/SiteData.xml") or die("Error: Cannot create object"); ?><? $dontShowPagen = false;
if (!empty($arParams["FILT_OBJ"])) {
    $arSelect = Array(
        "ID",
        "NAME",
        "ACTIVE",
        "DETAIL_PAGE_URL",
        "PREVIEW_PICTURE",
        "PREVIEW_TEXT",
        "PROPERTY_SHOW_THIS_ON_MAIN"
    );
    $propSelect = array(
        "PROPERTY_REGION",
        "PROPERTY_SUBWAYS",
        "PROPERTY_ADDRESS",
        "PROPERTY_BUILDER",
        "PROPERTY_ENDINGPERIOD",
        "PROPERTY_FLATCOST"
    );
    $arFilter = Array("IBLOCK_ID" => 1, "SECTION_ID" => 1, "ID" => $arParams["FILT_OBJ"]);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while ($ob = $res->GetNextElement()) {
        $buf = $ob->GetFields();
        $bufProp = $ob->GetProperties($propSelect);
        $buf["PROPERTIES"] = $bufProp;
        if (!empty($buf["PREVIEW_PICTURE"]) ) {
            $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
            $buf["PREVIEW_PICTURE"] = $image["SRC"];
        }
        $arResult["ITEMS"][] = $buf;
    }
    $dontShowPagen = true;
}

foreach ($arResult['ITEMS'] as $key => $value) {
    $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $value["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
    if (!empty($value["PREVIEW_PICTURE"])  && $value["PREVIEW_PICTURE"]["SRC"] != "/bitrix/components/bitrix/catalog.section/templates/special/images/no_photo.png") {
        $image = CFile::GetFileArray($value["PREVIEW_PICTURE"]);
    } else {
        $image["SRC"] = "/include/images/" . (string)$blocks[0]["avatar"];
    }
    $arResult['ITEMS'][$key]["NOW_PICTURE"] = $image;
/*    if ($value["ACTIVE"] == "N"){
        $specTemp = true;
    }else{
        $specTemp = false;
    }
    $arMap[] = array(
        "X" => $value["PROPERTIES"]["LATITUDE"]["VALUE"],
        "Y" => $value["PROPERTIES"]["LONGITUDE"]["VALUE"],
        "NAME" => $value["NAME"],
        "REGION" => $value["PROPERTIES"]["REGION"]["VALUE"],
        "ADDRESS" => $value["PROPERTIES"]["ADDRESS"]["VALUE"],
        "URL" => $value["DETAIL_PAGE_URL"],
        "IMG" => $image["SRC"],
        "SPEC_TEMP" => $specTemp
    );*/

}
$propSelect = array(
    "PROPERTY_REGION",
    "PROPERTY_SUBWAYS",
    "PROPERTY_ADDRESS",
    "PROPERTY_BUILDER",
    "PROPERTY_ENDINGPERIOD",
    "PROPERTY_FLATCOST"
);
$arSelect = Array(
    "ID",
    "NAME",
    "ACTIVE",
    "DETAIL_PAGE_URL",
    "PREVIEW_PICTURE",
    "PREVIEW_TEXT",
    "PROPERTY_SHOW_THIS_ON_MAIN"
);
$arFilter = Array("IBLOCK_ID" => 1, "SECTION_ID" => 1);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $buf2 = $ob->GetFields();
    $bufProp2 = $ob->GetProperties($propSelect);
    $buf2["PROPERTIES"] = $bufProp2;
    if (!empty($buf["PREVIEW_PICTURE"]) ) {
        $image = CFile::GetFileArray($buf2["PREVIEW_PICTURE"]);
        $buf2["PREVIEW_PICTURE"] = $image["SRC"];
    }
    $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $buf2["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
    if (!empty($buf2["PREVIEW_PICTURE"])  && $buf2["PREVIEW_PICTURE"]["SRC"] != "/bitrix/components/bitrix/catalog.section/templates/special/images/no_photo.png") {
        $image = CFile::GetFileArray($buf2["PREVIEW_PICTURE"]);
    } else {
        $image["SRC"] = "/include/images/" . (string)$blocks[0]["avatar"];
    }

    if ($buf2["ACTIVE"] == "N"){
        $specTemp = true;
    }else{
        $specTemp = false;
    }
    $arMap[] = array(
        "X" => $buf2["PROPERTIES"]["LATITUDE"]["VALUE"],
        "Y" => $buf2["PROPERTIES"]["LONGITUDE"]["VALUE"],
        "NAME" => $buf2["NAME"],
        "REGION" => $buf2["PROPERTIES"]["REGION"]["VALUE"],
        "ADDRESS" => $buf2["PROPERTIES"]["ADDRESS"]["VALUE"],
        "URL" => $buf2["DETAIL_PAGE_URL"],
        "IMG" => $image["SRC"],
        "SPEC_TEMP" => $specTemp
    );
}


if (!empty($arParams["MOAR_OBJECT_FOR_MAP"])){
    $arSelect = Array(
        "ID",
        "NAME",
        "ACTIVE",
        "DETAIL_PAGE_URL",
        "PREVIEW_PICTURE",
        "PREVIEW_TEXT",
        "PROPERTY_SHOW_THIS_ON_MAIN"
    );
    $propSelect = array(
        "PROPERTY_REGION",
        "PROPERTY_SUBWAYS",
        "PROPERTY_ADDRESS",
        "PROPERTY_BUILDER",
        "PROPERTY_ENDINGPERIOD",
        "PROPERTY_FLATCOST"
    );

    $arFilter = Array("IBLOCK_ID" => 1, "SECTION_ID" => 1, "ID" => $arParams["MOAR_OBJECT_FOR_MAP"]);
    $resMap = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while ($ob = $resMap->GetNextElement()) {
        $buf = $ob->GetFields();
        $bufProp = $ob->GetProperties($propSelect);
        $buf["PROPERTIES"] = $bufProp;
        if (!empty($buf["PREVIEW_PICTURE"]) ) {
            $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
            $buf["PREVIEW_PICTURE"] = $image["SRC"];
        }
        $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $buf["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
        if (!empty($value["PREVIEW_PICTURE"])  && $buf["PREVIEW_PICTURE"]["SRC"] != "/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png") {
            $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
        } else {
            $image["SRC"] = "/include/images/" . (string)$blocks[0]["avatar"];
        }
        if ($buf["ACTIVE"] == "N"){
            $specTemp = true;
        }else{
            $specTemp = false;
        }
        $arMap[] = array(
            "X" => $buf["PROPERTIES"]["LATITUDE"]["VALUE"],
            "Y" => $buf["PROPERTIES"]["LONGITUDE"]["VALUE"],
            "NAME" => $buf["NAME"],
            "REGION" => $buf["PROPERTIES"]["REGION"]["VALUE"],
            "ADDRESS" => $buf["PROPERTIES"]["ADDRESS"]["VALUE"],
            "URL" => $buf["DETAIL_PAGE_URL"],
            "IMG" => $image["SRC"],
            "SPEC_TEMP" => $specTemp
        );
    }

}
if ($arParams["SELECT_IMG"] !== false){
    echo "<img width='228' height='60' class='selectLogoImage' src='".$arParams["SELECT_IMG"]."' alt='".$arResult["NAME"]."' title='".$arResult["NAME"]."' />";
}
?>
    <div class="mainnPageInfo">
        <p><span class="boldText" style="margin-right: 10px;">ВОЗНИКЛИ ВОПРОСЫ? ПОЗВОНИТЕ!</span> Бесплатная консультация и подбор жилья: <span class="ya-elama-phone call_phone_1">+7(812) 902-50-50</span> <a data-who="footer_feedback" class="showIt">оставьте заявку</a></p>
    </div>
    <div class="buildMainPage">

        <p class="buildMainPageTitle">Объекты на карте:</p>
        <? if (!empty($arMap)) { ?>
            <!--noindex--><script type="text/javascript">
                var myMap,
                    bigMap = false;
                ymaps.ready(init);
                function init() {
                    var myMap = new ymaps.Map("specMap", {
                                center: [<?=$arMap[0]["X"]?>, <?=$arMap[0]["Y"]?>],
                                zoom: 9,
                                controls: ['smallMapDefaultSet']
                            },
                            {autoFitToViewport: 'always'}
                        ),
                        MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
                            '<div class="popover top">' +
                            '<a class="close" href="#"></a>' +
                            '<div class="arrow"></div>' +
                            '<div class="popover-inner">' +
                            '$[[options.contentLayout observeSize minWidth=280 maxWidth=400 maxHeight=350]]' +
                            '</div>' +
                            '</div>', {

                                build: function () {
                                    this.constructor.superclass.build.call(this);

                                    this._$element = $('.popover', this.getParentElement());

                                    this.applyElementOffset();

                                    this._$element.find('.close')
                                        .on('click', $.proxy(this.onCloseClick, this));
                                },


                                clear: function () {
                                    this._$element.find('.close')
                                        .off('click');

                                    this.constructor.superclass.clear.call(this);
                                },


                                onSublayoutSizeChange: function () {
                                    MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);

                                    if (!this._isElement(this._$element)) {
                                        return;
                                    }

                                    this.applyElementOffset();

                                    this.events.fire('shapechange');
                                },


                                applyElementOffset: function () {
                                    this._$element.css({
                                        left: -(this._$element[0].offsetWidth / 2),
                                        top: -(this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight)
                                    });
                                },


                                onCloseClick: function (e) {
                                    e.preventDefault();

                                    this.events.fire('userclose');
                                },


                                getShape: function () {
                                    if (!this._isElement(this._$element)) {
                                        return MyBalloonLayout.superclass.getShape.call(this);
                                    }

                                    var position = this._$element.position();

                                    return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
                                        [position.left, position.top], [
                                            position.left + this._$element[0].offsetWidth,
                                            position.top + this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight
                                        ]
                                    ]));
                                },

                                _isElement: function (element) {
                                    return element && element[0] && element.find('.arrow')[0];
                                }
                            }),
                        MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
                            '<div class="mainPageMapPopover">' +
                            '<img width="120" class="mainPageMapPopoverImg" src="$[properties.balloonContentSrc]" />'+
                            '<div class="popover-content"><span>$[properties.balloonContent]</span><br/>'+
                            '<span>$[properties.balloonContent2]</span><br/><br/>'+
                            '<div><a href="$[properties.balloonContentUrl]">Описание</a><a class="sec" href="$[properties.balloonContentUrl]tseny-na-kvartiry/">Цены</a><a class="sec" href="$[properties.balloonContentUrl]planirovki/">Планировки</a></div>'+
                            '</div></div>'
                        ),
                        MyBalloonContentLayout2 = ymaps.templateLayoutFactory.createClass(
                            '<div class="mainPageMapPopover">' +
                            '<div class="popover-content">' +
                            '<span style="font-size: 13px;padding-bottom: 5px;font-family: Bold;">$[properties.balloonContent]</span>' +
                            '<br/>'+
                            '<span style="font-size: 13px;padding-bottom: 5px;">+7(812) 902-50-50 </span>'+
                            '<br/>'+
                            '<a style="line-height: 25px; height: 25px;width: 205px;" data-who="footer_feedback" class="buttonGreen showIt">ЗАКАЗАТЬ ЗВОНОК</a>'+
                            '</div></div>'
                        );

                    myMap.geoObjects
                        <?foreach ($arMap as $key => $value){
                        if (empty($value["X"]) || empty($value["Y"])){
                            continue;
                        }
                        ?>
                        .add(new ymaps.Placemark([<?=$value["X"]?>, <?=$value["Y"]?>],
                            {
                                balloonContent: '<?=$value["NAME"]?>',
                                balloonContent2: '<?if (!empty($value["ADDRESS"])){echo $value["ADDRESS"]."<br/>";}?><?=$value["REGION"]?>',
                                balloonContentSrc: '/thumb/120x0xcut<?=$value["IMG"]?>',
                                balloonContentUrl: '<?=$value["URL"]?>'
                            },
                            {
                                balloonShadow: true,
                                balloonLayout: MyBalloonLayout,
                                balloonContentLayout: <?=($value["SPEC_TEMP"] == true)?"MyBalloonContentLayout2":"MyBalloonContentLayout"?>,
                                balloonCloseButton: true,
                                balloonMinHeight: 100,
                                balloonMinWidth: 200,
                                balloonPanelMaxMapArea: 0,
                                hideIconOnBalloonOpen: false,
                                balloonOffset: [40, -70],
                                iconLayout: 'default#image',
                                iconImageHref: '/bitrix/templates/szvdom/images/mapLabel.png',
                                iconImageSize: [30, 42],
                                iconImageOffset: [-3, -42]
                            }))
                    <?if ($key == (count($arMap) - 1)){echo ";";}?>
                    <?}?>
                    $('#showBigMap').click(toggle);
                }
                function toggle() {
                    bigMap = !bigMap;

                    if (bigMap) {
                        $('#specMap').removeClass('smallMap');
                        $('#showBigMap').html('Свернуть карту');
                    } else {
                        $('#specMap').addClass('smallMap');
                        $('#showBigMap').html('Развернуть карту');
                    }
                    myMap.container.fitToViewport();
                }
            </script><!--/noindex-->
            <div class="specMapBlock" style="padding-bottom: 20px;">
                <div id="specMap" class="smallMap" style="margin-left: -38px;"></div>
                <div id="showBigMap" class="psevdoblue" style="right: -18px;bottom: 20px;">Развернуть карту</div>
            </div>
        <?
        }
        if (!empty($arResult['ITEMS'])) {
            $random = rand(2,8);
            ?>

            <ul>
                <? foreach ($arResult['ITEMS'] as $mainKey => $value) {
                    if ($value["ACTIVE"] == "N"){
                        continue;
                    }
                    $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $value["PROPERTIES"]["SECOND_ID"]["VALUE"]. "']");
                    $imago = (string)$blocks[0]["avatar"];
                    ?>
                    <li>
                        <?
                        if (!empty($value["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"])){
                            echo '<div class="redLabelMark">'.$value["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"].'</div>';
                        }
                        ?>
                        <a href="<?=$value["DETAIL_PAGE_URL"]?>">
                            <?if (!empty($value["PREVIEW_PICTURE"])  && $value["PREVIEW_PICTURE"]["SRC"] != "/bitrix/components/bitrix/catalog.section/templates/special/images/no_photo.png"){
                                echo "<img width='225' height='172' src='/thumb/225x172xcut".$value["PREVIEW_PICTURE"]["SRC"]."' alt='".$value["NAME"]."' title='".$value["NAME"]."' />";
                            }else{
                                if (!empty($imago)){
                                    echo '<img width="225" height="172" src="/thumb/225x172xcut/include/images/'.$imago.'" title="'.$value["NAME"].'" alt="'.$value["NAME"].'" />';
                                }else{
                                    echo "<img width='225' height='172' src='/thumb/225x172xcut/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png' alt='".$value["NAME"]."' title='".$value["NAME"]."' />";
                                }
                            }?>

                            <a href="<?=$value["DETAIL_PAGE_URL"]?>" class="buildName"><?=$value["NAME"]?></a>
                            <div class="buildText">
                                <p style="color:#2579CB;">
                                    <?foreach ($value["PROPERTIES"]["REGION"]["VALUE"] as $key => $subValue) {
                                        if ($key != (count($value["PROPERTIES"]["REGION"]["VALUE"]) - 1)) {?>
                                            <?= $subValue; ?>,
                                        <?} else {?>
                                            <?= $subValue; ?>
                                        <?}
                                    }
                                    if (count($value["PROPERTIES"]["REGION"]["VALUE"]) == 1){
                                        echo ' район';
                                    }else{
                                        echo ' районы';
                                    }
                                    ?>
                                </p>
                                <p style="color:#2579CB;"><span class="subwayLabel inline_m"></span>
                                    <?= $value["PROPERTIES"]["SUBWAYS"]["VALUE"][0]; ?>
                                </p>
                                <p><?=$value["PROPERTIES"]["ADDRESS"]["VALUE"];?></p>
                                <?
                                if ($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"] != false){
                                    if (count($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"]) != 2){?>
                                        <p class="mini_on_ab">
                                            <span style="font-family: Bold;">Срок сдачи: </span>
                                            <?=$value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0];?>
                                            <?if (strtolower($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]) != "сдан"){?>
                                                г.
                                            <?}?>
                                        </p>
                                    <?} else{?>
                                        <p class="mini_on_ab">
                                            <span style="font-family: Bold;">Срок сдачи: </span>
                                            <?if ($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0] != $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][1]){?>
                                                <?=$value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0];?> - <?=$value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][1];?> гг.
                                            <?}else{?>
                                                <?=$value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0];?> г.
                                            <?}?>
                                        </p>
                                    <?
                                    }
                                }
                                ?>
                            </div>
                            <a style="margin-top: -7px;" href="<?=$value["DETAIL_PAGE_URL"]?>" class="pseudoButton">от <span><?= number_format($value["PROPERTIES"]["FLATCOST"]["VALUE"][0], 0, ',', ' '); ?></span> Р</a>
                        </a>
                    </li>
                <?
                    if ($mainKey == $random){?>
                        <li style="position:relative;">
                            <a style="height: 360px; display: block; width: 225px; background: transparent url('/bitrix/templates/szvdom/images/smileGirl.png') no-repeat scroll 0% 100%;" data-who="footer_feedback" class="showIt">
                                <p style="position: absolute; font-family:Reg;font-size:13px; bottom: 15px;left: 30px;color:#FFFFFF;">
                                    <span style="font-family:Bold;display: block;">Бесплатный подбор</span>
                                    по тел.+7(812) 902-50-50
                                </p>
                            </a>
                        </li>
                    <?}
                } ?>
            </ul>

        <? } ?>
    </div>
<? if ($dontShowPagen == false) {
    if ($arParams["DISPLAY_BOTTOM_PAGER"]) {
        ?>
        <? echo $arResult["NAV_STRING"]; ?><?
    }
}

?>