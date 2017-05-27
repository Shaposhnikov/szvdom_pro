<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("");
CModule::IncludeModule("iblock");
$iblockId = 3;
$sectionId = 21;
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
?>    <div class="similarOnePage">
        <h1>
            <?= $section["SEO"]["SECTION_PAGE_TITLE"]; ?>
        </h1>
        <?if (!empty($section["UF_DESCRIPTION"])){?>
            <div class="firstAnotherDescription" style="width: 976px;">
                <?= $section["UF_DESCRIPTION"] ?>
            </div>
        <?}?>

    </div>
<?if (!empty($section["DESCRIPTION"])){?>
    <div class="similarOnePageDescription">
        <?= $section["DESCRIPTION"]; ?>
    </div>
<?}?>
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