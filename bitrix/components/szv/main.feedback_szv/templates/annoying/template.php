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
    if (strlen($arResult["OK_MESSAGE"]) > 0) {
        ?>
        <div class="popup_text"><span class="inline_m"><?= $arResult["OK_MESSAGE"] ?></span></div>
        <script>
            $('.hoverWait').fadeOut(500);
            $('.popup_text').fadeIn(500);
            setTimeout(function () {
                $('.close_graber_popup').click();
            }, 4000);
        </script><?
    }
    ?>
    <script>
        $(document).ready(function(){
            $('.close_graber_popup').click(function () {
                $('.feedbackWrap').fadeOut(500);
                $('.popUpWindowOverlay').fadeOut(500);
            });
        });
    </script>

    <form onsubmit="ga('send', 'event', 'Form', 'sendForm');"  action="<?= POST_FORM_ACTION_URI ?>" class="annoForm alloka-catch-form" method="POST">
        <?= bitrix_sessid_post() ?>
        <div class="popup_input_box">

            <div class="graber_popup">
                <div class="graber_description">
                    <h3>Не нашли то что искали?</h3>

                    <p>Оставьте свой номер, мы обязательно вам перезвоним и <br>поможем с покупкой недвижимости!</p>
                </div>
                <div class="graber_form">

                    <input type="hidden" name="back_url" value="<?= $APPLICATION->GetCurPage(); ?>">
                    <input type="hidden" name="reason" value="Форма main">
                    <input type="hidden" name="PARAMS_HASH" value="<?= $arResult["PARAMS_HASH"] ?>">
                    <input type="hidden" name="gotcha" value="<?=$_SERVER["REMOTE_ADDR"];?>">
                    <div style="display:none;" class="purposeMetr" data-purpose="empty"></div>
                    <input type="hidden" name="purposeMetr" value="" class="purposeMetr">
                    <input type="hidden" name="calltouchId" value="" class="calltouchId">

                    <div class="phone_box inline"><p><b>Номер телефона:</b></p>
                        <input class="graber_phone <?=isset($arResult["ERROR_CLASS"]["PHONE"])?$arResult["ERROR_CLASS"]["PHONE"][0]:""?> alloka-catch-form-input-phone"  name="PHONE" value="<?=$arResult["PHONE"]?>" onfocus="$(this).inputmask('+7 (999) 999 99 99',{showMaskOnHover:false});" type="text" placeholder="+7 (___) ___-__-__">
                    </div>
                    <div class="send_box">
                        <div class="graber_send inline">
                            <div class="graber_send_radius">
                                <div class="graber_send_text">
                                    <input  type="submit" name="submit_popup" onclick="yaCounter21785827.reachGoal($('.mainForm .purposeMetr').val());$('.hoverWait').css('display','block');$.ajax({ url: '/include/sendCallTouch.php', dataType: 'html', type: 'POST', data: $('.annoForm').serialize(), success: function(data) { } });" value="Жду звонка"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="close_graber_popup">Спасибо, я всё нашёл(а)</div>
            </div>

            <div class="hoverWait" style="display: none;">Идет отправка</div>
        </div>
    </form>
</div>