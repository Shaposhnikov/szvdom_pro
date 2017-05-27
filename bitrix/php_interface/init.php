<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/classes/SZVayers.class.php");
ini_set('memory_limit','256M');
function print_pre($value,$hidden = false) {
    if ($hidden == true){ echo "<div class='debug' style='display: none;'>"; }
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    if ($hidden == true){ echo "</div>"; }
}


function user_browser($agent) {
    preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/", $agent, $browser_info);
    list(,$browser,$version) = $browser_info;
    if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera)) return 'Opera '.$opera[1];
    if ($browser == 'MSIE') {
        preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie);
        if ($ie) return 'IE|'.$version;
        return 'IE|'.$version;
    }
    if ($browser == 'Firefox') {
        preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff);
        if ($ff) return $ff[1].'|'.$ff[2];
    }
    if ($browser == 'Opera' && $version == '9.80') return 'Opera|'.substr($agent,-5);
    if ($browser == 'Version') return 'Safari|'.$version;
    if (!$browser && strpos($agent, 'Gecko')) return 'Browser based on Gecko';
    return $browser.'|'.$version;
}
function getBrowser($agent){
    $brow = user_browser($agent);
    $browTit = explode("|", $brow);
    $answer = true;
    $number = explode(".", $browTit[1]);
    if ($browTit[0] == "Chrome"){
        if ($number[0] < 22){
            $answer = false;
        }else{
            $answer = true;
        }
    }elseif ($browTit[0] == "Firefox"){
        if ($number[0] < 30){
            $answer = false;
        }else{
            $answer = true;
        }
    }elseif ($browTit[0] == "Opera"){
        $answer = false;
    }elseif ($browTit[0] == "IE"){
        if ($number[0] < 10){
            $answer = false;
        }else{
            $answer = true;
        }
    }elseif ($browTit[0] == "Safari"){
        if ($number[0] < 5){
            $answer = false;
        }else{
            if ($number[1] < 1){
                $answer = false;
            }else{
              $answer = true;  
            } 
        }
    }else{
        $answer = true;
    }
    return $answer;
}


function getJKtmb($ID, $sSrcPath=''){
CModule::IncludeModule("iblock");
$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");
	//$arFilter = Array("ID"=> $ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$arFilter = Array("ID"=> $ID, "ACTIVE_DATE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement()){ 

 $arProps = $ob->GetProperties();

$sImgSrc = $arProps["AVATAR"]["VALUE"];
}

	$sTmbPath='/include/tmb/';
	$ImgTmbFullPath = $sTmbPath.$sImgSrc;
	$ImgSrcFullPath = $sSrcPath.$sImgSrc;

	if (!file_exists($_SERVER["DOCUMENT_ROOT"].$ImgTmbFullPath)){

		$st = CFile::ResizeImageFile(
			$sourceFile = $_SERVER["DOCUMENT_ROOT"].$ImgSrcFullPath,
			$destinationFile = $_SERVER["DOCUMENT_ROOT"].$ImgTmbFullPath,
			$arSize = array('width'=>280, 'height'=>400),
			$resizeType = BX_RESIZE_IMAGE_PROPORTIONAL,
			$arWaterMark = array(),
			$jpgQuality=45,
			$arFilters =false
		);
		if($st == false ){
			//echo'*';
			return $ImgSrcFullPath;
		}
		return $ImgTmbFullPath;//$ImgSrcFullPath;//$ImgTmbFullPath;
	}
	return $ImgTmbFullPath;
	}


function user_min_browser($agent) {
    preg_match("/(MSIE|Opera|Firefox|Chrome|Version)(?:\/| )([0-9.]+)/", $agent, $browser_info);
    list(,$browser,$version) = $browser_info;
    if ($browser == 'Opera' && $version == '9.80') return 'Opera '.substr($agent,-5);
    if ($browser == 'Version') return 'Safari '.$version;
    if (!$browser && strpos($agent, 'Gecko')) return 'Browser based on Gecko';
    return $browser.'|'.$version;
}

class objectsParser {

    private $xml;
	private $time_start;
	private $IBLOCK_ID = 1;
    
    public function __construct() { 
	
      $this->xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
	  $this->time_start = microtime(true);
	  
    }

