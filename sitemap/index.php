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
 * Формируем список
 * */
$aLinks = array();
foreach($blocks as $block){
    if ($block["ID"] != 2){
        foreach ($block["SECTIONS"] as $section){
            if ($section["ACTIVE"] == "N"){
                $sectAct = " (в архиве)";
            }else{
                $sectAct = "";
            }
            $aLinks[] = array($section["SECTION_PAGE_URL"], $section["NAME"].$sectAct);
            if (!empty($section["ELEMENTS"]) && $block["ID"] != 5){
                foreach ($section["ELEMENTS"] as $element){
                    if ($block["ID"] == 1) {
                        if ($element["ACTIVE"] == "N") {
                            $elementAct = " (в архиве)";
                        } else {
                            $elementAct = "";
                        }
                        $aLinks[] = array($element["DETAIL_PAGE_URL"], $element["NAME"] . $elementAct);
                    }else{
                        if ($element["ACTIVE"] == "N") {
                            $elementAct = " (в архиве)";
                        } else {
                            $elementAct = "";
                        }
                        $aLinks[] = array($element["DETAIL_PAGE_URL"], $element["NAME"] . $elementAct);
                    }
                }
            }
        }
    }else{
        $aLinks[] = array('/vyborki/', $block["NAME"]);
        foreach ($block["ELEMENTS"] as $element){
            if ($element["ACTIVE"] == "N"){
                $elementAct = " (в архиве)";
            }else{
                $elementAct = "";
            }
            $aLinks[] = array($element["DETAIL_PAGE_URL"], $element["NAME"].$elementAct);
        }
    }
}


/*
 * Выводим что получилось
 * */
echo '<ul>';
$iPage = isset($_GET['PAGEN_1']) ? (int)$_GET['PAGEN_1'] : 0;
if (preg_match('#/sitemap/#siU', $_SERVER['REQUEST_URI']) && !isset($_GET['PAGEN_1'])){ echo '<li><a href="/">Главная</a></li>';}
for ($i = 0; $i < 200; $i++) {
  $iItem = $iPage * 200 + $i;
  if ($iItem >= count($aLinks)) break;
  if ($aLinks[$iItem][0] !== '/articles/' && !preg_match('#/articles/.*/#siU', $aLinks[$iItem][0]) && !preg_match('#/pokupateljam/programma-trade-in-zachet-zhilya/#siU', $aLinks[$iItem][0]) && !preg_match('#/novosti/.*/#siU', $aLinks[$iItem][0]) && !preg_match('#/novosti/#siU', $aLinks[$iItem][0]) && !preg_match('#/sposoby-pokupki/pokupka-po-pereustupke/#siU', $aLinks[$iItem][0]) && !preg_match('#/sposoby-pokupki/voennaya-ipoteka/#siU', $aLinks[$iItem][0]) && !preg_match('#/vyborki/kvartira-glavstroy-juntolovo/#siU', $aLinks[$iItem][0]) && !preg_match('#/vyborki/kvartira-glavstroy-severnaja-dolina/#siU', $aLinks[$iItem][0]) && !preg_match('#/vyborki/obekty-yuit/#siU', $aLinks[$iItem][0]) && !preg_match('#/vyborki/obekty-glavstroy/#siU', $aLinks[$iItem][0]) && !preg_match('#/vyborki/kvartiry-studii-ekonom-klassa/#siU', $aLinks[$iItem][0])){
  echo '<li><a href="' . $aLinks[$iItem][0] . '">' . $aLinks[$iItem][1] . '</a></li>';}
}
echo '</ul>';
/*echo "<!--222";
echo $iPage;
echo "-->";*/

$numb = ceil(count($aLinks) / 200);
echo '<div class="elementsNavString">';
if (preg_match('#/sitemap/#siU', $_SERVER['REQUEST_URI']) && isset($_GET['PAGEN_1'])){
echo '<a style="border: none; border-left: 1px solid #a6c2de;"></a><a href="/sitemap/">1</a>';  } 
else{
echo '<span>1</span>'; }

//echo ($numb);                     
for ($j = 2; $j <= $numb; $j++) {
$k = $j-1;
if ($_GET['PAGEN_1'] == $k){
echo  '<span>'.$j.'</span>';}
else{
echo'<a href="/sitemap/?PAGEN_1='.$k.'">'.$j.'</a>';}
}
echo '</div>';
//echo '<!--'.$numb.'-->';



echo "</div>";
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
