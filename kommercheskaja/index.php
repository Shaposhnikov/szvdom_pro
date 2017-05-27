<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->AddChainItem("Главная", "/");
$APPLICATION->AddChainItem("Коммерческая", "");
CModule::IncludeModule("iblock");
$iblockId = 3;
$sectionId = 15;
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
?><div class="similarOnePage">
    <h1>
        <?=$section["SEO"]["SECTION_PAGE_TITLE"];?>
    </h1>
    <div class="notMainPageMenu">
        <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"ver1", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "ver1"
	),
	false
);
        ?>
    </div>
    <div class="firstAnotherDescription" style="width: 976px;">
        <?=htmlspecialchars_decode($section["UF_DESCRIPTION"]);?>
    </div>
</div>

<div class="similarOnePageDescription">
    <?=$section["DESCRIPTION"];?>
</div>
<div class="whatAreQuestion">
    <p class="whatAreQuestionText">
        <span class="watqtBig">Возникли вопросы? Позвоните!</span>
        <br/>
    <span class="watqtLittle">Бесплатная консультация и подбор жилья по телефону
    <br/>
   <span class="ya-elama-phone call_phone_1">+7(812) 902-50-50</span> <a onclick="$('.footer_feedback').css({'display':'block','top':'125px'});$('.popUpWindowOverlay').css('display','block');">оставить заявку</a></span>
    </p>
	<div class="QW_block_ph point_border showIt" data-who="footer_feedback" ></div>
	<div data-who="footer_feedback" class="showIt" style="background: url('/bitrix/templates/szvdom/images/contact_us4.png')no-repeat; cursor:pointer; width: 100px;height: 100px;position: absolute;display: inline-block;right: 26px;top: 40px;"></div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>