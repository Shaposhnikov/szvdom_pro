<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->AddHeadString('<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>',true);
$xml = simplexml_load_file("http://szv.ayers.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
$blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $arResult["PROPERTIES"]["SECOND_ID"]["VALUE"]. "']");
$region = $xml->xpath("/Ads/Regions/Region[@id='" . $blocks[0]["region"]. "']");
$simalar = $xml->xpath("/Ads/Blocks/Block[@region='" . $region[0]["id"]. "']");
$subwayBlock = $xml->xpath("/Ads/BlockSubways/BlockSubway[@blockid='" . $arResult["PROPERTIES"]["SECOND_ID"]["VALUE"]. "']");
$subway = $xml->xpath("/Ads/Subways/Subway[@id='" . $subwayBlock[0]["subwayid"]. "']");
$mapLabel = array( "X" => (float)$blocks[0]["longitude"], "Y" => (float)$blocks[0]["latitude"], "NAME" => (string)$blocks[0]["title"]);
$this->setFrameMode(true);
if (!empty($arResult['ITEMS']))
{?>
    <div class="buildMainPage">
    <ul>
        <?foreach( $arResult['ITEMS'] as $value){
            $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $value["PROPERTIES"]["SECOND_ID"]["VALUE"]. "']");
            $imago = (string)$blocks[0]["avatar"];
            ?>
            <li onclick="location.href = '<?=$value["DETAIL_PAGE_URL"];?>'">
                <?
                if (!empty($value["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"])){
                    echo '<div class="redLabelMark">'.$value["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"].'</div>';
                }
                ?>
                <a href="<?=$value["DETAIL_PAGE_URL"]?>">
                    <?if (!empty($value["PREVIEW_PICTURE"])  && $value["PREVIEW_PICTURE"]["SRC"] != "/bitrix/templates/szvdom/components/szv/catalog/szv/szv/catalog.section/.default/images/no_photo.png"){
                        echo "<img width='225' height='175' src='".$value["PREVIEW_PICTURE"]["SRC"]."' alt='".$value["NAME"]."' title='".$value["NAME"]."' />";
                    }else{
                        if (!empty($imago)){
                            echo '<img width="225" height="175" src="/include/images/'.$imago.'" title="'.$value["NAME"].'" alt="'.$value["NAME"].'" />';
                        }else{
                            echo "<img width='225' height='175' src='/thumb/225x172xcut/include/images/no_photo.png' alt='".$value["NAME"]."' title='".$value["NAME"]."' />";
                        }
                    }?>
                </a>
                <div style="clear: both;"></div>
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
                            <p>
                                <span style="font-family: Bold;">Срок сдачи: </span>
                                <br/>
                                <?=$value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0];?>
                                <?if (strtolower($value["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]) != "сдан"){?>
                                    г.
                                <?}?>
                            </p>
                        <?} else{?>
                            <p>
                                <span style="font-family: Bold;">Срок сдачи: </span>
                                <br/>
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

                <p class="pseudoButton">от <?=number_format($value["PROPERTIES"]["FLATCOST"]["VALUE"][0], 0, ',', ' '); ?> Р</p>

            </li>
            <?}?>
    </ul>
            <div style="clear: both;"></div>
    <?if ($arParams["DISPLAY_BOTTOM_PAGER"])
{
    ?>
    <? echo $arResult["NAV_STRING"]; ?><?
}?>
    </div>
<?
}
?>