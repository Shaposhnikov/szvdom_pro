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
?>
<div>

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

		<div class="popup_title">В нашей базе более 60 000 квартир и мы сможем подобрать именно ту, которая нужна Вам.<?// $res = CIBlockElement::GetByID(12488); if($ar_res = $res->GetNext()) echo $ar_res['PREVIEW_TEXT']; ?></div>
		<div class="suggestion"><p><span>Записаться на выходной</span></p>

<table style="margin-left: 0;">
	<tr><td><input type="text" name="kogda_perezvonit" placeholder="Дата записи" required></td></tr>
	<tr><td><input type="text" class="familiya_imya_zv" name="familiya_imya" placeholder="Ваше имя" required></td></tr>
	<tr><td><input type="text" class="telefon_zv alloka-catch-form-input-phone" name="telefon" placeholder="Ваш телефон" required></td></tr>
</table>

<script>
$(document).ready(function(){

	$.datetimepicker.setLocale('ru');

	$('input[name=kogda_perezvonit]').datetimepicker({
	 format:'d.m.Y H:i'
	});
});
</script>

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
                    <input style="width: 200px" class="popup_send" onclick="Comagic.addOfflineRequest({name: $('.mainForm .familiya_imya_zv').val(), phone: $('.mainForm .telefon_zv').val()}); yaCounter21785827.reachGoal($('.mainForm .purposeMetr').val());$.ajax({ url: '/include/sendCallTouch.php', dataType: 'html', type: 'POST', data: $('.mainForm').serialize(), success: function(data) { } });" type="submit" name="submit_popup" value="Отправить" />
                </div>
            </td>
            </tr>
        </table>
        <div class="hoverWait" style="display: none;">Идет отправка</div>
	</div>
</form>
</div>
