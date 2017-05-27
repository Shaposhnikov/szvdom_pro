<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arFilter = array(
    "IBLOCK_ID"=> "1",
    "ACTIVE"=> "Y",
    "SECTION_ID"=> "1"
);
$arSelect = array(
    "ID",
    "IBLOCK_ID",
    "IBLOCK_SECTION_ID",
    "NAME",
    "CODE",
    "DETAIL_PAGE_URL",
    "PREVIEW_PICTURE",
    "PROPERTY_REGION",
    "PROPERTY_LATITUDE",
    "PROPERTY_LONGITUDE",
    "PROPERTY_ADDRESS",
    "PROPERTY_SECOND_ID"
);
$rsElement = CIBlockElement::GetList(array() , $arFilter , false, false, $arSelect);
while($obElement = $rsElement->GetNextElement()) {
    $arItem = $obElement->GetFields();
    $arResult[] = $arItem;
}
$this->IncludeComponentTemplate();
?>