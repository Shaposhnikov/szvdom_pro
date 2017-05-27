<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
$blockidall = $xml->xpath("/Ads/Apartments/Apartment[@blockid='" . $arParams["XML_ID"]. "']");
$building = $xml->xpath("/Ads/Buildings/Building[@blockid='" . $arParams["XML_ID"]. "']");
$blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $arParams["XML_ID"]. "']");
$roomType = $xml->xpath("/Ads/RoomTypes/RoomType");
foreach($building as $item) {
	$id = (string)$item[0]['id'];
	$corp = (string)$item[0]['corp'];
	$floors = (string)$item[0]['floors'];
	$endingperiod = (string)$item[0]['endingperiod'];
	$new_building[$id] = array("corp" => $corp, "floors" => $floors, "endingperiod" => $endingperiod);
}
$json = json_encode($blockidall);
$arrayXml = json_decode($json,TRUE);
$json2 = json_encode($blocks);
$arrayXml2 = json_decode($json2,TRUE);
foreach ($arrayXml as $key => $value) {
	$blockIdDone[] = $value["@attributes"];
}
$ourBlock = $arrayXml2[0]["@attributes"];

$skitchenArray = array();
$squareArray = array();
$pricesArray = array();
$arResult["BLOCK"] = $ourBlock;
foreach ($blockIdDone as $key => $value) {
	foreach ($roomType as $tkey => $type) {
		if ($value["rooms"] == (string)$type[0]["id"]){
			$blockIdDone[$key]["roomtype"] = (string)$type[0]["name"];
		}
	}
	$b_id = (string)$value['buildingid'];
	$blockIdDone[$key]['endingperiod'] = $new_building[$b_id]['endingperiod'];
	$blockIdDone[$key]['corp'] = $new_building[$b_id]['corp'];
	$blockIdDone[$key]['floors'] = $new_building[$b_id]['floors'];
	$skitchenArray[] = $value["skitchen"];
	$squareArray[] = $value["stotal"];
	$pricesArray[] = $value["baseflatcost"];
}
$arFilter = Array("IBLOCK_ID"=> 6, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","PROPERTY_BUILD" => $arParams["ID_LINK_ZHK"]);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
$atFormat = array();
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $prop = $ob->GetProperties();
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
            "title" => $ourBlock["title"]
        )
    );
    $blockIdDone[] = $atFormat;
}
$bufLabel =array();
foreach ($blockIdDone as $value) {
	$bufLabel[] = $value["rooms"]; 
}
$arMirror = array_unique($bufLabel);
$arLabel = array();
foreach ($blockIdDone as $value) {
	$arLabel[$value["rooms"]]["PRICE_BASIC"][] = $value["baseflatcost"];
    $query = "";
    if ($value["rooms"] == "4"){
        $query .= "?arrFilter_5_2366072709=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }elseif ($value["rooms"] == "3" || $value["rooms"] == "23"){
        $query .= "?arrFilter_5_4194326291=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }elseif ($value["rooms"] == "2" || $value["rooms"] == "22"){
        $query .= "?arrFilter_5_1790921346=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }elseif ($value["rooms"] == "1"){
        $query .= "?arrFilter_5_498629140=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }elseif ($value["rooms"] == "0"){
        $query .= "?arrFilter_5_2226203566=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }
	$arLabel[$value["rooms"]]["PRICE_PER_METER"][] = round(($value["baseflatcost"]/$value["stotal"]),0);
    if (!empty($value["flatcostwithdiscounts"])) {
        $arLabel[$value["rooms"]]["PRICE_DISCOUNT"][] = $value["flatcostwithdiscounts"];
    }
	$arLabel[$value["rooms"]]["SQUARE"][] = $value["stotal"];
	if (!isset($arLabel[$value["rooms"]]["COUNT"])){
		$arLabel[$value["rooms"]]["COUNT"] = 1;
	}else{
		$arLabel[$value["rooms"]]["COUNT"]++;
	}
    if (!empty($value["flatplan"])) {
        $arLabel[$value["rooms"]]["IMAGE"] = $value["flatplan"];
    }
    if (!empty($value["rooms"])) {
        $arLabel[$value["rooms"]]["LABEL"] = $value["rooms"];
    }
    if (!empty($value["roomtype"])){
        $arLabel[$value["rooms"]]["LABEL_TYPE"] = $value["roomtype"];
    }
    $arLabel[$value["rooms"]]["QUERY_STRING"] = $query;
}
ksort($arLabel);

$arResult["ITEMS"] = $arLabel;

$this->IncludeComponentTemplate();
?>