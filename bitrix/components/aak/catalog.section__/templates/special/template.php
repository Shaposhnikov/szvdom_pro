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
$APPLICATION->AddHeadString('<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>', true);
$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object"); ?>
<? $dontShowPagen = false;
if (!isset($_GET["set_filter"]) && empty($arParams["FILT_REQ"])){
	unset($arResult["ITEMS"]);
}
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
            $buf["PREVIEW_PICTURE"] = $image;
        }
        $arResult["ITEMS"][] = $buf;
    }
    $dontShowPagen = true;
}

foreach ($arResult['ITEMS'] as $key => $value) {
    $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $value["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
    if (!empty($value["PREVIEW_PICTURE"])  && $value["PREVIEW_PICTURE"]["SRC"] != "/bitrix/components/bitrix/catalog.section/templates/special/images/no_photo.png") {
        if (!empty($value["PREVIEW_PICTURE"]["SRC"])){
            $image["SRC"]  = $value["PREVIEW_PICTURE"]["SRC"];
        }else{
            $image = CFile::GetFileArray($value["PREVIEW_PICTURE"]);
        }
    } else {
        $image["SRC"] = "/include/images/" . (string)$blocks[0]["avatar"];
    }

    $arResult['ITEMS'][$key]["NOW_PICTURE"] = $image;

    if (strtolower($value["PROPERTIES"]["SHOW_ON_MAP"]["VALUE"]) != "нет"){ 
	    if ($value["ACTIVE"] == "N"){
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
	    );
	}
}

/*
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
}*/


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
        if (!empty($value["PREVIEW_PICTURE"])  && $buf["PREVIEW_PICTURE"]["SRC"] != "/bitrix/components/bitrix/catalog.section/templates/special/images/no_photo.png") {
            $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
        } else {
            $image["SRC"] = "/include/images/" . (string)$blocks[0]["avatar"];
        }

        if (strtolower($buf["PROPERTIES"]["SHOW_ON_MAP"]["VALUE"]) != "нет"){ 
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

}
if ($arParams["SELECT_IMG"] !== false){
    echo "<img width='228' height='60' class='selectLogoImage' src='".$arParams["SELECT_IMG"]."' alt='".$arResult["NAME"]."' title='".$arResult["NAME"]."' />";
}
?>
    <div class="buildMainPage">

        <!-- <p class="buildMainPageTitle">Объекты на карте:</p> -->
        <? if (!empty($arMap)) { ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#toggle2 a').click(function(){
                        $('#toggle a').trigger('click');
                    })
                    $('.mapHead .buttonGreen').click(function(){
                        $('.mapWindow').fadeOut(100);
                        $('.mapWindowOverlay').fadeOut(100);
                        $('#toggle').data('status','close');
                    });
                });
                ymaps.ready(init);
                function init() {
                    var myMap;
                    $('#toggle').bind({
                        click: function () {
                            if ($(this).data('map') == "empty") {
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
                                        '<img width="120" class="mainPageMapPopoverImg" src="$[properties.balloonContentSrc]" />' +
                                        '<div class="popover-content"><span>$[properties.balloonContent]</span><br/>' +
                                        '<span>$[properties.balloonContent2]</span><br/><br/>' +
                                        '<div><a href="$[properties.balloonContentUrl]">Описание</a><a class="sec" href="$[properties.balloonContentUrl]tseny-na-kvartiry/">Цены</a><a class="sec" href="$[properties.balloonContentUrl]planirovki/">Планировки</a></div>' +
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
                                            balloonContent2: '<?if (!empty($value["ADDRESS"])){echo $value["ADDRESS"]."<br/>";}?><?=$value["REGION"][0]?>',
                                            balloonContentSrc: '/thumb/120x0xcut<?=$value["IMG"]?>',
                                            balloonContentUrl: '<?=$value["URL"]?>'
                                        },
                                        {
                                            balloonShadow: true,
                                            balloonLayout: MyBalloonLayout,
                                            balloonContentLayout: MyBalloonContentLayout,
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

                                $(this).data('map', "create");
                                $(this).data('status', "open");
                                $('.mapWindow ').fadeIn(500);
                                $('.mapWindowOverlay').css('display', 'block');

                            } else {
                                if ($(this).data('status') == "close") {
                                    $('.mapWindow ').fadeIn(500);
                                    $('.mapWindowOverlay').css('display', 'block');
                                    $(this).data('status', "open");
                                } else {
                                    $('.mapWindow ').fadeOut(500);
                                    $('.mapWindowOverlay').css('display', 'none');
                                    $(this).data('status', "close");
                                }
                            }
                        }
                    });


                }
            </script>
            <div id="toggle" data-status="close" data-map="empty" style="margin-left: -38px;margin-bottom: 25px;background-image:none;height:auto;">
