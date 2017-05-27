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
	<div class="popup_input_box" style="background:#E5F3FF;">
	
<div class="popup_title">Вы можете записаться на консультацию к специалисту в выходной день, в удобное для Вас время</div>	
<div class="suggestion"><p><b>Записаться на консультацию</b></p><h5 class="callibri_phone"><span>+7(812) 907-15-15</span></h5><p>или</p></div>
<div class="desc_1"><p>заказать <b>обратный звонок:</b></p></div>
		

        <input type="hidden" name="back_url" value="<?=$APPLICATION -> GetCurPage();?>">
        <input type="hidden" name="reason" value="Возникли вопросы">
        <input type="hidden" name="gotcha" value="<?=$_SERVER["REMOTE_ADDR"];?>">
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="hidden" name="purposeMetr" value="skidki" class="purposeMetr">
        <input type="hidden" name="calltouchId" value="" class="calltouchId">
        <table>
            <tr>
            <td>
                <div class="popup_phone">
                    <input style="width: 215px; font-size:13px;" class="<?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][0]:""?> valid_number alloka-catch-form-input-phone" placeholder="Пример: 88129025050" required maxlength="20" type="text" name="PHONE" value="<?=$arResult["PHONE"]?>" />
                    <div class="popup_val"><?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][1]:""?></div>
                </div>
            </td>
            <td>

              
            </td>
            <td>
                <div class="popup_send_box">
                    <input style="width: 200px" class="popup_send" onclick="yaCounter21785827.reachGoal($('.mainForm .purposeMetr').val());$('.hoverWait').css('display','block');$.ajax({ url: '/include/sendCallTouch.php', dataType: 'html', type: 'POST', data: $('.mainForm').serialize(), success: function(data) { } });" type="submit" name="submit_popup" value="<?=GetMessage("MFT_SMALL_SUBMIT")?>" />
                </div>
            </td>
            </tr>
        </table>
        <div class="hoverWait" style="display: none;">Идет отправка</div>
	</div>
</form>
</div>