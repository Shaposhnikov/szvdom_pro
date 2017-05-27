<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$theme = COption::GetOptionString("main", "wizard_eshop_adapt_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}

$request = "";

$blockidall = $xml->xpath("/Ads/Apartments/Apartment[@blockid='" . $arParams["XML_ID"]. "']");
$building = $xml->xpath("/Ads/Buildings/Building[@blockid='" . $arParams["XML_ID"]. "']");
$blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $arParams["XML_ID"]. "']");
$roomType = $xml->xpath("/Ads/RoomTypes/RoomType");
foreach($building as $item) {
	$id = (string)$item[0]['id'];
	$corp = (string)$item[0]['corp'];
	$floors = (string)$item[0]['floors'];
	$endingperiod = (string)$item[0]['endingperiod'];
    $line = (string)$item[0]['line'];
	$new_building[$id] = array("corp" => $corp, "floors" => $floors, "endingperiod" => $endingperiod, "line" => $line);
}
$json = json_encode($blockidall);
$arrayXml = json_decode($json,TRUE);
$json2 = json_encode($blocks);
$arrayXml2 = json_decode($json2,TRUE);
foreach ($arrayXml as $key => $value) {
	if ($value["@attributes"]["rooms"] == 25){
		continue;
	}
	$blockIdDone[] = $value["@attributes"];
}
$ourBlock = $arrayXml2[0]["@attributes"];

$skitchenArray = array();
$squareArray = array();
$pricesArray = array();
foreach ($blockIdDone as $key => $value) {
	$b_id = (string)$value['buildingid'];
	foreach ($roomType as $tkey => $type) {
		if ($value["rooms"] == (string)$type[0]["id"]){
			$blockIdDone[$key]["roomtype"] = (string)$type[0]["name"];
		}
	}
	$blockIdDone[$key]['endingperiod'] = $new_building[$b_id]['endingperiod'];
	$blockIdDone[$key]['corp'] = $new_building[$b_id]['corp'];
	$blockIdDone[$key]['floors'] = $new_building[$b_id]['floors'];
    $blockIdDone[$key]['line'] = $new_building[$b_id]['line'];
    if (empty($value["flatplan"])){
        $blockIdDone[$key]['flatplan'] = "capPlan.png";
    }
    $floor = $new_building[$b_id]['floors'];
	$blockIdDone[$key]['buildingplace'] = $ourBlock;
	$skitchenArray[] = $value["skitchen"];
	$squareArray[] = $value["stotal"];
	$pricesArray[] = $value["baseflatcost"];
}
foreach ($building as $key => $value) {
	$buildArray[(string)$value[0]["corp"]] = array(
        "CONTROL_ID" => "arrFilter_67_".(string)$value[0]["id"],
        "CONTROL_NAME" => "arrFilter_67_".(string)$value[0]["id"],
        "CONTROL_NAME_ALT" => "arrFilter_67",
        "HTML_VALUE_ALT" => (int)$value[0]["id"],
        "HTML_VALUE" => "Y",
        "VALUE" => (string)$value[0]["corp"],
        "SORT" => 0,
        "UPPER" => strtoupper((string)$value[0]["corp"]) ,
        "FLAG" => NULL,
		);
	if ($_REQUEST["arrFilter_67"] == (string)$value[0]["id"]){
		$buildArray[(string)$value[0]["corp"]]["CHECKED"] = true;
	}
}
foreach ($arResult["ITEMS"] as $key => $value) {
	if ($value["CODE"] == "STOTAL"){
		$arResult["ITEMS"][$key]["VALUES"]["MAX"]["VALUE"] = max($squareArray);
		$arResult["ITEMS"][$key]["VALUES"]["MIN"]["VALUE"] = min($squareArray);
	}elseif ($value["CODE"] == "FLATCOST"){
		$arResult["ITEMS"][$key]["VALUES"]["MAX"]["VALUE"] = max($pricesArray);
		$arResult["ITEMS"][$key]["VALUES"]["MIN"]["VALUE"] = min($pricesArray);
	}

}
$arResult["ITEMS"][] = array(
	"ID" => "67",
    "IBLOCK_ID" =>"1",
    "CODE" => "BUILDING",
    "NAME" => "Корпус",
    "PROPERTY_TYPE" => "S",
    "USER_TYPE" => NULL,
    "USER_TYPE_SETTINGS" => NULL,
    "DISPLAY_TYPE" => "F",
    "DISPLAY_EXPANDED" => "Y",
    "VALUES" => $buildArray
);
$arResult["ITEMS"][] = array(
		'ID' => "66",
		"IBLOCK_ID" => "1",
		"CODE" => "SKITCHEN",
		"NAME" => "Площадь кухни",
		"PROPERTY_TYPE" => "N",
		"USER_TYPE" => null,
		"USER_TYPE_SETTINGS" => null,
		"DISPLAY_TYPE" => "A",
	    "DISPLAY_EXPANDED" => "Y",
	    "VALUES" => array(
	    	"MAX" => array(
	    		"CONTROL_ID" => "arrFilter_66_MAX",
	    		"CONTROL_NAME" => "arrFilter_66_MAX",
	    		"VALUE" => max($skitchenArray),
	    		"HTML_VALUE" => (isset($_REQUEST["arrFilter_66_MAX"])) ? $_REQUEST["arrFilter_66_MAX"]: ""
	    	),
	    	"MIN" => array(
	    		"CONTROL_ID" => "arrFilter_66_MIN",
	    		"CONTROL_NAME" => "arrFilter_66_MIN",
	    		"VALUE" => min($skitchenArray),
	    		"HTML_VALUE" => (isset($_REQUEST["arrFilter_66_MAX"])) ? $_REQUEST["arrFilter_66_MIN"]: ""
	    	)
    	)
   );
