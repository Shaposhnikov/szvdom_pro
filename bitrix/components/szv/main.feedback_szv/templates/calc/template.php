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
<form action="<?=POST_FORM_ACTION_URI?>" onsubmit="ga('send', 'event', 'Form', 'sendForm');"  method="POST" class="calcItForm alloka-catch-form">
	<?=bitrix_sessid_post()?>
	<div class="popup_input_box" style="background:#E5F3FF;">
	
<div class="popup_title">Расчет и одобрение ипотечного кредита зависит от множества факторов, таких как: условия ипотечной программы, возраст<br/> заемщика, платежеспособность, наличие других кредитов и т.д.</div>	
<div class="suggestion"><p><b>Узнать подробную информацию</b> Вы можете связавшись со специалистом: </p><span class="callibri_phone phone_form">+7(812) 902-50-50</span><p>или</p></div>
<div class="desc_1"><p>заказать <b>обратный звонок:</b></p></div>
		
	
        <input type="hidden" name="back_url" value="<?=$APPLICATION -> GetCurPage();?>">
        <input type="hidden" name="reason" value="Рассчитать ипотеку">
        <input type="hidden" name="gotcha" value="<?=$_SERVER["REMOTE_ADDR"];?>">
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="hidden" name="purposeMetr" value="" class="purposeMetr">
        <input type="hidden" name="calltouchId" value="" class="calltouchId">
        <table>
            <tr>
            <td>
                <div class="popup_phone">
                    <input style="width: 215px; font-size:13px;" class="<?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][0]:""?> alloka-catch-form-input-phone" onfocus="$(this).inputmask('+7 (999) 999 99 99',{showMaskOnHover:false});" type="text" name="PHONE" value="<?=$arResult["PHONE"]?>" placeholder="+7 (___) ___-__-__" />
                    <div class="popup_val"><?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][1]:""?></div>
                </div>
            </td>
            <td>

              
            </td>
            <td>
                <div class="popup_send_box">
                    <input style="width: 200px" class="popup_send" onclick="yaCounter21785827.reachGoal($('.mainForm .purposeMetr').val());$('.hoverWait').css('display','block');$.ajax({ url: '/include/sendCallTouch.php', dataType: 'html', type: 'POST', data: $('.calcItForm').serialize(), success: function(data) { } });" type="submit" name="submit_popup" value="<?=GetMessage("MFT_SMALL_SUBMIT")?>" />
                </div>
            </td>
            </tr>
        </table>
        <div class="hoverWait" style="display: none;">Идет отправка</div>
	</div>
</form>
</div>