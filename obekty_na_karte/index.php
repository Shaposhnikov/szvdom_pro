<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->AddChainItem("Главная", "/");
$APPLICATION->AddChainItem("Объекты на карте", "");
CModule::IncludeModule("iblock");
$APPLICATION->AddHeadString('<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>', true);
$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
$iblockId = 3;
$sectionId = 19;
$arFilter = Array('IBLOCK_ID' => $iblockId, 'GLOBAL_ACTIVE' => 'Y', 'ID' => $sectionId);
$arSelect = array(
    "ID",
    "IBLOCK_ID",
    "NAME",
    "PICTURE",
    "DESCRIPTION",
    "CODE",
    "DETAIL_PICTURE",
    "UF_DESCRIPTION"
);
$db_list = CIBlockSection::GetList(Array($by => $order), $arFilter, false, $arSelect, false);
while ($ar_result = $db_list->GetNext()) {
    $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(
        $iblockId,
        $sectionId
    );
    $ar_result["SEO"] = $ipropValues->getValues();
    $section = $ar_result;
}
if (!empty($section["SEO"]["SECTION_META_KEYWORDS"])) {
    $APPLICATION->SetPageProperty("keywords", $section["SEO"]["SECTION_META_KEYWORDS"]);
} else {
    $APPLICATION->SetPageProperty("keywords", $section["NAME"]);
}
if (!empty($section["SEO"]["SECTION_META_DESCRIPTION"])) {
    $APPLICATION->SetPageProperty("description", $section["SEO"]["SECTION_META_DESCRIPTION"]);
} else {
    $APPLICATION->SetPageProperty("description", $section["NAME"]);
}
if (!empty($section["SEO"]["SECTION_META_TITLE"])) {
    $APPLICATION->SetPageProperty("title", $section["SEO"]["SECTION_META_TITLE"]);
} else {
    $APPLICATION->SetPageProperty("title", $section["NAME"]);
}
?>

    <div class="similarOnePage">
        <h1>
            <?= $section["SEO"]["SECTION_PAGE_TITLE"]; ?>
        </h1>
        <? if (!empty($section["UF_DESCRIPTION"])) { ?>
            <div class="firstAnotherDescription" style="width: 976px;">
                <?= $section["UF_DESCRIPTION"] ?>
            </div>
        <? } ?>
    </div>

    <div class="similarOnePageDescription">
        <?= $section["DESCRIPTION"]; ?>
    </div>

<? $arSelect = Array(
    "ID",
    "IBLOCK_ID",
    "IBLOCK_SECTION_ID",
    "NAME",
    "CODE",
    "ACTIVE",
    "DETAIL_PAGE_URL",
    "PREVIEW_PICTURE",
    "PREVIEW_TEXT",
    "PREVIEW_PICTURE",
    "PROPERTY_REGION",
    "PROPERTY_LATITUDE",
    "PROPERTY_LONGITUDE",
    "PROPERTY_ADDRESS",
    "PROPERTY_SECOND_ID",
    "PROPERTY_SHOW_THIS_ON_MAIN",
    "PROPERTY_SHOW_ON_MAP"
);
$first = true;

$arFilter = Array("IBLOCK_ID" => 1, "SECTION_ID" => 1);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $buf = $ob->GetFields();
    $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $buf["PROPERTY_SECOND_ID_VALUE"] . "']");
    $imago = (string)$blocks[0]["avatar"];
    if (!empty($buf["PREVIEW_PICTURE"])) {
        $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
        $buf["PREVIEW_PICTURE"] = "" . $image["SRC"];
    } else {
        $buf["PREVIEW_PICTURE"] = "/include/images/" . $imago;
    }
    if ($buf["ACTIVE"] == "N") {
        $specTemp = true;
    } else {
        $specTemp = false;
    }
    if (strtolower($buf["PROPERTY_SHOW_ON_MAP_VALUE"]) != "нет") {
        $mapSimalarLabel[] = array(
            "Y" => (float)$buf ["PROPERTY_LONGITUDE_VALUE"],
            "X" => (float)$buf ["PROPERTY_LATITUDE_VALUE"],
            "NAME" => (string)$buf ["NAME"],
            "URL" => (string)$buf ["DETAIL_PAGE_URL"],
            "REGION" => (string)$buf ["PROPERTY_REGION_VALUE"],
            "ADDRESS" => (string)$buf ["PROPERTY_ADDRESS_VALUE"],
            "IMG" => (string)$buf["PREVIEW_PICTURE"],
            "SPEC_TEMP" => $specTemp
        );
    }
}
?>
    <script type="text/javascript">
        var myMap2;
        ymaps.ready(init);
        function init() {
            var myMap2 = new ymaps.Map("mapMain", {
                    center: [<?=$mapSimalarLabel[0]["X"]?>, <?=$mapSimalarLabel[0]["Y"]?>],
                    zoom: 9
                }),
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
                ),
                MyBalloonContentLayout2 = ymaps.templateLayoutFactory.createClass(
                    '<div class="mainPageMapPopover">' +
                    '<div class="popover-content">' +
                    '<span style="font-size: 13px;padding-bottom: 5px;font-family: Bold;">$[properties.balloonContent]</span>' +
                    '<br/>' +
                    '<span style="font-size: 13px;padding-bottom: 5px;">+7(812) 902-50-50 </span>' +
                    '<br/>' +
                    '<a style="line-height: 25px; height: 25px;width: 205px;" data-who="footer_feedback" class="showIt buttonGreen" onclick="mapClick($(this));">ЗАКАЗАТЬ ЗВОНОК</a>' +
                    '</div></div>'
                );
            myMap2.geoObjects
                <?foreach ($mapSimalarLabel as $key => $value){
                if ($key < 100){
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
            <?if ($key == (count($mapSimalarLabel) - 1)){echo ";";}?>
            <?
            }
            }?>
        }
        function mapClick(value) {
            var who = value.data('who');
            if (who == "popUpSelect") {
                tp = value.data('type');
                changeRightColumnPopUp(tp);
                if (tp !== "По метро") {
                    $('.popUpSelectInner #rightColumnPopUp').css('height', '660px');
                } else {
                    $('.popUpSelectInner #rightColumnPopUp').css('height', '798px');
                }
            }
            $('.' + who).fadeIn(500);
            $('.popUpWindowOverlay').css('display', 'block');
            var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $(this).outerHeight();
            if (WH < PH) {
                if (ST + WH > DH - 10) {
                    $('.feedbackWrap').css({bottom: '10px', top: ''});
                } else {
                    $('.feedbackWrap').css('top', 50 + ST);
                }
            } else {
                $('.feedbackWrap').css('top', 50 + ST);
            }
        }
    </script>

    <div id='mapMain' style="width: 1056px;height: 600px;margin-top: -20px;margin-bottom: 30px;"></div>
    <div class="whatAreQuestion">
        <p class="whatAreQuestionText">
            <span class="watqtBig">Возникли вопросы?</span>
            <br/>
    <span class="watqtLittle">Бесплатная консультация и подбор жилья по телефону
    <br/>
   <span class="ya-elama-phone call_phone_1">+7(812) 902-50-50</span> <a data-who="footer_feedback" class="showIt">оставить заявку</a></span>
        </p>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>