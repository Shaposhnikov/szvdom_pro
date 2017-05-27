<?
if (!empty($arResult["PROPERTIES"]["MAP_OBJECTS"]["VALUE"])) {
    $arSelect = Array(
        "ID",
        "NAME",
        "DETAIL_PAGE_URL",
        "PREVIEW_PICTURE",
        "PREVIEW_TEXT"
    );
    $arFilter = Array("IBLOCK_ID" => 2, "ID" => $arResult["PROPERTIES"]["MAP_OBJECTS"]["VALUE"]);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while ($ob = $res->GetNextElement()) {
        $buf = $ob->GetFields();
        $bufProp = $ob->GetProperties();
        if (!empty($bufProp["SELECT_BUILDS"]["VALUE"])) {
            foreach ($bufProp["SELECT_BUILDS"]["VALUE"] as $crc) {
                $arSelectCrc = Array(
                    "ID",
                    "NAME",
                    "DETAIL_PAGE_URL",
                    "PREVIEW_PICTURE",
                    "PREVIEW_TEXT"
                );
                $arFilterCrc = Array("IBLOCK_ID" => 1, "SECTION_ID" => 1, "ID" => $crc);
                $res = CIBlockElement::GetList(Array(), $arFilterCrc, false, false, $arSelectCrc);
                while ($ob = $res->GetNextElement()) {
                    $buf = $ob->GetFields();
                    $bufProp = $ob->GetProperties($propSelect);
                    $buf["PROPERTIES"] = $bufProp;
                    $mapArray[] = $buf;
                }
            }
        }
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
    $mapSimalarLabel[] = array("X" => $value["PROPERTIES"]["LATITUDE"]["VALUE"], "Y" => $value["PROPERTIES"]["LONGITUDE"]["VALUE"], "NAME" => $value["NAME"]);
}


?>
<? if (!empty($mapSimalarLabel)) { ?>
    <script type="text/javascript">
        var myMap;
        ymaps.ready(init);
        function init() {
            var myMap = new ymaps.Map("map", {
                    center: [<?=$mapSimalarLabel[0]["X"]?>, <?=$mapSimalarLabel[0]["Y"]?>],
                    zoom: 8,
                    controls: ['smallMapDefaultSet']
                }),
                yellowCollection = new ymaps.GeoObjectCollection(null, {
                    preset: 'islands#blackStretchyIcon'
                }),
                yellowCoords = [
                    <?foreach ($mapSimalarLabel as $key => $value){
                        if ($key !=  (count($mapSimalarLabel) - 1)){
                            echo "[".$value["X"].", ".$value["Y"]."],";
                        } else{
                            echo "[".$value["X"].", ".$value["Y"]."]";
                        }
                    }?>
                ];
            for (var i = 0, l = yellowCoords.length; i < l; i++) {
                yellowCollection.add(new ymaps.Placemark(yellowCoords[i],
                    {
                        iconLayout: 'default#image',
                        iconImageHref: '/bitrix/templates/szvdom/images/mapLabel.png',
                        iconImageSize: [30, 42],
                        iconImageOffset: [-3, -42]
                    }
                ));
            }
            myMap.geoObjects.add(yellowCollection);
        }
    </script>
    <div id='map' style="width: 1060px;height: 400px;"></div>
<? } ?>
<? if (!empty($selectArray)) { ?>
    <div class="similarObjectSelect">
        <p class="elementTitleInner">Подборки</p>

        <div class="specialsMainPage" style="padding: 0;">
            <ul>
                <? foreach ($selectArray as $value) { ?>
                    <li class="specialItemForSelect">
                        <a href="<?= $value["DETAIL_PAGE_URL"] ?>">
                            <? if (!empty($value["PREVIEW_PICTURE"])) {
                                echo "<img width='225' height='260' src='" . $value["PREVIEW_PICTURE"] . "' alt='" . $value["NAME"] . "' title='" . $value["NAME"] . "' />";
                            } else {
                                echo "<img src='/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png' alt='" . $value["NAME"] . "' title='" . $value["NAME"] . "' />";
                            } ?>
                            <div class="labelForSelectList"><?= $value["NAME"] ?></div>
                        </a>
                    </li>
                <? } ?>
            </ul>
        </div>
    </div>
<? } ?>
<? if (!empty($objectArray)) { ?>
    <div class="similarObjectObjects">
        <p class="elementTitleInner">Объекты</p>

        <div class="buildMainPage" style="padding: 0;">
            <ul>
                <? foreach ($objectArray as $value) {
                    $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $value["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
                    $imago = (string)$blocks[0]["avatar"];
                    ?>

                    <li>
                        <a href="<?= $value["DETAIL_PAGE_URL"] ?>">
                            <? if (!empty($value["PREVIEW_PICTURE"]) && $value["PREVIEW_PICTURE"]["SRC"] != "/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png") {
                                echo "<img width='225' height='172' src='/thumb/225x172xcut" . $value["PREVIEW_PICTURE"]["SRC"] . "' alt='" . $value["NAME"] . "' title='" . $value["NAME"] . "' />";
                            } else {
                                if (!empty($imago)) {
                                    echo '<img width="225" height="172" src="/thumb/225x172xcut/include/images/' . $imago . '" title="' . $value["NAME"] . '" alt="' . $value["NAME"] . '" />';
                                } else {
                                    echo "<img width='225' height='172' src='/thumb/225x172xcut/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png' alt='" . $value["NAME"] . "' title='" . $value["NAME"] . "' />";
                                }
                            } ?>

                            <a href="<?= $value["DETAIL_PAGE_URL"] ?>" class="buildName"><?= $value["NAME"] ?></a>

                            <div class="buildText">
                                <p>
                                    <? foreach ($value["PROPERTIES"]["REGION"]["VALUE"] as $key => $subValue) {
                                        if ($key != (count($value["PROPERTIES"]["REGION"]["VALUE"]) - 1)) { ?>
                                            <?= $subValue; ?>,
                                        <? } else { ?>
                                            <?= $subValue; ?>
                                        <?
                                        }
                                    } ?>
                                </p>

                                <p>
                                    <?= $value["PROPERTIES"]["SUBWAYS"]["VALUE"][0]; ?>
                                </p>

                                <p><?= $value["PROPERTIES"]["ADDRESS"]["VALUE"]; ?></p>

                                <p><?= $value["PROPERTIES"]["BUILDER"]["VALUE"]; ?></p>
                                <? if (count($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"]) != 2) { ?>
                                    <p><?= $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]; ?></p>
                                <? } else { ?>
                                    <p>
                                        <? if ($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0] != $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][1]) { ?>
                                            <?= $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]; ?> - <?= $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][1]; ?>
                                        <? } else { ?>
                                            <?= $value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]; ?>
                                        <? } ?>
                                    </p>
                                <? } ?>
                            </div>
                            <a href="<?= $value["DETAIL_PAGE_URL"] ?>" class="pseudoButton">от <span><?= $value["PROPERTIES"]["FLATCOST"]["VALUE"][1]; ?></span> Р</a>
                        </a>
                    </li>

                <? } ?>
            </ul>
        </div>
    </div>
<? } ?>