    function updatePrice($value){

        if (CModule::IncludeModule("iblock")) {

            $OBJECT_ID = NULL;
            $OBJECT_NAME = NULL;
            $IBLOCK_ID = 1;
            $arr_Objekts = $this->makeObjectXml($value);

            $CHECK_ERROR = array();

            foreach ($arr_Objekts as $key => $array) {

                $arFilter = array("IBLOCK_ID" => $IBLOCK_ID, array("LOGIC" => "AND", array("PROPERTY_SECOND_ID" => $key)));
                $res = CIBlockElement::GetList(array(), $arFilter, false, array(), array("ID", "NAME"));
                while ($ob = $res->GetNextElement()) {
                    $OBJECT_FIELDS = $ob->GetFields();
                    $OBJECT_ID = $OBJECT_FIELDS['ID'];
                    $OBJECT_NAME = $OBJECT_FIELDS['NAME'];
                }

                if ($OBJECT_ID) {

                    $ROOMS = $this->getPropertyID($array['APARTMENTS']['rooms'], "ROOM_NUM", true);
                    $BANKS = $this->getPropertyID($array['BANKS'],"BANKS",true);

                    if ($array['BUILDINGS']['endingperiod']['MAX'] < date("Y")) {
                        $dateEnd = "Сдан";
                    } else {
                        $dateEnd = array($array['BUILDINGS']['endingperiod']['MIN'], $array['BUILDINGS']['endingperiod']['MAX']);
                    }

                    $PROP = array();
                    $PROP['139'] = array($array['APARTMENTS']['flatcost']['MIN'], $array['APARTMENTS']['flatcost']['MAX']);
                    $PROP['1'] = array($array['APARTMENTS']['flatcost_visual']['MIN'], $array['APARTMENTS']['flatcost_visual']['MAX']);
                    $PROP['2'] = array($array['APARTMENTS']['stotal']['MIN'], $array['APARTMENTS']['stotal']['MAX']);
                    $PROP['3'] = $dateEnd;
                    $PROP['5'] = $ROOMS;
                    $PROP['14'] = $BANKS;


                    CIBlockElement::SetPropertyValuesEx($OBJECT_ID, $IBLOCK_ID, $PROP);
                    $CHECK_ERROR[] = $OBJECT_NAME;
                    unset($OBJECT_ID);

                }else{
                    return false;
                    exit;
                }

            }

        }

        return true;

    }


    function updateObjektsFull($value) {

        if (CModule::IncludeModule("iblock")) {

            $OBJECT_ID = NULL;
            $OBJECT_NAME = NULL;
            $IBLOCK_ID = 1;
            $arr_Objekts = $this->makeObjectXml($value);

            $CHECK_ERROR = array();

            foreach ($arr_Objekts as $key => $array) {

                $arFilter = array("IBLOCK_ID" => $IBLOCK_ID, array("LOGIC" => "AND", array("PROPERTY_SECOND_ID" => $key)));
                $res = CIBlockElement::GetList(array(), $arFilter, false, array(), array("ID", "NAME"));
                while($ob = $res->GetNextElement()) {
                    $OBJECT_FIELDS = $ob->GetFields();
                    $OBJECT_ID = $OBJECT_FIELDS['ID'];
                    $OBJECT_NAME = $OBJECT_FIELDS['NAME'];
                }

                if ($OBJECT_ID) {

                    $ROOMS = $this->getPropertyID($array['APARTMENTS']['rooms'], "ROOM_NUM", true);
                    $EXTRAS = $this->getPropertyID($array['EXTRAS'], "EXTRAS", false);
                    $METRO = $this->getPropertyID($array['SUBWAYS'], "SUBWAYS", true);
                    $REGION = $this->getPropertyID(array($array['REGION_ID']), "REGION", false);
                    $BANKS = $this->getPropertyID($array['BANKS'],"BANKS",true);
                    $BUILDINGTYPE_PROT = $this->getPropertyID($array['BUILDINGS']['buildingtype'],"BUILDINGTYPE",false);
                    $BUILDINGTYPE = array_unique($BUILDINGTYPE_PROT);
                    $BUILDER = $this->getPropertyID(array($array['BUILDER']),"BUILDER",false);

                    if ($array['BUILDINGS']['endingperiod']['MAX'] < date("Y")){
                        $dateEnd = "Сдан";
                    }else{
                        $dateEnd = array($array['BUILDINGS']['endingperiod']['MIN'], $array['BUILDINGS']['endingperiod']['MAX']);
                    }


                    $lines = array();
                    foreach ($array['BUILDINGS']['countline'] as $kkk => $value){
                        $array['BUILDINGS']['countline'][$kkk] = array_unique($value);
                    }
                    foreach ($array['BUILDINGS']['countlinecorp'] as $jjj => $value){

                        if (count($array['BUILDINGS']['countline'][$jjj]) > 1){
                            foreach ($array['BUILDINGS']['countline'][$jjj] as $j => $end){
                                $yearAr = explode('.',$end);
                                if ($yearAr[2] < date('Y')){
                                    $dataLine = " сдан";
                                }else{
                                    $dataLine = $end;
                                }
                                if ($dataLine != " сдан"){
                                    $lines[] = $jjj." оч (".$array['BUILDINGS']['countlinecorp'][$jjj][$j].") - ".$dataLine." г." ;
                                }else{
                                    $lines[] = $jjj." оч (".$array['BUILDINGS']['countlinecorp'][$jjj][$j].") - ".$dataLine ;
                                }
                            }
                        }else{
                            $yearAr = explode('.',$array['BUILDINGS']['countline'][$jjj][0]);
                            if ($yearAr[2] < date('Y')){
                                $dataLine = " сдан";
                            }else{
                                $dataLine = $array['BUILDINGS']['countline'][$jjj][0];
                            }
                            if ($dataLine != " сдан"){
                                $lines[] = $jjj." оч - ".$dataLine." г." ;
                            }else{
                                $lines[] = $jjj." оч - ".$dataLine ;
                            }
                        }
                    }
                    asort($lines);

                    $PROP = array();
                    $PROP['139'] = array($array['APARTMENTS']['flatcost']['MIN'], $array['APARTMENTS']['flatcost']['MAX']);
                    $PROP['1'] = array($array['APARTMENTS']['flatcost_visual']['MIN'], $array['APARTMENTS']['flatcost_visual']['MAX']);
                    $PROP['2'] = array($array['APARTMENTS']['stotal']['MIN'], $array['APARTMENTS']['stotal']['MAX']);
                    $PROP['3'] = $dateEnd;
                    $PROP['4'] = $EXTRAS;
                    $PROP['5'] = $ROOMS;
                    $PROP['6'] = $REGION;
                    $PROP['7'] = $BUILDER;
                    $PROP['10'] = $METRO;
                    $PROP['11'] = $array['LATITUDE'];
                    $PROP['12'] = $array['LONGITUDE'];
                    $PROP['13'] = $array['ADDRESS'];
                    $PROP['14'] = $BANKS;
                    $PROP['15'] = $BUILDINGTYPE;
                    $PROP['16'] = $array['AVATAR'];
                    $PROP['102'] = $lines;

                    CIBlockElement::SetPropertyValuesEx($OBJECT_ID, $IBLOCK_ID, $PROP);
                    $CHECK_ERROR[] = $OBJECT_NAME;
                    unset($OBJECT_ID);

                }else{
                    return false;
                    exit;
                }

            }

        }

        return true;
    }


