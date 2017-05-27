<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->AddChainItem("Главная", "/");
$APPLICATION->AddChainItem("Контакты", "");
CModule::IncludeModule("iblock");
$iblockId = 3;
$sectionId = 17;
$arFilter = Array('IBLOCK_ID' => $iblockId, 'GLOBAL_ACTIVE'=>'Y', 'ID' => $sectionId);
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
$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false,$arSelect,false);
while($ar_result = $db_list->GetNext())
{
    $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(
        $iblockId,
        $sectionId
    );
    $ar_result["SEO"] = $ipropValues->getValues();
    $section = $ar_result;
}
if (!empty($section["SEO"]["SECTION_META_KEYWORDS"])){
    $APPLICATION->SetPageProperty("keywords", $section["SEO"]["SECTION_META_KEYWORDS"]);
}else{
    $APPLICATION->SetPageProperty("keywords", $section["NAME"]);
}
if (!empty($section["SEO"]["SECTION_META_DESCRIPTION"])){
    $APPLICATION->SetPageProperty("description", $section["SEO"]["SECTION_META_DESCRIPTION"]);
}else{
    $APPLICATION->SetPageProperty("description", $section["NAME"]);
}
if (!empty($section["SEO"]["SECTION_META_TITLE"])){
    $APPLICATION->SetPageProperty("title", $section["SEO"]["SECTION_META_TITLE"]);
}else{
    $APPLICATION->SetPageProperty("title", $section["NAME"]);
}
?>
    <div class="similarOnePage">
        <h1>
            <?=$section["SEO"]["SECTION_PAGE_TITLE"];?>
        </h1>
        <div class="firstAnotherDescription" style="width: 976px;">
            <?=htmlspecialchars_decode($section["UF_DESCRIPTION"]);?>
        </div>
    </div>

    <div class="similarOnePageDescription">
        <?=$section["DESCRIPTION"];?>
    </div>
	
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
