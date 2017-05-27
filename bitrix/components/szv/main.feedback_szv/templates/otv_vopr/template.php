<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
$this->setFrameMode(true);
?><div>

<?
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?><div class="popup_text"><span class="inline_m"><?=$arResult["OK_MESSAGE"]?></span></div>
	<script>
        $('.hoverWait').fadeOut(500);
		$('.popup_text').fadeIn(500);
		setTimeout(function(){$('.closeElementPopUp').click();},4000);

	</script><?
}
?>
    <div class="closeElementPopUp"></div>
<form onsubmit="ga('send', 'event', 'Form', 'sendForm');"  action="<?=POST_FORM_ACTION_URI?>" class="mainForm alloka-catch-form" method="POST">
	<?=bitrix_sessid_post()?>
	<div class="popup_input_box">

<div class="popup_title"><? $res = CIBlockElement::GetByID(12489); if($ar_res = $res->GetNext()) echo $ar_res['PREVIEW_TEXT']; ?></div>
<div class="suggestion"><p><b></b></p>

<table style="margin-left: 43px;">
        <tr><td><br><input type="button" style="width: 200px" class="popup_send"  name="submit_popup" value="Заказать звонок" onclick="$('.otv_vopr_feedback').hide(); $('.footer_feedback').show();" /><br></td></tr>
        <tr><td><input type="button" style="width: 200px" class="popup_send" name="submit_popup" value="Задать вопрос онлайн" onclick="$('.lt-online').click();" /><br></td></tr>
        <tr><td><input type="button" style="width: 200px" class="popup_send showIt"  name="submit_popup" value="Сделать запрос" onclick="$('.otv_vopr_feedback').hide(); " data-who="zapros_feedback"/><br></td></tr>
</table>

</div>
<div class="desc_1"></div>

        <input type="hidden" name="back_url" value="<?=$APPLICATION -> GetCurPage();?>">
        <input type="hidden" name="reason" value="Возникли вопросы">
        <input type="hidden" name="gotcha" value="<?=$_SERVER["REMOTE_ADDR"];?>">
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="hidden" name="purposeMetr" value="" class="purposeMetr">
        <input type="hidden" name="calltouchId" value="" class="calltouchId">
        <table>
  	    <tr>
            <td>
                <div class="popup_send_box">
                </div>
            </td>
            </tr>
        </table>
        <div class="hoverWait" style="display: none;">Идет отправка</div>
	</div>
</form>
</div>