    function updateObjektsCron() {

        if (CModule::IncludeModule("iblock")) {

            $OBJECT_ID = NULL;
            $OBJECT_NAME = NULL;
            $IBLOCK_ID = 1;
            $arr_Objekts = $this->makeArray();

            $CHECK_ERROR = array();

            foreach ($arr_Objekts as $key => $array) {

                $arFilter = array("IBLOCK_ID" => $IBLOCK_ID, array("LOGIC" => "AND", array("PROPERTY_SECOND_ID" => $key)));
                $res = CIBlockElement::GetList(array(), $arFilter, false, array(), array("ID", "NAME","PROPERTY_XML_UPDATE"));
                while($ob = $res->GetNextElement()) {
                    $OBJECT_FIELDS = $ob->GetFields();
                    $OBJECT_ID = $OBJECT_FIELDS['ID'];
                    $OBJECT_NAME = $OBJECT_FIELDS['NAME'];
                    $UPDATE_XML = $OBJECT_FIELDS['PROPERTY_XML_UPDATE_VALUE'];
                }

                if ($OBJECT_ID) {
                    if (strtolower($UPDATE_XML) != "нет"){
                        $ROOMS = $this->getPropertyID($array['APARTMENTS']['rooms'], "ROOM_NUM", true);
                        $BANKS = $this->getPropertyID($array['BANKS'],"BANKS",true);

                        if ($array['BUILDINGS']['endingperiod']['MAX'] < date("Y")){
                            $dateEnd = "Сдан";
                        }else{
                            $dateEnd = array($array['BUILDINGS']['endingperiod']['MIN'], $array['BUILDINGS']['endingperiod']['MAX']);
                        }

                        $PROP = array();
                        $PROP['139'] = array($array['APARTMENTS']['flatcost']['MIN'], $array['APARTMENTS']['flatcost']['MAX']);
                        $PROP['1'] = array($array['APARTMENTS']['flatcost_visual']['MIN'], $array['APARTMENTS']['flatcost_visual']['MAX']);
                        $PROP['2'] = array($array['APARTMENTS']['stotal']['MIN'], $array['APARTMENTS']['stotal']['MAX']);
                        $PROP['3'] = $dateEnd;
                        $PROP['5'] = $ROOMS;
                        $PROP['14'] = $BANKS;

                        CIBlockElement::SetPropertyValuesEx($OBJECT_ID, $IBLOCK_ID, $PROP);
                        $CHECK_ERROR[] = $OBJECT_NAME;
                        unset($OBJECT_ID);

                    }
                }


            }

        }

        $msg = "Обновлена база по " . count($CHECK_ERROR) . " из " . count($arr_Objekts) . " объекта: \n"
            . implode(", \n", $CHECK_ERROR) . "\nВремя работы скрипта: "
            . (microtime(true) - $this->time_start) . " sec.\n"
            . "Отправлено в: " . date("H:i:s d.m.Y");
        mail("sendmail@ayers.ru", "Parser info.", $msg);
        $arFields = array("EMAIL_TO" => "andkuchmin@yandex.ru", "TEXT" => $msg);
        CEvent::Send("FEEDBACK_FORM", "s1", $arFields, "N", 8);

    }



