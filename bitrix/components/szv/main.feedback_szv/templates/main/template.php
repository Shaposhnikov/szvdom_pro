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
	?><div class="popup_text"><span class="inline_m"><?//=$arResult["PNN"];?><?=$arResult["OK_MESSAGE"]?></span></div>
	<script>
        $('.hoverWait').fadeOut(500);
		$('.popup_text').fadeIn(500);
		setTimeout(function(){$('.closeElementPopUp').click();},4000);

	</script><?
}

if (strstr($APPLICATION->GetCurPage(),'/vtorichnaja/') || !(strpos($APPLICATION->GetCurPage(),"/vtorichnaja/") === false) || (isset($GLOBALS['vtorichnaja'])))
{
$form_phone_example = "89213256863";
$form_phone = "+7(921) 325-68-63";
}
else
{
$form_phone_example = "88129025050";
$form_phone = "+7(812) 902-50-50";
}

?>
    <div class="closeElementPopUp"></div>
	<form onsubmit="ga('send', 'event', 'Form', 'sendForm'); "  action="<?=POST_FORM_ACTION_URI?>" class="mainForm alloka-catch-form" method="POST">
	<?=bitrix_sessid_post()?>
	<div class="popup_input_box">

<div class="popup_title">Хотите, мы перезвоним Вам в течении 59 секунд, и ответим на интересующие вопросы?</div>	
		<div class="suggestion" style="text-align: center">
<p><b>Задать вопрос специалисту</b></p>
			<span class="phone_form">+7(812) 902-50-50</span>
или
<p>заказать <b>обратный звонок:</b></p>
</div>
<div class="desc"></div>


        <input type="hidden" name="back_url" value="<?=$APPLICATION -> GetCurPage();?>">
        <input type="hidden" name="reason" value="Возникли вопросы">
        <input type="hidden" name="gotcha" value="<?=$_SERVER["REMOTE_ADDR"];?>">
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="hidden" name="purposeMetr" value="" class="purposeMetr">
        <input type="hidden" name="calltouchId" value="" class="calltouchId">
		<table style="width: 100%;">
            <tr>
            <td>
				<div class="popup_phone" style="width: 100%;">


					<input style="width: 198px; margin: auto; font-size:13px;" class="<?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][0]:""?> valid_number alloka-catch-form-input-phone" placeholder="Пример: <?php echo $form_phone_example; ?>" required maxlength="20" type="text" name="telefon" value="<?=$arResult["PHONE"]?>" />
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