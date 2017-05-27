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
$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($arParams["IBLOCK_ID"], $arResult["ID"]);
$arSeo = $ipropValues->getValues();
if (!empty($arSeo["ELEMENT_META_TITLE"])){
    $APPLICATION->SetPageProperty("keywords", $arSeo["ELEMENT_META_KEYWORDS"]);
}else{
    $APPLICATION->SetPageProperty("keywords",$arResult["NAME"]);
}
if (!empty($arSeo["ELEMENT_META_TITLE"])){
    $APPLICATION->SetPageProperty("description", $arSeo["ELEMENT_META_DESCRIPTION"]);
}else{
    $APPLICATION->SetPageProperty("description", $arResult["NAME"]);
}
if (!empty($arSeo["ELEMENT_META_TITLE"])){
    $APPLICATION->SetPageProperty("title", $arSeo["ELEMENT_META_TITLE"]);
}else{
    $APPLICATION->SetPageProperty("title", $arResult["NAME"]);
}
?>
<div class="forAllPage newsElementPage">
    <h1>
        <?/*if (!empty($arResult["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"])){
            echo $arResult["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"];
        }else{*/
            echo $arResult["NAME"];
        /*}*/?>
    </h1>
    <div class="newsElementPageTime"><?echo $arResult["DISPLAY_ACTIVE_FROM"]?></div>
    <div class="forAllPageLeftSide">
        <?if (!empty($arResult["DETAIL_PICTURE"])){
            echo "<img width='320' height='240' src='".$arResult["DETAIL_PICTURE"]["SRC"]."' alt='"./*$arResult["PREVIEW_TEXT"]*/$arResult["NAME"]."' style='float:left;padding: 20px 15px 15px 0;' title='"./*$arResult["PREVIEW_TEXT"]*/$arResult["NAME"]."' />";
        }?>
        <?if (!empty($arResult["DETAIL_TEXT"])){
            echo  $arResult["DETAIL_TEXT"];
        }?>
    </div>
    <div style="clear: both;"></div>
    <br/>
    <a href="/novosti/" class="backToAllNewsLink"><img src="/bitrix/templates/szvdom/images/arrowNews.png" width="18" height="20" /><span>Вернуться к списку аналитики</span></a>
</div>