	function updateObjekts() {
		
		if (CModule::IncludeModule("iblock")) {
			
			$OBJECT_ID = NULL;
			$OBJECT_NAME = NULL;
			$IBLOCK_ID = 1;
			$arr_Objekts = $this->makeArray();
			
			$CHECK_ERROR = array();
			
			foreach ($arr_Objekts as $key => $array) {

				$arFilter = array("IBLOCK_ID" => $IBLOCK_ID, array("LOGIC" => "AND", array("PROPERTY_SECOND_ID" => $key)));
				$res = CIBlockElement::GetList(array(), $arFilter, false, array(), array("ID", "NAME"));
				while($ob = $res->GetNextElement()) {
					$OBJECT_FIELDS = $ob->GetFields();
					$OBJECT_ID = $OBJECT_FIELDS['ID'];
					$OBJECT_NAME = $OBJECT_FIELDS['NAME'];
				}
				
				if ($OBJECT_ID) {
				
					$ROOMS = $this->getPropertyID($array['APARTMENTS']['rooms'], "ROOM_NUM", true);
					$EXTRAS = $this->getPropertyID($array['EXTRAS'], "EXTRAS", false);
					$METRO = $this->getPropertyID($array['SUBWAYS'], "SUBWAYS", true);
					$REGION = $this->getPropertyID(array($array['REGION_ID']), "REGION", false);
                    $BANKS = $this->getPropertyID($array['BANKS'],"BANKS",true);
                    $BUILDINGTYPE_PROT = $this->getPropertyID($array['BUILDINGS']['buildingtype'],"BUILDINGTYPE",false);
                    $BUILDINGTYPE = array_unique($BUILDINGTYPE_PROT);
                    $BUILDER = $this->getPropertyID(array($array['BUILDER']),"BUILDER",false);

                    if ($array['BUILDINGS']['endingperiod']['MAX'] < date("Y")){
                        $dateEnd = "Сдан";
                    }else{
                        $dateEnd = array($array['BUILDINGS']['endingperiod']['MIN'], $array['BUILDINGS']['endingperiod']['MAX']);
                    }
                    $lines = array();
                    foreach ($array['BUILDINGS']['countline'] as $kkk => $value){
                        $array['BUILDINGS']['countline'][$kkk] = array_unique($value);
                    }
                    foreach ($array['BUILDINGS']['countlinecorp'] as $jjj => $value){

                        if (count($array['BUILDINGS']['countline'][$jjj]) > 1){
                            foreach ($array['BUILDINGS']['countline'][$jjj] as $j => $end){
                                $yearAr = explode('.',$end);
                                if ($yearAr[2] < date('Y')){
                                    $dataLine = " сдан";
                                }else{
                                    $dataLine = $end;
                                }
                                if ($dataLine != " сдан"){
                                    $lines[] = $jjj." оч (".$array['BUILDINGS']['countlinecorp'][$jjj][$j].") - ".$dataLine." г." ;
                                }else{
                                    $lines[] = $jjj." оч (".$array['BUILDINGS']['countlinecorp'][$jjj][$j].") - ".$dataLine ;
                                }
                            }
                        }else{
                            $yearAr = explode('.',$array['BUILDINGS']['countline'][$jjj][0]);
                            if ($yearAr[2] < date('Y')){
                                $dataLine = " сдан";
                            }else{
                                $dataLine = $array['BUILDINGS']['countline'][$jjj][0];
                            }
                            if ($dataLine != " сдан"){
                                $lines[] = $jjj." оч - ".$dataLine." г." ;
                            }else{
                                $lines[] = $jjj." оч - ".$dataLine ;
                            }
                        }
                    }
                    asort($lines);

                    $PROP = array();
                    $PROP['139'] = array($array['APARTMENTS']['flatcost']['MIN'], $array['APARTMENTS']['flatcost']['MAX']);
                    $PROP['1'] = array($array['APARTMENTS']['flatcost_visual']['MIN'], $array['APARTMENTS']['flatcost_visual']['MAX']);
                    $PROP['2'] = array($array['APARTMENTS']['stotal']['MIN'], $array['APARTMENTS']['stotal']['MAX']);
                    $PROP['3'] = $dateEnd;
                    $PROP['4'] = $EXTRAS;
                    $PROP['5'] = $ROOMS;
                    $PROP['6'] = $REGION;
                    $PROP['7'] = $BUILDER;
                    $PROP['10'] = $METRO;
                    $PROP['11'] = $array['LATITUDE'];
                    $PROP['12'] = $array['LONGITUDE'];
                    $PROP['13'] = $array['ADDRESS'];
                    $PROP['14'] = $BANKS;
                    $PROP['15'] = $BUILDINGTYPE;
                    $PROP['16'] = $array['AVATAR'];
                    $PROP['102'] = $lines;

					CIBlockElement::SetPropertyValuesEx($OBJECT_ID, $IBLOCK_ID, $PROP);
					$CHECK_ERROR[] = $OBJECT_NAME;
					unset($OBJECT_ID);
					
				}

			}
			
		}
		
		$msg = "Обновлена база по " . count($CHECK_ERROR) . " из " . count($arr_Objekts) . " объекта: \n" 
				. implode(", \n", $CHECK_ERROR) . "\nВремя работы скрипта: " 
				. (microtime(true) - $this->time_start) . " sec.\n"
				. "Отправлено в: " . date("H:i:s d.m.Y"); 
		mail("sendmail@ayers.ru", "Parser info.", $msg);
		$arFields = array("EMAIL_TO" => "andkuchmin@yandex.ru", "TEXT" => $msg);
		CEvent::Send("FEEDBACK_FORM", "s1", $arFields, "N", 8);
		
	}
	