<!--                 <div class="teaserBody">
                    <span class="mapText">
                        К сожалению, по причинам, не зависящим от нас,
                        <br/> 
                        мы не можем рекламировть определенные объекты.
                        <br/> 
                        Полная информация о всех объектах
                        <br/>
                        <a href="javascript:void(0)" class="clickPiece">представлена на карте</a>
                    </span>
                </div> -->
                <a href="javascript:void(0)" class="buttonGreen clickPiece allObjects"><span><img src="/bitrix/templates/szvdom/images/mapButt.png">  Все объекты на карте</span></a>
            </div>
            <div class="mapWindow" style="top: 50px;margin-left: -38px;position:fixed;">
                <div class="mapHead">Бесплатная консультация и подбор жилья:  +7(812) 406-11-48 <a data-who="footer_feedback" class="buttonGreen showIt">ЗАКАЗАТЬ ЗВОНОК</a> </div>
                <div class="closeMapPopUp" onclick="$('.mapWindow').fadeOut(500);$('.mapWindowOverlay').fadeOut(500);$('#toggle').data('status','close');$('#toggle2').data('status','close');"></div>
                <div class="mapkBody">
                    <div id="specMap" class="popUpMap"></div>
                </div>
            </div
        <?
        }
        if (!empty($arResult['ITEMS'])) {
            $random = rand(2,18);
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
                            <a style="margin-top: -7px;" href="<?=$value["DETAIL_PAGE_URL"]?>" class="pseudoButton">от <span><?= number_format($value["PROPERTIES"]["FLATCOST_PUBLIC"]["VALUE"][0], 0, ',', ' '); ?></span> Р</a>
                        </a>

                        <div class="hiddenDataLi"  onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'">
                           <div class="catalog_adv_title">Преимущества</div>
                           <div class="catalog_adv_text">
                                <span class="catalog_adv_bold"><?=$value["NAME"]?></span>
                               <ul>
                                <? foreach ($value["PROPERTIES"]["BENEFITS_MAIN"]["VALUE"] as $key => $str) {
                                    if ($key > 3){continue;}
                                    echo "<li><span>" . $str . "</span></li>";
                                } ?>
                               </ul>
                               <a href="<?=$value["DETAIL_PAGE_URL"]?>" class="catalog_adv_a">Описание объекта</a>
                               <div class="gray_hr"></div>
                               <a class="catalog_adv_a_akc" href="<?=$value["DETAIL_PAGE_URL"]?>?anchor=specblcs">Акции и скидки</a>
                           </div>
                        </div>

                    </li>
                <?
                    if ($mainKey == $random){?>
                        <li style="position:relative;max-height: 360px;">
                            <a style="height: 364px; display: block; width: 225px; position:relative " data-who="footer_feedback" class="showIt catalog_woman">
               <span class="catalog_woman_span">Бесплатно для вас!</span>
			   <ul>
					<li><span>консультация по объектам</span></li>
					<li><span>подбор жилья по параметрам</span></li>
					<li><span>подача заявки в ипотеку</span></li>
					<li><span>помощь юриста</span></li>
					<li><span>и многое другое!</span></li>
			   </ul>
			   <div class="green_hr"></div>
			   <div class="catalog_woman_tel">
			   <p>Звоните по телефону:</p>
			   <span class="ya-elama-phone call_phone_1">+7(812) 902-50-50</span>
			    
			   </div>
			  <div class="catalog_woman_but">Отправить заявку</div>
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
            <div id="toggle2" data-status="close" data-map="empty" style="    margin: 0 auto;margin-bottom: 25px;background-image:none;height:auto;">
                <a href="javascript:void(0)" class="buttonGreen clickPiece allObjects"><span><img src="/bitrix/templates/szvdom/images/mapButt.png">  Смотреть все объекты</span></a>
            </div>  
<div class="mapWindowOverlay" onclick="$('.mapWindow').fadeOut(500);$(this).fadeOut(500);$('#toggle').data('status','close');$('#toggle2').data('status','close');"></div>
