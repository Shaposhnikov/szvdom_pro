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
<form onsubmit="ga('send', 'event', 'Form', 'sendForm'); yaglaaction('phone');"  action="<?=POST_FORM_ACTION_URI?>" method="POST" class="prcForm alloka-catch-form">
	<?=bitrix_sessid_post()?>
	<div class="popup_input_box" style="background:#276cb2;">

<div class="popup_title">Для расчета стоимости квартиры и размера скидки нам необходимо уточнить у Вас условие покупки : 100%, рассрочка, ипотека, первоначальный взнос и т.д</div>	
<div class="suggestion" style="text-align: center">
<p><b>Узнать стоимость со скидкой</b> Вы можете связавшись с отделом продаж:</p>
	<span class="phone_form">+7(812) 902-50-50</span>
или
<p>заказать <b>обратный звонок:</b></p></div><div class="desc"></div>


        <input type="hidden" name="back_url" value="<?=$APPLICATION -> GetCurPage();?>">
        <input type="hidden" name="reason" value="Узнать цену в планировках">
        <input type="hidden" name="gotcha" value="<?=$_SERVER["REMOTE_ADDR"];?>">
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="hidden" name="purposeMetr" value="" class="purposeMetr">
        <input type="hidden" name="calltouchId" value="" class="calltouchId">

		<table style="width: 100%;">
            <tr>
            <td>
				<div class="popup_phone" style="width: 100%;">
					<input style="width: 198px; margin: auto; font-size:13px;" class="<?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][0]:""?> valid_number valid_number_kp alloka-catch-form-input-phone" placeholder="Пример: 88129025050" required maxlength="20" type="text" name="PHONE" value="<?=$arResult["PHONE"]?>" />
                    <div class="popup_val"><?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][1]:""?></div>
                </div>
            </td>

			</tr>
			<tr>

            <td>
				<div class="popup_send_box" style="width: 100%; margin-left: 0;">
					<input style="width: 200px; margin: auto;" class="popup_send" onclick="$.ajax({ url: '/include/sendCallTouch.php', dataType: 'html', type: 'POST', data: $('.mainForm').serialize(), success: function(data) { } });" type="submit" name="submit_popup" value="<?=GetMessage("MFT_SMALL_SUBMIT")?>" />
                </div>
            </td>
            </tr>
        </table>

        <div class="hoverWait" style="display: none;">Идет отправка</div>
	</div>
</form>
</div>