	function getPropertyID($array, $code, $k) {
	
		$result = array();
		$dummy = array();
		
		$property = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$this->IBLOCK_ID, "CODE"=>$code));
		while($fields = $property->GetNext()) {
			$xmlID = $fields["XML_ID"];
			$dummy[$xmlID] = array("ID" => $fields["ID"], "XML_ID" => $fields["XML_ID"], "VALUE" => $fields["VALUE"]);
		}
		
		foreach($array as $key => $val) {
			if ($k) $result[] = $dummy[$key]['ID'];
			else $result[] = $dummy[$val]['ID'];
		}
	
		return $result;
	
	}


    function makeObjectXml($value){
        $OBJECTS = array();
        $Blocks = $this->xml->xpath("/Ads/Blocks/Block[@id='" . $value . "']");

        foreach ($Blocks as $Block) {

            $blockID = (string)$Block[0]['id'];
            $region = $this->xml->xpath("/Ads/Regions/Region[@id='" . (string)$Block[0]['region'] . "']");
            $builder = $this->xml->xpath("/Ads/Builders/Builder[@id='" . (string)$Block[0]['builderid'] . "']");
            $blocksubways = $this->xml->xpath("/Ads/BlockSubways/BlockSubway[@blockid='" . $blockID . "']");
            $banks = $this->xml->xpath("/Ads/Mortgages/Mortgage[@blockid='" . $blockID . "']");
            $buildings = $this->xml->xpath("/Ads/Buildings/Building[@blockid='" . $blockID . "']");
            $apartments = $this->xml->xpath("/Ads/Apartments/Apartment[@blockid='" . $blockID . "']");

            $toArraySubways = $this->toArraySubways($blocksubways);
            $toArrayBanks = $this->toArrayBanks($banks);
            $toArrayBuildings = $this->toArrayBuildings($buildings);
            $toArrayApartments = $this->toArrayApartments($apartments);

            $OBJECTS[$blockID]['ID'] = $blockID;
            $OBJECTS[$blockID]['TITLE'] = (string)$Block[0]['title'];
            $OBJECTS[$blockID]['ADDRESS'] = (string)$Block[0]['address'];
            $OBJECTS[$blockID]['LATITUDE'] = (string)$Block[0]['latitude'];
            $OBJECTS[$blockID]['LONGITUDE'] = (string)$Block[0]['longitude'];
            $OBJECTS[$blockID]['AVATAR'] = (string)$Block[0]['avatar'];
            $OBJECTS[$blockID]['REGION_ID'] = (string)$region[0]['id'];
            $OBJECTS[$blockID]['REGION'] = (string)$region[0]['name'];
            $OBJECTS[$blockID]['BUILDER'] = (string)$builder[0]['id'];
            $OBJECTS[$blockID]['SUBWAYS'] = $toArraySubways;
            $OBJECTS[$blockID]['BANKS'] = $toArrayBanks;
            $OBJECTS[$blockID]['BUILDINGS'] = $toArrayBuildings;
            $OBJECTS[$blockID]['APARTMENTS'] = $toArrayApartments;
            $OBJECTS[$blockID]['EXTRAS'] = array($toArrayBuildings['mortgage'], $toArrayApartments['creditend'], $toArrayApartments['decoration']);

        }

        return $OBJECTS;
    }

	function makeArray() {
	
		$OBJECTS = array();
		$Blocks = $this->xml->xpath("/Ads/Blocks/Block");
		
		foreach ($Blocks as $Block) {
			
			$blockID = (string)$Block[0]['id'];
			$region = $this->xml->xpath("/Ads/Regions/Region[@id='" . (string)$Block[0]['region'] . "']");
			$builder = $this->xml->xpath("/Ads/Builders/Builder[@id='" . (string)$Block[0]['builderid'] . "']");
			$blocksubways = $this->xml->xpath("/Ads/BlockSubways/BlockSubway[@blockid='" . $blockID . "']");
			$banks = $this->xml->xpath("/Ads/Mortgages/Mortgage[@blockid='" . $blockID . "']");
			$buildings = $this->xml->xpath("/Ads/Buildings/Building[@blockid='" . $blockID . "']");
			$apartments = $this->xml->xpath("/Ads/Apartments/Apartment[@blockid='" . $blockID . "']");
			
			$toArraySubways = $this->toArraySubways($blocksubways);
			$toArrayBanks = $this->toArrayBanks($banks);
			$toArrayBuildings = $this->toArrayBuildings($buildings);
			$toArrayApartments = $this->toArrayApartments($apartments);

			$OBJECTS[$blockID]['ID'] = $blockID;
			$OBJECTS[$blockID]['TITLE'] = (string)$Block[0]['title'];
			$OBJECTS[$blockID]['ADDRESS'] = (string)$Block[0]['address'];
			$OBJECTS[$blockID]['LATITUDE'] = (string)$Block[0]['latitude'];
			$OBJECTS[$blockID]['LONGITUDE'] = (string)$Block[0]['longitude'];
			$OBJECTS[$blockID]['AVATAR'] = (string)$Block[0]['avatar'];
			$OBJECTS[$blockID]['REGION_ID'] = (string)$region[0]['id'];
			$OBJECTS[$blockID]['REGION'] = (string)$region[0]['name'];
			$OBJECTS[$blockID]['BUILDER'] = (string)$builder[0]['id'];
			$OBJECTS[$blockID]['SUBWAYS'] = $toArraySubways;
			$OBJECTS[$blockID]['BANKS'] = $toArrayBanks;
			$OBJECTS[$blockID]['BUILDINGS'] = $toArrayBuildings;
			$OBJECTS[$blockID]['APARTMENTS'] = $toArrayApartments;
			$OBJECTS[$blockID]['EXTRAS'] = array($toArrayBuildings['mortgage'], $toArrayApartments['creditend'], $toArrayApartments['decoration']);
			
		}
		
		return $OBJECTS;
		
	}
	
	function toArraySubways($array) {
		
		$result = array();
		
		foreach ($array as $item) {
		
			$itemID = (string)$item[0]['subwayid'];
			$subway = $this->xml->xpath("/Ads/Subways/Subway[@id='" . $itemID . "']");
			
			$result[$itemID] = (string)$subway[0]['name'];
			
		}
		
		return $result;
		
	}
	
	function toArrayBanks($array) {
		
		$result = array();
		
		foreach ($array as $item) {
		
			$itemID = (string)$item[0]['bankid'];
			$bank = $this->xml->xpath("/Ads/Banks/Bank[@id='" . $itemID . "']");
			
			$result[$itemID] = (string)$bank[0]['name'];
			
		}
		
		return $result;
		
	}
	
	function toArrayBuildings($array) {
		
		$result = array();
		$result['mortgage'] = NULL;
		
		foreach ($array as $item) {
			$endingPeriod = (int)substr((string)$item[0]['endingperiod'], -4);
			if ((string)$item[0]['mortgage'])
				$result['mortgage'] = "IPO";

            //$buildTypeTrue = $this->xml->xpath("/Ads/BuildingTypes/BuildingType[@id='" . (string)$item[0]['buildingtype'] . "']");
			if (in_array((string)$buildTypeTrue[0]['name'], $result['buildingtype'])) {} else {

				//$result['buildingtype'][] = (string)$buildTypeTrue[0]['name'];
                $result['buildingtype'][] = (string)$item[0]['buildingtype'];
			}
			
			if (!isset($result['endingperiod']['MIN']) || !isset($result['endingperiod']['MAX'])) {
				$result['endingperiod']['MIN'] = $endingPeriod;
				$result['endingperiod']['MAX'] = $endingPeriod;
			}
			if (isset($result['endingperiod']['MIN']) && $result['endingperiod']['MIN'] > $endingPeriod)
				$result['endingperiod']['MIN'] = $endingPeriod;
			if (isset($result['endingperiod']['MAX']) && $result['endingperiod']['MAX'] < $endingPeriod)
				$result['endingperiod']['MAX'] = $endingPeriod;

            $result["countline"][(string)$item["line"]][] = (string)$item["endingperiod"];
            $result["countlinecorp"][(string)$item["line"]][] = (string)$item["corp"];

		}
		return $result;
		
	}
	
	function toArrayApartments($array) {
		
		$result = array();
		$result['creditend'] = NULL;
		$result['decoration'] = NULL;
		$roomIDsOut = array(25,26,28,29,30);
		
		foreach ($array as $item) {
			
			$flatCost = (int)$item[0]['flatcostwithdiscounts'];
			$stotal = (int)$item[0]['stotal'];
			$roomID = (string)$item[0]['rooms'];

            if ($roomID == "25") { continue; }

            if (!isset($result['flatcost']['MIN']) || !isset($result['flatcost']['MAX'])) {
				$result['flatcost']['MIN'] = $flatCost;
				$result['flatcost']['MAX'] = $flatCost;
			}
			if (isset($result['flatcost']['MIN']) && $result['flatcost']['MIN'] > $flatCost)
				$result['flatcost']['MIN'] = $flatCost;
			if (isset($result['flatcost']['MAX']) && $result['flatcost']['MAX'] < $flatCost)
				$result['flatcost']['MAX'] = $flatCost;
				
			if (!isset($result['stotal']['MIN']) || !isset($result['stotal']['MAX'])) {
				$result['stotal']['MIN'] = $stotal;
				$result['stotal']['MAX'] = $stotal;
			}
			if (isset($result['stotal']['MIN']) && $result['stotal']['MIN'] > $stotal)
				$result['stotal']['MIN'] = $stotal;
			if (isset($result['stotal']['MAX']) && $result['stotal']['MAX'] < $stotal)
				$result['stotal']['MAX'] = $stotal;
				
			if ((string)$item[0]['creditend'])
				$result['creditend'] = "RAS";
				
			if ((string)$item[0]['decoration'] != "Без отделки")
				$result['decoration'] = "OTD";


			if (!in_array($roomID, $roomIDsOut)) {
				
				if ($roomID === "0") $result['rooms']['S'] = "Ст";					
				if ($roomID === "1") $result['rooms']['1'] = "1";					
				if (in_array($roomID, array(2,22))) $result['rooms']['2'] = "2";				
				if (in_array($roomID, array(3,23))) $result['rooms']['3'] = "3";
				if (in_array($roomID, array(4,21)) || ($roomID > "4" && $roomID < "10")) 
					$result['rooms']['M'] = "4+";
			
			}
			
		}
		
		/*$flatcostMIN = $result['flatcost']['MIN'] * 0.2;
		$flatcostMAX = $result['flatcost']['MAX'] * 0.2;
		$result['flatcost']['MIN'] = $result['flatcost']['MIN'] - (int)$flatcostMIN;
		$result['flatcost']['MAX'] = $result['flatcost']['MAX'] + (int)$flatcostMAX;*/
        $flatcostMIN = $result['flatcost']['MIN'] * 0.2;
        $flatcostMAX = $result['flatcost']['MAX'] * 0.2;
        $result['flatcost_visual']['MIN'] = $result['flatcost']['MIN'] - (int)$flatcostMIN;
        $result['flatcost_visual']['MAX'] = $result['flatcost']['MAX'] + (int)$flatcostMAX;
        if ($result['flatcost']['MAX'] > 36000000){
            $result['flatcost']['MAX'] = 36000000;
        }
        if ($result['flatcost_visual']['MAX'] > 36000000){
            $result['flatcost_visual']['MAX'] = 36000000;
        }
		return $result;
		
	}
	
}



