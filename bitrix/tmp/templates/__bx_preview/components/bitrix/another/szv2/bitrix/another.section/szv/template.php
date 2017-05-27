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
$APPLICATION->AddChainItem("Аналитика", "");
?>

<div class="newsListSzv">
<h1>Аналитика</h1>
<?foreach($arResult["ITEMS"] as $arItem){
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
						class="preview_picture"
						border="0"
						src="<?if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {echo $arItem["PREVIEW_PICTURE"]["SRC"];}else{echo '/upload/iblock/07d/07d49b8e134038ba181c9d8c6349fee4.png';}?>"
						width="156"
						height="120"
						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
						style="float:left"


						/></a>
        <p class="news-item-text-block">
                <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
                <br />
				 <span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
				<br />

			    <span class="news-descript"><?echo $arItem["PREVIEW_TEXT"];?></span>

        </p>
			<div style="clear:both"></div>

	</div>

<?}?>

    <div style="clear: both;"></div>
    <?if ($arParams["DISPLAY_BOTTOM_PAGER"])
    {
        ?>
        <? echo $arResult["NAV_STRING"]; ?><?
    }?>

    <?
    if (!empty($arParams["CRUNCH_ARRAY"])){
        foreach($arParams["CRUNCH_ARRAY"] as $crunch){?>
            <p class="news-item">
                <a href="<?=$crunch["URL"]?>"><?=$crunch["NAME"]?></a>
            </p>
        <? }
    }

    ?>


</div>
