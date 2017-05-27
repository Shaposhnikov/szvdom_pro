<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
	$arResult["PROPERTIES"]["MAP_OBJECTS"]["VALUE"] = $arParams["MAP"];
	$arResult["PROPERTIES"]["OBJECTS_FOR_THIS"]["VALUE"] = $arParams["OBJECT"];
	$arResult["PROPERTIES"]["OBJECT_SELECTIONS"]["VALUE"] = $arParams["SELECTS"];
    if (!empty($arResult["PROPERTIES"]["MAP_OBJECTS"]["VALUE"])) {
        $arSelect = Array(
            "ID",
            "NAME",
            "ACTIVE",
            "DETAIL_PAGE_URL",
            "PREVIEW_PICTURE",
            "PREVIEW_TEXT",
            "PROPERTY_SHOW_ON_MAP"
        );
        $arFilter = Array("IBLOCK_ID" => 1, "SECTION_ID" => 1, "ID" => $arResult["PROPERTIES"]["MAP_OBJECTS"]["VALUE"]);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->GetNextElement()) {
            $buf = $ob->GetFields();
            $bufProp = $ob->GetProperties($propSelect);
            $buf["PROPERTIES"] = $bufProp;
            $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $buf["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
            $imago = (string)$blocks[0]["avatar"];
            if (!empty($buf["PREVIEW_PICTURE"])) {
                $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
                $buf["PREVIEW_PICTURE"] = "" . $image["SRC"];
            } else {
                $buf["PREVIEW_PICTURE"] = "/include/images/" . $imago;
            }
            $mapArray[] = $buf;
        }
    }
    if (!empty($arResult["PROPERTIES"]["OBJECTS_FOR_THIS"]["VALUE"])) {
        $arSelect = Array(
            "ID",
            "NAME",
            "DETAIL_PAGE_URL",
            "PREVIEW_PICTURE",
            "PREVIEW_TEXT"
        );
        $arFilter = Array("IBLOCK_ID" => 1, "SECTION_ID" => 1, "ID" => $arResult["PROPERTIES"]["OBJECTS_FOR_THIS"]["VALUE"]);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->GetNextElement()) {
            $buf = $ob->GetFields();
            $bufProp = $ob->GetProperties($propSelect);
            $buf["PROPERTIES"] = $bufProp;
            $objectArray[] = $buf;
        }
    }
    if (!empty($arResult["PROPERTIES"]["OBJECT_SELECTIONS"]["VALUE"])) {
        $arSelect = Array(
            "ID",
            "NAME",
            "ACTIVE",
            "DETAIL_PAGE_URL",
            "PREVIEW_PICTURE",
            "PREVIEW_TEXT"
        );
        $arFilter = Array("IBLOCK_ID" => 2, "ID" => $arResult["PROPERTIES"]["OBJECT_SELECTIONS"]["VALUE"]);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->GetNextElement()) {
            $buf = $ob->GetFields();
            $bufProp = $ob->GetProperties($propSelect);
            $buf["PROPERTIES"] = $bufProp;
            $selectArray[] = $buf;
        }
    }


    foreach ($mapArray as $key => $value) {
        if ($value["ACTIVE"] == "N") {
            $specTemp = true;
        } else {
            $specTemp = false;
        }
        if (strtolower($value["PROPERTIES"]["SHOW_ON_MAP"]["VALUE"]) != 'нет') {
            $mapSimalarLabel[] = array(
                "X" => (string)$value["PROPERTIES"]["LATITUDE"]["VALUE"],
                "Y" => (string)$value["PROPERTIES"]["LONGITUDE"]["VALUE"],
                "NAME" => (string)$value["NAME"], "URL" => $value["DETAIL_PAGE_URL"],
                "REGION" => (string)$value["PROPERTIES"]["REGION"]["VALUE"][0],
                "ADDRESS" => (string)$value["PROPERTIES"]["ADDRESS"]["VALUE"],
                "IMG" => (string)$value["PREVIEW_PICTURE"],
                "SPEC_TEMP" => $specTemp
            );
        }

    }


    ?>
    <? if (!empty($mapSimalarLabel)) {
        $APPLICATION->AddHeadString('<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>', true);
        ?>
        <script type="text/javascript">
            var myMap;
            ymaps.ready(init);
            function init() {
                var myMap2 = new ymaps.Map("map", {
                        center: [<?=$mapSimalarLabel[0]["X"]?>, <?=$mapSimalarLabel[0]["Y"]?>],
                        zoom: 9,
                        controls: ['smallMapDefaultSet']
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
                        '<div><a href="$[properties.balloonContentUrl]">Описание</a><a class="sec" href="$[properties.balloonContentUrl]tseny-na-kvartiry/">Цены</a><a class="sec" href="$[properties.balloonContentUrl]foto/">Фото</a></div>' +
                        '</div></div>'
                    ),
                    MyBalloonContentLayout2 = ymaps.templateLayoutFactory.createClass(
                        '<div class="mainPageMapPopover">' +
                        '<div class="popover-content">' +
                        '<span style="font-size: 13px;padding-bottom: 5px;font-family: Bold;">$[properties.balloonContent]</span>' +
                        '<br/>' +
                        '<span style="font-size: 13px;padding-bottom: 5px;">+7(812) 902-50-50 </span>' +
                        '<br/>' +
                        '<a style="line-height: 25px; height: 25px;width: 205px;" data-who="footer_feedback" class="buttonGreen showIt" onclick="mapClick($(this));">ЗАКАЗАТЬ ЗВОНОК</a>' +
                        '</div></div>'
                    );
                myMap2.geoObjects
                    <?foreach ($mapSimalarLabel as $key => $value){?>
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
                <?}?>
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
        <div id='map' style="width: 1056px;height: 400px;"></div>
        <?
    } ?>
    <? if (!empty($objectArray)) {
        ?>
        <div class="similarObjectObjects">
            <p class="elementTitleInner">Объекты</p>

            <div class="buildMainPage" style="padding: 0;width: 1020px;">
                <ul>
                    <? foreach ($objectArray as $value) {
                        $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $value["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
                        $imago = (string)$blocks[0]["avatar"];

                        ?>

                        <li>
                            <a href="<?= $value["DETAIL_PAGE_URL"] ?>">
                                <? if (!empty($value["PREVIEW_PICTURE"]) && $value["PREVIEW_PICTURE"]["SRC"] != "/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png") {
                                    $iiim = CFile::GetFileArray($value["PREVIEW_PICTURE"]);
                                    echo "<img width='225' height='172' src='/thumb/225x172xcut" . $iiim["SRC"] . "' alt='" . $value["NAME"] . "' title='" . $value["NAME"] . "' />";
                                } else {
                                    if (!empty($imago)) {
                                        echo '<img width="225" height="172" src="/thumb/225x172xcut/include/images/' . $imago . '" title="' . $value["NAME"] . '" alt="' . $value["NAME"] . '" />';
                                    } else {
                                        echo "<img width='225' height='172' src='/thumb/225x172xcut/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png' alt='" . $value["NAME"] . "' title='" . $value["NAME"] . "' />";
                                    }
                                } ?>

                                <a href="<?= $value["DETAIL_PAGE_URL"] ?>" class="buildName"><?= $value["NAME"] ?></a>
                                <? if (!empty($value["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"])) { ?>
                                    <div class="redLabelMark"><?= $value["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"]; ?></div>
                                <? } ?>
                                <div class="buildText">
                                    <p style="color:#2579CB;">
                                        <? foreach ($value["PROPERTIES"]["REGION"]["VALUE"] as $key => $subValue) {
                                            if ($key != (count($value["PROPERTIES"]["REGION"]["VALUE"]) - 1)) { ?>
                                                <?= $subValue; ?>,
                                            <? } else { ?>
                                                <?= $subValue; ?>
                                                <?
                                            }
                                        }
                                        if (count($value["PROPERTIES"]["REGION"]["VALUE"]) == 1) {
                                            echo ' район';
                                        } else {
                                            echo ' районы';
                                        }
                                        ?>
                                    </p>

                                    <p style="color:#2579CB;"><span class="subwayLabel inline_m"></span>
                                        <?= $value["PROPERTIES"]["SUBWAYS"]["VALUE"][0]; ?>
                                    </p>

                                    <p><?= $value["PROPERTIES"]["ADDRESS"]["VALUE"]; ?></p>
                                    <?
                                    if ($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"] != false) {
                                        if (count($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"]) != 2) {
                                            ?>
                                            <p class="mini_on_ab">
                                                <span style="font-family: Bold;">Срок сдачи: </span>

                                                <?= $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]; ?>
                                                <? if (strtolower($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]) != "сдан") {
                                                    ?>
                                                    г.
                                                <? } ?>
                                            </p>
                                        <? } else { ?>
                                            <p class="mini_on_ab">
                                                <span style="font-family: Bold;">Срок сдачи: </span>

                                                <? if ($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0] != $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][1]) { ?>
                                                    <?= $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]; ?> - <?= $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][1]; ?> гг.
                                                    <?
                                                } else { ?>
                                                    <?= $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]; ?> г.
                                                    <?
                                                } ?>
                                            </p>
                                            <?
                                        }
                                    }
                                    ?>
                                </div>
                                <a href="<?= $value["DETAIL_PAGE_URL"] ?>" class="pseudoButton">от <span><?= number_format($value["PROPERTIES"]["FLATCOST"]["VALUE"][0], 0, ',', ' '); ?></span> Р</a>
                            </a>
                        </li>

                    <? } ?>
                </ul>
            </div>
        </div>
        <?
    } ?>
    <? if (!empty($selectArray)) {
        ?>
        <div class="similarObjectSelect">
            <p class="elementTitleInner">Подборки</p>

            <div class="specialsMainPage" style="padding: 0;width: 1020px;">
                <ul>
                    <? foreach ($selectArray as $value) {
                        ?>
                        <li class="specialItemForSelect">
                            <a href="<?= $value["DETAIL_PAGE_URL"] ?>">
                                <? if (!empty($value["PREVIEW_PICTURE"])) {
                                    $iiim = CFile::GetFileArray($value["PREVIEW_PICTURE"]);
                                    echo "<img width='225' height='352' src='/thumb/225x352xcut" . $iiim["SRC"] . "' alt='" . $value["NAME"] . "' title='" . $value["NAME"] . "' />";
                                } else {
                                    echo "<img src='/thumb/225x352xcut/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png' alt='" . $value["NAME"] . "' title='" . $value["NAME"] . "' />";
                                } ?>
                                <div class="labelForSelectList"><span><?= $value["NAME"] ?></span></div>
                            </a>
                        </li>
                    <? } ?>
                </ul>
            </div>
        </div>
        <?
    } ?>