class imageUpload{

    function getContent($path){
        $csv = array();

        if (($handle = fopen($path , "r")) !== false) {

            while(!feof($handle)) {
                $csv[] = explode(";",fgets($handle));
            }
            fclose($handle);
        }
        return $csv;
    }

    function getIds($array){
        CModule::IncludeModule("iblock");
        $ids = array();
        $arIds = array();
        foreach ($array as $key => $csv){
            $arIds[] = $csv[0];
            if (empty($csv[1])){
                $doneIds['DESC'][$csv[0]][] = "Изображение ".($key+1);
                $desc = "Изображение ".($key+1);
            }else {
                $doneIds['DESC'][$csv[0]][] = $csv[1];
                $desc = $csv[1];
            }
            $temp = CFile::MakeFileArray($csv[2]);
            $doneIds['IMAGES'][$csv[0]][] = $temp;
        }
        $doneIds["IDS"] = array_unique($arIds);

        return $doneIds;
    }

    function startUpload($path,$iblocl_id,$property_image,$property_desc){
        $array = $this->getContent($path);
        $ids = $this->getIds($array);
        CModule::IncludeModule("iblock");
        foreach ($ids["IDS"] as $id){
           $PROP[$property_image] = $ids['IMAGES'][$id];
            $PROP[$property_desc] = $ids['DESC'][$id];
            CIBlockElement::SetPropertyValuesEx($id, $iblocl_id, $PROP);
        }
    }

}



