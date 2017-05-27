<?
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('CHK_EVENT', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);
CModule::IncludeModule("iblock");

/*
 * Получаем верхний уровень(Инфоблоки)
 * */
$res = CIBlock::GetList(
    Array(),
    Array(
        'ID' => array(1,2,3,5),
        'SITE_ID'=>'s1',
        'ACTIVE'=>'Y'
    ), true
);
while($ar_res = $res->Fetch())
{
    $blocks[] = $ar_res;
}
$prefix = "http://szvdom.ru";
/*
 * Получаем вложенные разделы
 * */

foreach ($blocks as $key => $block) {
    $arFilter = Array('IBLOCK_ID'=>$block["ID"], 'GLOBAL_ACTIVE'=>'Y');
    $arSelect =array("ID","IBLOCK_ID","ACTIVE","CODE","NAME","DEPTH_LEVEL","SECTION_PAGE_URL","TIMESTAMP_X");
    $rsSection = CIBlockSection::GetList(array(),$arFilter, false,$arSelect,false);
    while ($arSection = $rsSection->GetNextElement())
    {
        $arFields = $arSection -> GetFields();
        /*
         * Получаем все элементы, вложенные в секции
         * */
        $arSelectElem = Array("ID", "IBLOCK_ID","ACTIVE", "NAME","DETAIL_PAGE_URL","TIMESTAMP_X");
        if ($block["ID"] == 1){
            $arFilterElem = Array("IBLOCK_ID" => $block["ID"],"SECTION_ID" => $arFields["ID"],"ACTIVE"=>"");
        }else{
            $arFilterElem = Array("IBLOCK_ID" => $block["ID"],"SECTION_ID" => $arFields["ID"],"ACTIVE"=>"Y");
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
$arSelect = Array("ID", "IBLOCK_ID", "NAME","DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID" => 2, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    $blocks[1]["ELEMENTS"][] =  $arFields;
}
/*
 * Выводим что получилось
 * */
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$xml .= '<url><loc>'.$prefix.'/</loc></url>';
foreach($blocks as $block){
    if ($block["ID"] != 2){
        foreach ($block["SECTIONS"] as $section){
            $xml .= "<url>";
            $xml .= '<loc>'.$prefix.$section["SECTION_PAGE_URL"].'</loc>';
            //$xml .= '<lastmod>'.$section["TIMESTAMP_X"].'</lastmod>';
            $xml .= "</url>";
            if (!empty($section["ELEMENTS"]) && $block["ID"] != 5){
                foreach ($section["ELEMENTS"] as $element){
                    if ($block["ID"] == 1){
                        $xml .= "<url>";
                        $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'</loc>';
                        //$xml .= '<lastmod>'.$element["TIMESTAMP_X"].'</lastmod>';
                        $xml .= "</url>";
                        $xml .= "<url>";
                        $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'foto/</loc>';
                        $xml .= "</url>";
                        $xml .= "<url>";
                        $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'hod-stroitelstva/</loc>';
                        $xml .= "</url>";
                        $xml .= "<url>";
                        $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'tseny-na-kvartiry/</loc>';
                        $xml .= "</url>";
                        $xml .= "<url>";
                        $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'planirovki/</loc>';
                        $xml .= "</url>";
                        $xml .= "<url>";
                        $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'ipoteka/</loc>';
                        $xml .= "</url>";
                        $xml .= "<url>";
                        $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'zachet-zhilja/</loc>';
                        $xml .= "</url>";
                        $xml .= "<url>";
                        $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'pohozhie-obekty/</loc>';
                        $xml .= "</url>";


                    }else{
                        $xml .= "<url>";
                        $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'</loc>';
                        //$xml .= '<lastmod>'.$element["TIMESTAMP_X"].'</lastmod>';
                        $xml .= "</url>";
                    }

                }
            }
        }
    }else{
        $xml .= "<url>";
        $xml .= '<loc>'.$prefix.'/vyborki/</loc>';
        //$xml .= '<lastmod></lastmod>';
        $xml .= "</url>";
        foreach ($block["ELEMENTS"] as $element){
            $xml .= "<url>";
            $xml .= '<loc>'.$prefix.$element["DETAIL_PAGE_URL"].'</loc>';
            //$xml .= '<lastmod>'.$element["TIMESTAMP_X"].'</lastmod>';
            $xml .= "</url>";
        }
    }
}
$xml .= '</urlset>';
$f = fopen($_SERVER["DOCUMENT_ROOT"].'/sitemap.xml', 'w+');
fwrite($f,$xml);
fclose($f);
?>