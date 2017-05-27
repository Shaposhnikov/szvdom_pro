<?php

global $USER;
/**
 * void object2file - функция записи объекта в файл
 *
 * @param mixed value - объект, массив и т.д.
 * @param string filename - имя файла куда будет произведена запись данных
 * @return void
 *
 */
function object2file($value, $filename)
{
    $str_value = serialize($value);

    $f = fopen($filename, 'w');
    fwrite($f, $str_value);
    fclose($f);
}


/**
 * mixed object_from_file - функция восстановления данных объекта из файла
 *
 * @param string filename - имя файла откуда будет производиться восстановление данных
 * @return mixed
 *
 */
function object_from_file($filename)
{
    $file = file_get_contents($filename);
    $value = unserialize($file);
    return $value;
}


class ayersParser
{

    private $xml;
    private $time_start;

    public function __construct()
    {

        $this->xml = simplexml_load_file("http://szv.ayers.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
        $this->time_start = microtime(true);

    }




    function getObjects(){
        if (CModule::IncludeModule("iblock")) {
            /*
             * Выбираем все секции, которые нам нужны
             * */
            $sections = object_from_file('http://szv.ayers.ru/objects.config');
            /*
             * Выбираем все секции, которые уже есть
             * */
            echo "<pre>";
            var_dump($sections);
            echo "</pre>";
            $nowHave = array();
            $arBlockSect = array();
            $arSelect = Array("ID", "NAME", "UF_SECOND_ID","UF_UPDATE_SECTION");
            $arFilter = Array("IBLOCK_ID"=>7, "ACTIVE"=>"Y");
            $res = CIBlockSection::GetList(Array(), $arFilter, true, $arSelect,false);
            while($ob = $res->Fetch())
            {
                $nowHave[] = $ob["UF_SECOND_ID"];
                $arBlockSect[$ob["UF_SECOND_ID"]] = $ob;
            }
            /*
             * Проводим нужные нам операции (update или insert)
             * */
            foreach ($sections as $key => $section) {
                $arSection = $this->getSectionWithElements($section);
                if (in_array($section,$nowHave)){
                    if (!empty($arBlockSect[$section]["UF_UPDATE_SECTION"])){
                        /*
                         * Выполняем апдейт только в случае выставленной галочки в св-вах
                         * */
                        $this -> updateObject($arSection);
                    }
                }else{
                    /*
                     * Проводим оперцию загрузки новой секции со всеми квартирами
                     * */
                    $this -> insertObject($arSection);
                }
            }
        }
    }


    function getSectionWithElements($section){
        $blockXml = $this->xml->xpath("/Ads/Blocks/Block[@id='" . $section. "']");
        $addSection = array();
        $region = $this->xml->xpath("/Ads/Regions/Region[@id='" . $blockXml[0]["region"]. "']");
        $rLine = $this->xml->xpath("/Ads/Buildings/Building[@blockid='".$blockXml[0]["id"]."']");
        $line = array();
        foreach ($rLine as $value){
            $line[] =  (string)$value['line'];
        }
        $lines = array_unique($line);
        $subwayBlock = $this->xml->xpath("/Ads/BlockSubways/BlockSubway[@blockid='" . $blockXml[0]["id"]. "']");
        $subway = array();
        foreach ($subwayBlock as $sub) {
            $subways = $this->xml->xpath("/Ads/Subways/Subway[@id='" . $sub["subwayid"]. "']");
            $subway[] =  (string)$subways[0]['name'];
        }
        $banks = $this->xml->xpath("/Ads/Mortgages/Mortgage[@blockid='" . $blockXml[0]["id"] . "']");
        $bank = array();
        foreach ($banks as $value){
            $ban = $this->xml->xpath("/Ads/Banks/Bank[@id='" . $value["bankid"]. "']");
            $bank[] =  (string)$ban[0]['name'];
        }
        $builder = $this->xml->xpath("/Ads/Builders/Builder[@id='" . (string)$blockXml[0]['builderid'] . "']");

        $apartments = $this->xml->xpath("/Ads/Apartments/Apartment[@blockid='" . $blockXml[0]["id"]. "']");
        $objects = array();
        $property_enums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => 7, "CODE" => "ELEMENT_XML_UPDATE"));
        while ($enum_fields = $property_enums->GetNext()) {
            if (strtolower($enum_fields["VALUE"]) == "да"){
                $elementFromXMLYes = $enum_fields["ID"];
            }
        }
        foreach ($apartments as $apartment){
            $xml_array = unserialize(serialize(json_decode(json_encode((array) $apartment), 1)));
            $gg = $xml_array['@attributes'];
            $objects[] = array(
                113 => $gg["id"],
                114 => $gg["buildingid"],
                115 => $gg["section"],
                116 => $gg["rooms"],
                117 => $gg["stotal"],
                118 => $gg["sroom"],
                119 => $gg["skitchen"],
                120 => $gg["sbalcony"],
                121 => $gg["scorridor"],
                122 => $gg["swatercloset"],
                123 => $gg["height"],
                124 => $gg["decoration"],
                125 => $gg["subsidy"],
                126 => $gg["flatcostwithdiscounts"],
                127 => $gg["baseflatcost"],
                128 => $gg["flatfloor"],
                129 => $gg["flatplan"],
                130 => $elementFromXMLYes
            );
        }
        $rsUField = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME" => "UF_UPDATE_SECTION"));
        while ($arUField = $rsUField->GetNext()) {
            if (strtolower($arUField["VALUE"]) == "да"){
                $yesForSect = $arUField["ID"];
        }
        }
        $addSection["FLAT"] = $objects;
        $addSection["ARRAY_FIELD"] = Array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => 7,
            "NAME" => (string)$blockXml[0]["title"],
            "SORT" => 500,
            "UF_SECOND_ID" => (string)$blockXml[0]["id"],
            "UF_REGION" => (string)$region[0]["name"],
            "UF_ADDRESS" => (string)$blockXml[0]["address"],
            "UF_LONGITUDE" => (string)$blockXml[0]["longitude"],
            "UF_LATITUDE" => (string)$blockXml[0]["latitude"],
            "UF_SUBWAYS" => $subway,
            "UF_BUILDER" =>(string)$builder[0]['name'],
            "UF_BANKS" => $bank,
            "UF_LINE" => $lines,
            "UF_UPDATE_SECTION" => $yesForSect
        );
        return $addSection;
    }


    function insertObject($element){
        $buf = new CIBlockSection;
        $ID = $buf->Add($element["ARRAY_FIELD"]);
        $res = ($ID>0);
        if(!$res)
            echo $buf->LAST_ERROR;
        /*foreach ($element["FLAT"] as $apartam) {
            $el = new CIBlockElement;
            $arLoadProductArray = Array(
                "IBLOCK_SECTION_ID" => $ID,
                "IBLOCK_ID"      => 7,
                "PROPERTY_VALUES"=> $apartam,
                "NAME"           => "Квартира ID_".$apartam[113],
                "ACTIVE"         => "Y"
            );
            $PRODUCT_ID = $el->Add($arLoadProductArray);
            $resEl = ($PRODUCT_ID>0);
            if(!$resEl)
                echo $el->LAST_ERROR;
        }*/
    }


    function updateObject($element){
        /*
         * Получаем секцию по имени
         * */
        $arFilter = array('IBLOCK_ID' => 7, 'NAME' => $element["ARRAY_FIELD"]["NAME"]);
        $rsSections = CIBlockSection::GetList(array(), $arFilter,false,array("ID","NAME","IBLOCK_ID"));
        while ($arSction = $rsSections->Fetch())
        {
            $thisSection = $arSction["ID"];
        }
        /*
         * Находим все элементы и обновляем их
         * */
        $arSelect = Array("ID", "NAME", "PROPERTY_ELEMENT_XML_UPDATE");
        $arFilter = Array("IBLOCK_ID"=>7,"ACTIVE"=>"Y","SECTION_ID" => $thisSection);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while($ob = $res->Fetch())
        {
            $buf = explode('_',$ob["NAME"]);
            if ($ob['PROPERTY_ELEMENT_XML_UPDATE_VALUE'] == 'да'){
                foreach ($element["FLAT"] as $flat) {
                    if ($flat[113] == $buf[1]){
                        /*
                         *  Обновляем элемент
                         * */

                        $el = new CIBlockElement;
                        $arLoadProductArray = Array(
                            "IBLOCK_SECTION_ID" => $thisSection,
                            "IBLOCK_ID"      => 7,
                            "PROPERTY_VALUES"=> $flat,
                            "NAME"           => "Квартира ID_".$flat[113],
                            "ACTIVE"         => "Y"
                        );
                        $el->Update($ob["ID"],$arLoadProductArray);
                    }
                }

            }
        }


        /*
         * Обновим саму секцию
         * */
        $bs = new CIBlockSection;
        $bs->Update($thisSection, $element["ARRAY_FIELD"]);

    }


}

?>