AddEventHandler('form', 'onAfterResultAdd', Array("MyClass","onAfterResultAddHandler"));
class MyClass
{
    function onAfterResultAddHandler($WEB_FORM_ID, $RESULT_ID)
    {

        // действие обработчика распространяется только на форму с ID=7
        if ($WEB_FORM_ID == 7)
        {
            $arAnswer = CFormResult::GetDataByID($RESULT_ID,array("name","email","theme","text"), $arResult,$arAnswer2);
            $arAdress = array ("andkuchmin@yandex.ru");
            $adr = $arAnswer['theme']['0']['ANSWER_VALUE'];
            $adr_from = $arAnswer['email']['0']['USER_TEXT'];
            $name = $arAnswer['name']['0']['USER_TEXT'];
            $text = $arAnswer['text']['0']['USER_TEXT'];
            $theme = $arAnswer['theme']['0']['ANSWER_TEXT'];
            //Вытаскиваем из массива с результатами переменные
            $arSend = array("NAME" => $name, "TEXT" => $text,"E-MAIL" => $arAdress[$adr],
                "THEME" => $theme ,"REPLY_TO" => $adr_from);
            CEvent::Send('FEEDBACK',SITE_ID,$arSend);
            //Отправляем при помощи стандартной функции письмо по шаблону FEEDBACK
        }
    }
}
/*
AddEventHandler("main", "OnBuildGlobalMenu", "StartParser");
function StartParser(&$adminMenu, &$moduleMenu){
    $moduleMenu[] = array(
        "parent_menu" => "global_menu_services",
        "section" => "parser",
        "sort"        => 1,
        "url"         => "start_parser.php?lang=".LANG,
        "text"        => 'Данные с ABC-недвижимость',
        "title"       => 'Данные с ABC-недвижимость',
        "icon"        => "form_menu_icon",
        "page_icon"   => "form_page_icon",
        "items_id"    => "menu_parser",
        "items"       => array()
    );
}*/

