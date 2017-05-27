<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->AddChainItem("Главная", "/");
$APPLICATION->AddChainItem("Карта сайта", "");
$APPLICATION->SetPageProperty("keywords", "Карта сайта");
$APPLICATION->SetPageProperty("description", "Компания «Созвездие недвижимости» - продажа недвижимости в новостройках Санкт-Петербурга по ценам от застройщика. Карта сайта.");
$APPLICATION->SetPageProperty("title", "Карта сайта");
CModule::IncludeModule("iblock");
echo "<div class='mapForSite'>";
echo "<h1>КАРТА САЙТА</h1>";

/*
 * Получаем верхний уровень(Инфоблоки)
 * */
$res = CIBlock::GetList(
    Array(),
    Array(
        'ID' => array(1,2,3,5),
        'SITE_ID'=>SITE_ID,
        'ACTIVE'=>'Y'
    ), true
);
while($ar_res = $res->Fetch())
{
    $blocks[] = $ar_res;
}
/*
 * Получаем вложенные разделы
 * */
foreach ($blocks as $key => $block) {
    $arFilter = Array('IBLOCK_ID'=>$block["ID"], 'GLOBAL_ACTIVE'=>'');
    $arSelect =array("ID","IBLOCK_ID","ACTIVE","CODE","NAME","DEPTH_LEVEL","SECTION_PAGE_URL");
    $rsSection = CIBlockSection::GetList(array(),$arFilter, false,$arSelect,false);
    while ($arSection = $rsSection->GetNextElement())
    {
        $arFields = $arSection -> GetFields();
        /*
         * Получаем все элементы, вложенные в секции
         * */
        $arSelectElem = Array("ID", "IBLOCK_ID","ACTIVE", "NAME","DETAIL_PAGE_URL");
        if ($block["ID"] == 1){
            $arFilterElem = Array("IBLOCK_ID" => $block["ID"],"SECTION_ID" => $arFields["ID"],"ACTIVE"=>"");
        }else{
            $arFilterElem = Array("IBLOCK_ID" => $block["ID"],"SECTION_ID" => $arFields["ID"],"ACTIVE"=>"");
        }
        $resElem = CIBlockElement::GetList(Array(), $arFilterElem, false, false, $arSelectElem);
        while($obElem = $resElem->GetNextElement()){
            $arFieldsElem = $obElem->GetFields();
            $prop = $obElem->GetProperties(array(),array("CODE" => "SHOW_ON_SITEMAP"));
            if ($block["ID"] == 1){
                if ($arFieldsElem["ACTIVE"] == "Y"){
                    $arFields["ELEMENTS"][] =  $arFieldsElem;
                }else{
                    if (strtolower($prop["SHOW_ON_SITEMAP"]["VALUE"]) == "да"){
                        $arFields["ELEMENTS"][] =  $arFieldsElem;
                    }
                }
            }else{
                $arFields["ELEMENTS"][] =  $arFieldsElem;
            }
        }
        $blocks[$key]["SECTIONS"][] = $arFields;
    }
}
/*
 * Получаем элементы инфоблока 2
 * */
$arSelect = Array("ID", "IBLOCK_ID","ACTIVE", "NAME","DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID" => 2, "ACTIVE"=>"");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    $blocks[1]["ELEMENTS"][] =  $arFields;
}
/*
 * Выводим что получилось
 * */
echo "<ul>";
echo "<li><a href='/'>Главная</a></li>";
foreach($blocks as $block){
    if ($block["ID"] != 2){
        foreach ($block["SECTIONS"] as $section){
            if ($section["ACTIVE"] == "N"){
                $sectAct = " (в архиве)";
            }else{
                $sectAct = "";
            }
            echo "<li><a href='".$section["SECTION_PAGE_URL"]."'>".$section["NAME"].$sectAct."</a>";
            if (!empty($section["ELEMENTS"]) && $block["ID"] != 5){
                echo "<ul>";
                foreach ($section["ELEMENTS"] as $element){
                    if ($block["ID"] == 1) {
                        if ($element["ACTIVE"] == "N") {
                            $elementAct = " (в архиве)";
                        } else {
                            $elementAct = "";
                        }
                        echo "<li><a href='" . $element["DETAIL_PAGE_URL"] . "'>" . $element["NAME"] . $elementAct . "</a>";
                        echo "<ul>";
                        echo "<li><a href='" . $element["DETAIL_PAGE_URL"] . "foto/'>" . $element["NAME"]." : Фото</a></li>";
                        echo "<li><a href='" . $element["DETAIL_PAGE_URL"] . "hod-stroitelstva/'>" . $element["NAME"]." : Ход строительства</a></li>";
                        echo "<li><a href='" . $element["DETAIL_PAGE_URL"] . "tseny-na-kvartiry/'>" . $element["NAME"]." : Цены на квартиры</a></li>";
                        echo "<li><a href='" . $element["DETAIL_PAGE_URL"] . "planirovki/'>" . $element["NAME"]." : Планировки</a></li>";
                        echo "<li><a href='" . $element["DETAIL_PAGE_URL"] . "ipoteka/'>" . $element["NAME"]." : Ипотека</a></li>";
                        echo "<li><a href='" . $element["DETAIL_PAGE_URL"] . "zachet-zhilja/'>" . $element["NAME"]." : Зачет жилья</a></li>";
                        echo "<li><a href='" . $element["DETAIL_PAGE_URL"] . "pohozhie-obekty/'>" . $element["NAME"]." : Похожие объекты</a></li>";
                        echo "</ul>";
                        echo "</li>";
                    }else{
                        if ($element["ACTIVE"] == "N") {
                            $elementAct = " (в архиве)";
                        } else {
                            $elementAct = "";
                        }
                        echo "<li><a href='" . $element["DETAIL_PAGE_URL"] . "'>" . $element["NAME"] . $elementAct . "</a></li>";
                    }
                }
                echo "</ul>";
            }
            echo "</li>";
        }
    }else{

        echo "<li><a href='/vyborki/'>".$block["NAME"]."</a>";
        echo "<ul>";
        foreach ($block["ELEMENTS"] as $element){
            if ($element["ACTIVE"] == "N"){
                $elementAct = " (в архиве)";
            }else{
                $elementAct = "";
            }
            echo "<li><a href='".$element["DETAIL_PAGE_URL"]."'>".$element["NAME"].$elementAct."</a></li>";
        }
        echo "</ul>";
        echo "</li>";
    }
}
echo "</ul>";
echo "</div>";
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
