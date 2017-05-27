<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);
$APPLICATION->SetTitle("Данные с ABC-недвижимость");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");?>
<form method="POST" action="/include/parser.php" name="myForm" >
    <input name="back" type="hidden" value="/bitrix/admin/">
    <?= bitrix_sessid_post()?>
    <?
    $aTabs = array(
        array("DIV" => "show_ids", "TAB" => "ID объектов", "ICON" => "fileman", "TITLE" => "Вывод ID объектов"),
        array("DIV" => "parser_start_page", "TAB" => "Запуск parser'а", "ICON" => "fileman", "TITLE" => "Ручной запуск parser для xml"),
    );

    $tabControl = new CAdminTabControl("tabControl", $aTabs);
    $tabControl->Begin();
    ?>
    <?$tabControl->BeginNextTab();?>
    <?
    $xml->xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml");
    $Blocks = $xml->xml->xpath("/Ads/Blocks/Block");?>
    <ul style="list-style-type: none">
        <li>
            <ul style="list-style-type: none;overflow: hidden;">
                <li   style="border: 1px solid;line-height: 30px;height: 30px;text-align: center;width: 40%;float: left;">
                    <b>Название жилого комплекса</b>
                </li>
                <li  style="border: 1px solid;line-height: 30px;height: 30px;text-align: center;width: 40%;float: left;">
                    <b>ID жилого комплекса в XML</b>
                </li>
            </ul>
        </li
    <?foreach ($Blocks as $value){?>
        <li>
            <ul style="list-style-type: none;overflow: hidden;">
                <li   style="border: 1px solid;line-height: 30px;height: 30px;text-align: center;width: 40%;float: left;">
                    <?= (string)$value['title'];?>
                </li>
                <li  style="border: 1px solid;line-height: 30px;height: 30px;text-align: center;width: 40%;float: left;">
                    <?= (string)$value['id'];?>
                </li>
            </ul>
        </li
    <?}?>
    </ul>

    <?
    $tabControl->EndTab();?>

    <?$tabControl->BeginNextTab();?>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td colSpan="2" class="adm-detail-content-cell-r">
                        Данная страница позволяет обновить данные базы в соответствии с текущей версией файла, предоставленного "ABC-недвижимость".
                        <br/>
                        Путь к файлу: корень_сайта/include/xml/SiteData.xml
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <input class="mybutton" type="button" name="start_parser_form" value="Запустить" onClick="document.myForm.submit();"/>
    <?
    $tabControl->EndTab();?>
    <?$tabControl->End();?>
</form>



<?require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>