AddEventHandler("main", "OnBuildGlobalMenu", "ObjectManager");
function ObjectManager(&$adminMenu, &$moduleMenu){
    $moduleMenu[] = array(
        "parent_menu" => "global_menu_services",
        "section" => "object.manager",
        "sort"        => 2,
        "url"         => "start_object_manager.php?lang=".LANG,
        "text"        => 'Управление каталогом ЖК',
        "title"       => 'Управление каталогом ЖК',
        "icon"        => "form_menu_icon",
        "page_icon"   => "form_page_icon",
        "items_id"    => "menu_parser",
        "items"       => array()
    );
}
// 404 страница для случая, когда элемент не найден
/*
AddEventHandler('main', 'OnEpilog', '_Check404Error', 1);
function _Check404Error()
{
   if (defined('ERROR_404') && ERROR_404=='Y' && !defined('ADMIN_SECTION'))
   {
      GLOBAL $APPLICATION;
      $APPLICATION->RestartBuffer();
      require $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.SITE_TEMPLATE_ID.'/header.php';
      require $_SERVER['DOCUMENT_ROOT'].'/404.php';
      require $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.SITE_TEMPLATE_ID.'/footer.php';
   }
}
*/
?>
<?
function pre($toPrint){
	global $USER;
	if (!$USER->IsAdmin()) return;
	echo'<pre>';
	print_r($toPrint);
	//var_dump($toPrint);
	echo'</pre>';
}
?>