$arBuffCorp = array();
$arBuffCom = array();
foreach ($_REQUEST as $keys => $values) {
	$buff = array();
	$buff = explode("_",$keys); 
	if ($buff[0] == "arrFilter"){
		if ($buff[1] == "67"){
/*			if ($values == "Y"){
				foreach ($building as $keyss => $valuess) {
					if ($buff[2] == (string)$valuess["id"]){
						$arBuffCorp[] = (string)$valuess["corp"];
					}
				}
			}*/
			foreach ($building as $keyss => $valuess) {
				if ($values == (string)$valuess["id"]){
					$arBuffCorp[] = (string)$valuess["corp"];
				}
			}

		} elseif ($buff[1] == "5"){
			if ($values == "Y"){
				if ($buff[2] == "2366072709"){
					$arBuffCom[] = "4";
				} elseif ($buff[2] == "4194326291"){
					$arBuffCom[] = "3";
				} elseif ($buff[2] == "1790921346"){
					$arBuffCom[] = "2";
				} elseif ($buff[2] == "498629140"){
					$arBuffCom[] = "1";
				} elseif ($buff[2] == "2226203566"){
					$arBuffCom[] = "0";
				} 
			}
		} else {
			unset($buff);
		}
	}else{
		unset($buff);
	}

}
$arSelect = Array(
    "ID",
    "IBLOCK_ID" ,
    "NAME"

);
if (count($blockIdDone) == 0){
	$arResult["DONT_SHOW_FILTER"] = "Y"; 
}else{
	$arResult["DONT_SHOW_FILTER"] = "N"; 
}
if (!empty($arParams["ID_LINK_ZHK"])){
	$arFilter = Array("IBLOCK_ID"=> 6, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","PROPERTY_BUILD" => $arParams["ID_LINK_ZHK"]);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	$atFormat = array();
	while($ob = $res->GetNextElement())
	{
	    $arFields = $ob->GetFields();
	    $prop = $ob->GetProperties();
	    if (!empty($value["PROPERTIES"]["PICTURE_PLAN"]["VALUE"])){
	        $image = CFile::GetFileArray($prop["PICTURE_PLAN"]["VALUE"]);
	        $img = $image["SRC"];
	    }else{
	        $img = "capPlan.png";
	    }
	    if (!isset($ourBlock["title"])){
	    	$resBuf = CIBlockElement::GetByID($arParams["ID_LINK_ZHK"]);
			if($ar_res2 = $resBuf->GetNext())
			  $name = $ar_res2['NAME'];
	    }else{
	    	$name = $ourBlock["title"];
	    }
	    $atFormat = array(
	        "id" => $prop["ID_FOR_REAL"]["VALUE"],
	        "stotal" => $prop["SQUARE"]["VALUE"],
	        "rooms" => $prop["ROOM_AMOUNT"]["VALUE"],
	        "skitchen" => $prop["SQUARE_KITCHEN"]["VALUE"],
	        "baseflatcost" => $prop["PRICE"]["VALUE"],
	        "corp" => $prop["BUILD_PART"]["VALUE"],
	        "sbalcony" => $prop["SQUARE_BALCONY"]["VALUE"],
	        "scorridor" => $prop["SQUARE_HALL"]["VALUE"],
	        "cwatercloset" => $prop["SQUARE_WC"]["VALUE"],
	        "decoration" => $prop["FINISHING"]["VALUE"],
	        "flatplan" => $img,
	        "height" => $prop["CEILING_HEIGHT"]["VALUE"],
	        "flatfloor" => $prop["FLOAT_NUM"]["VALUE"],
	        "sroom" => $prop["LIVING_AREA"]["VALUE"],
	        "floors" =>  $floor ,
	        "buildingplace" => array(
	            "title" => $name
	        )
	    );
	    $blockIdDone[] = $atFormat;
	}
}

foreach ($blockIdDone as $key => $value) {
	if ((!empty($_REQUEST["arrFilter_2_MAX"])) || (!empty($_REQUEST["arrFilter_2_MIN"]))){
		if (!empty($_REQUEST["arrFilter_2_MAX"])){
			if ($value["stotal"] > $_REQUEST["arrFilter_2_MAX"]){
				$blockIdDone[$key]["TO_DELETE"] = true;
			}
		}
		if (!empty($_REQUEST["arrFilter_2_MIN"])){
			if ($value["stotal"] < $_REQUEST["arrFilter_2_MIN"]){
				$blockIdDone[$key]["TO_DELETE"] = true;
			}
		}
	}
	if ((!empty($_REQUEST["arrFilter_1_MAX"])) || (!empty($_REQUEST["arrFilter_1_MIN"]))){
		if (!empty($_REQUEST["arrFilter_1_MAX"])){
			if ($value["baseflatcost"] > $_REQUEST["arrFilter_1_MAX"]){
				$blockIdDone[$key]["TO_DELETE"] = true;
			}
		}
		if (!empty($_REQUEST["arrFilter_1_MIN"])){
			if ($value["baseflatcost"] < $_REQUEST["arrFilter_1_MIN"]){
				$blockIdDone[$key]["TO_DELETE"] = true;
			}
		}
	}
	if ((!empty($_REQUEST["arrFilter_66_MAX"])) || (!empty($_REQUEST["arrFilter_66_MIN"]))){
		if (!empty($_REQUEST["arrFilter_66_MAX"])){
			if ($value["skitchen"] > $_REQUEST["arrFilter_66_MAX"]){
				$blockIdDone[$key]["TO_DELETE"] = true;
			}
		}
		if (!empty($_REQUEST["arrFilter_66_MIN"])){
			if ($value["skitchen"] < $_REQUEST["arrFilter_66_MIN"]){
				$blockIdDone[$key]["TO_DELETE"] = true;
			}
		}
	}

	if (!empty($arBuffCorp)){
		if (!in_array($value["corp"], $arBuffCorp)){
			$blockIdDone[$key]["TO_DELETE"] = true;
		}
	}
	if (!empty($arBuffCom)){
		if ($value["rooms"] > 4){
			$buffRoom = 4;
		}else{
			$buffRoom = $value["rooms"];
		}

		if (!in_array($buffRoom, $arBuffCom)){
			$blockIdDone[$key]["TO_DELETE"] = true;
		}
	}
}
$blocksEl = array();
foreach ($blockIdDone as $key => $value) {
	if ($value["TO_DELETE"] == true){
		unset($blockIdDone[$key]);
	} else {
        $blocksEl[] = $value;
	}
}

$arResult["OBJECT"] = $blocksEl;

$arResult["COUNT_FINDED"] = count($blocksEl);
if ($arResult["COUNT_FINDED"]  > 60 ){
	$arResult["TOTAL_COUNT_PAGE"] = ceil(($arResult["COUNT_FINDED"] / 60));
	$adressQuery = (empty($_SERVER["QUERY_STRING"]))? "?page=" : "&page=";
	$buffString = "<div class='elementsNavString'>";
	if (isset($_REQUEST["page"] ) && $_REQUEST["page"] > 1){
		$buffString .= "<a href ='javascript:void(0)' class='toStart' onclick=\"$('#pageNumber').val('1');$('.smartfilter').submit();\"></a>";
		$buffString .= "<a href ='javascript:void(0)' class='toPrev' onclick=\"$('#pageNumber').val('".($_REQUEST["page"]-1)."');$('.smartfilter').submit();\"></a>";
	}
	for ($i = 0; $i < $arResult["TOTAL_COUNT_PAGE"]; $i++){
		if (isset($_REQUEST["page"] )){
			if ($_REQUEST["page"] > 5 && $_REQUEST["page"] < ($arResult["TOTAL_COUNT_PAGE"] - 4)){
				if (($i+1) < ($_REQUEST["page"] -4) || ($i+1) > ($_REQUEST["page"] + 4)){
					continue;
				}
			}elseif ($_REQUEST["page"] <= 5){
				if (($i+1) > 9){
					continue;
				}
			}elseif ($_REQUEST["page"] >= ($arResult["TOTAL_COUNT_PAGE"] - 4)){
				if (($i+1) < ($arResult["TOTAL_COUNT_PAGE"] - 9)){
					continue;
				}
			}

			if ($_REQUEST["page"] == ($i+1)){
				$buffString  .= "<span>".($i+1)."</span>";
			}else{
				if ($i == 0){
					$buffString  .= "<a href ='javascript:void(0)' onclick=\"$('#pageNumber').val('".($i+1)."');$('.smartfilter').submit();\">".($i+1)."</a>";
				} else {
					$buffString  .= "<a href ='javascript:void(0)' onclick=\"$('#pageNumber').val('".($i+1)."');$('.smartfilter').submit();\">".($i+1)."</a>";
				}
			}
		}else{
			if ($i > 9){
				continue;
			}
			if ($i == 0){
				$buffString  .= "<span>".($i+1)."</span>";
			} else {
				$buffString  .= "<a href ='javascript:void(0)' onclick=\"$('#pageNumber').val('".($i+1)."');$('.smartfilter').submit();\">".($i+1)."</a>";
			}
		}
	}
	if (isset($_REQUEST["page"] ) && $_REQUEST["page"] < $arResult["TOTAL_COUNT_PAGE"]){
		$buffString .= "<a class='toNext' href ='javascript:void(0)' onclick=\"$('#pageNumber').val('".($_REQUEST["page"]+1)."');$('.smartfilter').submit();\"></a>";
		$buffString .= "<a class='toEnd' href ='javascript:void(0)' onclick=\"$('#pageNumber').val('".$arResult["TOTAL_COUNT_PAGE"]."');$('.smartfilter').submit();\"></a>";
		
	}
	$buffString .= "</div>";
}else{
	$buffString = "";
}
$arResult["NAV_STRING"] = $buffString;
$arParams["FILTER_VIEW_MODE"] = (isset($arParams["FILTER_VIEW_MODE"]) && $arParams["FILTER_VIEW_MODE"] == "horizontal") ? "horizontal" : "vertical";
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";

