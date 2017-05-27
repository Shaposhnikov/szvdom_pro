<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>
<h3 class="lonelyH3Pereus">Список предложений</h3>
<?if (!empty($arResult['ITEMS']))
{
  /*echo "<pre>";
    var_dump($arResult['ITEMS']);
    echo "</pre>";*/?>
    <table class="summCharTable pereustupkiSpec" width="100%">
        <tbody>
            <tr class="boldText titleTable">
                <th width="25" height="48"></th>
                <th width="200">
                    Название
                </th>
                <th width="200">
                    Адрес
                </th>
                <th width="80">
                    Срок сдачи
                </th>
                <th width="80">
                    Кол-во комнат
                </th>
                <th width="100">
                    S общ./жил.,м<sup>2</sup>
                </th>
                <th width="100">
                    Цена
                </th>
                <th width="50">
                    Торг
                </th>
                <th width="80">
                    Планировка
                </th>
                <th width="25"></th>
            </tr>
            <?foreach($arResult['ITEMS'] as $value){?>
                <tr>
                    <td></td>
                    <td>
                        <?=(!empty($value["NAME"]))?$value["NAME"]:"";?>
                    </td>
                    <td>
                        <?=(!empty($value["PROPERTIES"]["ADDRESS"]["VALUE"]))?$value["PROPERTIES"]["ADDRESS"]["VALUE"]:"";?>
                    </td>
                    <td>
                        <?=(!empty($value["PROPERTIES"]["END_DATE"]["VALUE"]))?$value["PROPERTIES"]["END_DATE"]["VALUE"]:"";?>
                    </td>
                    <td>
                        <?=(!empty($value["PROPERTIES"]["ROOM_AMOUNT"]["VALUE"]))?$value["PROPERTIES"]["ROOM_AMOUNT"]["VALUE"]:"";?>
                    </td>
                    <td>
                        <?=(!empty($value["PROPERTIES"]["SQUARE"]["VALUE"]))?$value["PROPERTIES"]["SQUARE"]["VALUE"]:"";?>
                    </td>
                    <td>
                        <?=(!empty($value["PROPERTIES"]["COAST"]["VALUE"]))?$value["PROPERTIES"]["COAST"]["VALUE"]:"";?>
                    </td>
                    <td>
                        <?=(!empty($value["PROPERTIES"]["SALE_PROP"]["VALUE"]))?$value["PROPERTIES"]["SALE_PROP"]["VALUE"]:"";?>
                    </td>
                    <td style="padding: 5px 0;">
                        <?if (!empty($value["PROPERTIES"]["PLAN_PICTURE"]["VALUE"])){
                            $image = CFile::GetFileArray($value["PROPERTIES"]["PLAN_PICTURE"]["VALUE"]);
                            echo "<img class='popupImage' data-src='".$image["SRC"]."' data-alt='".$value["NAME"]."' src='/thumb/50x50xin".$image["SRC"]."' alt='".$value["NAME"]."' title='".$value["NAME"]."' width='50' height='50' />";
                        }else{
                            echo "<img width='50' height='50' src='/thumb/50x50xin/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png' alt='".$value["NAME"]."' title='".$value["NAME"]."' />";
                        }?>
                    </td>
                    <td></td>
                </tr>
            <?}?>
        </tbody>
    </table>
    <div class="popupFullScreen">
        <div class="popupFullScreenImage">
            <div class="closeElementPopUp" onclick="$('.popupFullScreen').fadeOut();$('.popUpWindowOverlayImage').fadeOut();"></div>
            <div class="innerPopup"></div>
        </div>
    </div>
<?
}
?>
<?if ($arParams["DISPLAY_BOTTOM_PAGER"])
{
    ?>
    <? echo $arResult["NAV_STRING"]; ?><?
}?>
<div class="whatAreQuestion">
    <p class="whatAreQuestionText">
        <span class="watqtBig">Возникли вопросы? Позвоните!</span>
        <br/>
        <span class="watqtLittle">Бесплатная консультация и подбор жилья по телефону
        <br/>
       <span class="ya-elama-phone call_phone_1">+7(812) 902-50-50</span> <a data-who="footer_feedback" class="showIt">оставить заявку</a></span>
    </p>
    <div class="QW_block_ph point_border showIt" data-who="footer_feedback"></div>
    <div data-who="footer_feedback" class="showIt" style="background: url('//szvdom.ru.images.1c-bitrix-cdn.ru/bitrix/templates/szvdom/images/contact_us4.png?14371328155112')no-repeat; cursor:pointer; width: 100px;height: 100px;position: absolute;display: inline-block;right: 26px;top: 40px;"></div>
</div>
<div class="mainPageContent" style="padding-top: 25px;">
    <?=$arResult["DESCRIPTION"];?>
</div>
<div class="popUpWindowOverlayImage" onclick="$('.popupFullScreen').fadeOut();$('.popUpWindowOverlayImage').fadeOut();"></div>