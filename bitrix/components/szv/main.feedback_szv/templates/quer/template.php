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
		$('.popup_text').fadeIn(500);
		setTimeout(function(){$('.close_popup_small').click();},4000);
	</script><?
}
?>
    <div class="closeElementPopUp"></div>
<form onsubmit="ga('send', 'event', 'Form', 'sendForm');"  action="<?=POST_FORM_ACTION_URI?>" method="POST" class="alloka-catch-form">
	<?=bitrix_sessid_post()?>
	<div class="popup_input_box">

<div class="popup_title">Получить информацию о способах покупки, рассчитать рассрочку, а также уточнить стоимость с учетом действующих акций Вы можете связавшись с нами.</div>	
		<div class="suggestion"><p><b>Уточнить подробную информациию</b> Вы можете связавшись со специалистом: </p><span class="callibri_phone phone_form" style="text-align: center;">+7(812) 902-50-50</span><p>или</p></div>
		<div class="desc_1"><p style="color: #fff;">заказать обратный звонок:</p></div>


        <input type="hidden" name="back_url" value="<?=$APPLICATION -> GetCurPage();?>">
        <input type="hidden" name="reason" value="Как купить">
        <input type="hidden" name="gotcha" value="<?=$_SERVER["REMOTE_ADDR"];?>">
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input type="hidden" name="calltouchId" value="" class="calltouchId">
        <div style="display:none;" class="purposeMetr" data-purpose="empty"></div>
		<table style="margin: auto;">
            <tr>
            <td>
				<div class="popup_phone" style="float: none; margin: auto; width: 200px;">
                    <input style="width: 198px; font-size:13px;" class="<?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][0]:""?> alloka-catch-form-input-phone" onfocus="$(this).inputmask('+7 (999) 999 99 99',{showMaskOnHover:false});" type="text" name="PHONE" value="<?=$arResult["PHONE"]?>" placeholder="+7 (___) ___-__-__" />
                    <div class="popup_val"><?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][1]:""?></div>
                </div>
            </td>

				</tr>
				<tr>

            <td>
				<div class="popup_send_box" style="float: none; margin: auto; width: 200px; margin-bottom: 15px;">
                    <input style="width: 200px" class="popup_send" type="submit" name="submit_popup" value="<?=GetMessage("MFT_SMALL_SUBMIT")?>" />
                </div>
            </td>
            </tr>
        </table>
	</div>
</form>
</div>