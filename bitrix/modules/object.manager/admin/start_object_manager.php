<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);
$APPLICATION->SetTitle("Управление каталогом ЖК");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>
<style>
    #myFormObject div.itemEditObject{
        width: 100%;
        display: block;
        overflow: hidden;
    }
    #myFormObject div.itemEditObject ul{
        list-style-type: none;
        padding: 0;
        margin: 0;
        overflow: hidden;
        border: 1px solid;
        width: 50%;
    }
    #myFormObject div.itemEditObject ul li{
        display: block;
        width: 47.183%;
        padding: 10px;
        float: left;
        border-right: 1px solid ;
        line-height: 30px;
        overflow: hidden;
    }
    #myFormObject div.itemEditObject ul li span{
        display: block;
        width: 40%;
        float: left;
    }
    #myFormObject div.itemEditObject ul li p{
        padding: 0;
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }
</style>
<?
$xml->xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml");
$Blocks = $xml->xml->xpath("/Ads/Blocks/Block");
$xml_array = unserialize(serialize(json_decode(json_encode((array) $Blocks), 1)));
foreach ($xml_array as $element){
    $blockAll[] = $element['@attributes'];
}

if (isset($_POST["complex"])){
    @set_time_limit(0);
    @ignore_user_abort(true);
    $sect = new objectsParser;
    if ($_POST["full"] == "Y"){
        $res = $sect->updateObjektsFull($_POST["complex"]);
    }else{
        $res = $sect->updatePrice($_POST["complex"]);
    }
    if($res === false){
        $arErrors[] = GetMessage("NOT_UPDATE");
    }else{
        $arMessage[] = GetMessage("DONE_UPDATE");
    }
}
foreach($arErrors as $strError)
    CAdminMessage::ShowMessage($strError);
foreach($arMessage as $strMessage)
    CAdminMessage::ShowMessage(array("MESSAGE"=>$strMessage,"TYPE"=>"OK"));
?>

    <?= bitrix_sessid_post()?>
    <?
    $aTabs = array(
        array("DIV" => "show_ids", "TAB" => "ID объектов", "ICON" => "fileman", "TITLE" => "Все ID ЖК из каталога"),
        array("DIV" => "csv_get", "TAB" => "Генерация CSV", "ICON" => "fileman", "TITLE" => "Генерация CSV")
    );

    $tabControl = new CAdminTabControl("tabControl", $aTabs);
    $tabControl->Begin();
    ?>
    <?$tabControl->BeginNextTab();?>
    <form method="POST" action="" name="myFormObject" id="myFormObject" >
        <input name="full" id="full" type="hidden" value="N">
        <?
        foreach ($blockAll as $block){?>
            <span><input name="complex" type="radio" value="<?=$block["id"];?>"><?=$block["title"];?>(XML_ID = <?=$block["id"];?>)</span>
            <br/>
        <?}?>
        <br/>

        <input type="button" onClick="document.getElementById('full').value = 'N';document.myFormObject.submit();" value="Обновить цены ЖК"/>
        <input style="margin-left: 15px;" type="button" onClick="document.getElementById('full').value = 'Y';document.myFormObject.submit();" value="Обновить полностью ЖК"/>
    </form>
    <?$tabControl->EndTab();?>
    <?$tabControl->BeginNextTab();?>
    <form method="POST" action="/include/managerStart.php" name="myFormObject2" id="myFormObject2" >
        <p>Полученный файл будет храниться в папке корень_сайта/csvExport/, с текущим временем</p>
        <?foreach ($blockAll as $block){?>
            <span><input name="complex" type="radio" value="<?=$block["id"];?>"><?=$block["title"];?>(XML_ID = <?=$block["id"];?>)</span>
            <br/>
        <?}?>
        <br/>
        <input type="button" onClick="document.myFormObject2.submit();" value="Генерировать CSV"/>
    </form>
    <?$tabControl->EndTab();?>
    <?$tabControl->End();?>




<?
require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>
