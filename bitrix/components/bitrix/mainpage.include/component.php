<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

$xml = simplexml_load_file("http://szv.ayers.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
if (CModule::IncludeModule("iblock")) {

    $arSelect = Array(
        "ID",
        "NAME",
        "DETAIL_PAGE_URL",
        "PREVIEW_PICTURE",
        "PREVIEW_TEXT",
        "PROPERTY_SHOW_THIS_ON_MAIN"
    );

    $arFilter = Array("IBLOCK_ID" => 1,"SECTION_ID" => 1);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $buf = $ob->GetFields();
        if ($buf["PROPERTY_SHOW_THIS_ON_MAIN_VALUE"] == "да"){
            $bufProp = $ob->GetProperties($propSelect);
            $buf["PROPERTIES"] = $bufProp;
            $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $buf["PROPERTIES"]["SECOND_ID"]["VALUE"]. "']");
            $imago = (string)$blocks[0]["avatar"];
            if (!empty($buf["PREVIEW_PICTURE"])){
                $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
                $buf["PREVIEW_PICTURE"] = "/thumb/225x172xcut".$image["SRC"];
            }else{
                $buf["PREVIEW_PICTURE"] = "/thumb/225x172xcut/include/images/".$imago;
            }
            $arResult["BUILD"][] = $buf;
        }
    }




    $arSelect = Array("ID", "NAME", "PROPERTY_SHOW_ON_MAIN_PAGE","PREVIEW_PICTURE","DETAIL_PAGE_URL","PREVIEW_TEXT","PROPERTY_FILTER_VAL");
    $arFilter = Array("IBLOCK_ID" => 2);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $buf = $ob->GetFields();
        if ($buf["PROPERTY_SHOW_ON_MAIN_PAGE_VALUE"] == "да"){
            if (!empty($buf["PREVIEW_PICTURE"])){
                $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
                $buf["PREVIEW_PICTURE"] = "/thumb/225x352xcut".$image["SRC"];
            }else{
                $buf["PREVIEW_PICTURE"] ="/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png";
            }
            $arResult["SELECT"][] = $buf;
        }
    }

    $arSelect = Array("ID", "NAME","DETAIL_PAGE_URL","PREVIEW_PICTURE","PREVIEW_TEXT","ACTIVE_FROM","PROPERTY_SHOW_THIS_ON_MAIN");
    $arFilter = Array("IBLOCK_ID" => 3,"SECTION_ID" => 10);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, array("nPageSize" => 4), $arSelect);
    while($ob = $res->GetNextElement())
    {
        $buf = $ob->GetFields();
        if (!empty($buf["PREVIEW_PICTURE"])){
            $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
            $buf["PREVIEW_PICTURE"] = $image["SRC"];
        }
        $arResult["NEWS"][] = $buf;
    }

}

$this->IncludeComponentTemplate();
?>