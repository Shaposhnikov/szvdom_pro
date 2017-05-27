<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("feedback");?><div class="price_plan_feedback feedbackWrap" style="margin-top: -220px;">
    <div class="feedbackBody">
        <? $APPLICATION->IncludeComponent(
    "szv:main.feedback_szv", 
    "price_plan", 
    array(
        "USE_CAPTCHA" => "N",
        "OK_TEXT" => "Спасибо, ваше сообщение принято.",
        "EMAIL_TO" => "sendmail@szvdom.ru",
        "REQUIRED_FIELDS" => array(
            0 => "PHONE",
        ),
        "EVENT_MESSAGE_ID" => array(
            0 => "9",
        ),
        "AJAX_MODE" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "COMPONENT_TEMPLATE" => "price_plan",
        "AJAX_OPTION_ADDITIONAL" => "undefined",
        "CATEGORY_TO" => ""
    ),
    false
); ?>
    </div>
</div>

<div class="footer_feedback feedbackWrap">
    <div class="feedbackBody">
        <? $APPLICATION->IncludeComponent(
	"szv:main.feedback_szv", 
	"main", 
	array(
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "sendmail@szvdom.ru",
		"REQUIRED_FIELDS" => array(
			0 => "PHONE",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "9",
		),
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "main",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CATEGORY_TO" => ""
	),
	false
); ?>
    </div>
</div>

<div class="podbor_feedback feedbackWrap">
    <div class="feedbackBody">
        <? $APPLICATION->IncludeComponent(
        "szv:main.feedback_szv",
        "podbor", // Подбор квартиры, новый шаблон
        array(
                "USE_CAPTCHA" => "N",
                "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                "EMAIL_TO" => "sendmail@szvdom.ru",
                "REQUIRED_FIELDS" => array(
                        0 => "familiya_imya",
                        1 => "telefon",
                        2 => "kogda_perezvonit",
                ),
                "EVENT_MESSAGE_ID" => array(
                        0 => "22",
                ),
                "AJAX_MODE" => "Y",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "COMPONENT_TEMPLATE" => "main",
                "AJAX_OPTION_ADDITIONAL" => "undefined",
                "CATEGORY_TO" => ""
        ),
        false
); ?>
    </div>
</div>

<div class="zapros_feedback feedbackWrap">
    <div class="feedbackBody">
        <? $APPLICATION->IncludeComponent(
	"szv:main.feedback_szv", 
	"zapros", 
	array(
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "sendmail@szvdom.ru",
		"REQUIRED_FIELDS" => array(
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "24",
		),
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "main",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CATEGORY_TO" => ""
	),
	false
); ?>
    </div>
</div>

<div class="skidki_feedback feedbackWrap">
    <div class="feedbackBody">
        <? $APPLICATION->IncludeComponent(
            "szv:main.feedback_szv",
            "zapis_na_vihodnoy",
            array(
                "USE_CAPTCHA" => "N",
                "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                "EMAIL_TO" => "sendmail@szvdom.ru",
                "REQUIRED_FIELDS" => array(
                    0 => "familiya_imya",
                    1 => "telefon",
                ),
                "EVENT_MESSAGE_ID" => array(
                    0 => "23",
                ),
                "AJAX_MODE" => "Y",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "COMPONENT_TEMPLATE" => "main",
                "AJAX_OPTION_ADDITIONAL" => "undefined",
                "CATEGORY_TO" => ""
            ),
            false
        ); ?>
    </div>
</div>
<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("feedback", "");?>
<div class="otv_vopr_feedback" style="display: none; position: fixed; bottom: 80px; right: 440px; z-index: 99999; width: 310px !important;">
    <div class="feedbackBody">
        <div class="closeElementPopUp"></div>
        <div class="popup_input_box">
            <div class="popup_title">В нашей базе более 100 000 квартир и мы сможем подобрать именно ту, которая нужна Вам.</div>
            <div class="suggestion">
                <table style="margin-left: 50px;">
                    <tbody>
                        <tr><!-- class="showIt"   and JS:  $('.otv_vopr_feedback').hide(); $('.footer_feedback').show();" data-who="footer_feedback" -->
                        <td><br><input type="button" style="width: 200px" class="popup_send" name="submit_popup" value="Заказать звонок" onclick="$('.lt-xbutton').click();"><br></td>
                    </tr>
                    <tr>
                        <td><input type="button" style="width: 200px" class="popup_send" name="submit_popup" value="Задать вопрос онлайн" onclick="$('.lt-offline').click(); $('.lt-online').click();"><br></td>
                    </tr>
                    <tr>
                        <td><input type="button" style="width: 200px" class="popup_send showIt" name="submit_popup" value="Сделать запрос" onclick="$('.otv_vopr_feedback').hide();" data-who="zapros_feedback"><br></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="footer">

    <? if (strstr($APPLICATION->GetCurPage(),'/obekty/') || (strpos($APPLICATION->GetCurPage(),'/obekty/') === false) && (strpos($APPLICATION->GetCurPage(),'/vyborki/') === false) && (strpos($APPLICATION->GetCurPage(),'/akcii-i-skidki/') === false) ){?>
        <div class="howWeWorkAndFriendTip">
<!--noindex-->
<div class="how_text"><p class="text_up">Схема работы</p>

<? if (strstr($APPLICATION->GetCurPage(),'/vtorichnaja/')){?>

<p id="toggleWork" class="showUP" style="width: 91px;">развернуть<i class="bottom"></i></p></div>

<? } else { ?>
            <p id="toggleWork">свернуть<i class=""></i></p></div>

<? } ?>

            <? if (strstr($APPLICATION->GetCurPage(),'/vtorichnaja/')){?>


<? if (strstr($APPLICATION->GetCurPage(),'/vtorichnaja/')){?>
                <div class="how_table" style="display: none">
<? } else { ?>
<div class="how_table">
<? } ?>
                <div class="block">
                <?$APPLICATION->IncludeFile('/vtorichnaja/howWeWork.php', Array(), Array("MODE"=> "php","NAME"=> "Редактирование включаемой области раздела"));$dbl='none';?>
                <?} else { $dbl='block';?>

                <div class="how_table old">
                    <div class="block old">
<div class="wschema">
<ol class="rectangle-list"> 
	<li><i>Вы оставляете заявку на сайте или связываетесь с нами по телефону &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></li>
	<li><i>В течении 5 минут наш специалист связывается с Вами &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></li>
	<li><i>Вместе с Вами мы подбираем варианты подходящих Вам квартир по заданным параметрам</i></li>
	<li><i>При необходимости наш специалист организует для Вас посещение строительной площадки, выбранной квартиры или шоу-рума</i></li>
<li><i>На встрече в нашем офисе Вы сможете оперативно сравнить подобранные для Вас варианты квартир и способы их оплаты, ознакомиться со всей технической и юридической документацией по объектам, получить ответы на все имеющиеся у Вас вопросы</i></li>
	<li><i>Если Вам необходимо наш ипотечный специалист подберет для Вас оптимальную ипотечную программу от банков партнёров или рассчитает</i></li>
<li><i>Прямо из офиса нашей компании мы сможем забронировать понравившиеся Вам квартиры и направить документы в банк для получения Вами ипотечного кредита</i></li>
	<li><i>В сопровождении опытного специалиста нашей компании в офисе застройщика Вы подписываете договор на приобретение квартиры</i></li>
	<li><i>По Вашей просьбе мы поможем “принять Вам квартиру” у Застройщика и зарегистрировать право собственности на нее &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></li>
	</ol>
</div>
            <?}?>

                    </div>               
                </div>

            <div style="display:<?=$dbl?>;" class="how_text"><p class="text_down">Наши услуги для Вас абсолютно бесплатны!</p> <a data-who="footer_feedback" onclick="yaCounter21785827.reachGoal('how_work_click'); return true;" data-formsend="how_work_send"  class="buttonGreen showIt">Оставить заявку</a>

                <div class="clear"></div>
            </div>
	</div><!--/noindex-->
    <?} ?>
<? Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("list");?>
<!-- edited by coder 28.04.2016 -->
	<?$APPLICATION->IncludeFile('/vtorichnaja/our_services.php', Array(), Array("MODE"=> "php","NAME"=> "Редактирование включаемой области раздела"));$dbl='none';?>
<!-- end of edit -->
<? Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("list", "");?>
 <?

if ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "zachet-zhilja/" || $APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "ipoteka/" || $APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "/vtorichnaja/"){
        ?>

<!-- edited by coder 28.04.2016 -->
<div class="whatAreQuestion" style="background-color:#ffffff;">
    <p class="whatAreQuestionText">
        <?

        if ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "zachet-zhilja/"){
        ?>
        <span class="watqtBig">Возникли вопросы?  Позвоните!</span>
        <br/>
        <span class="watqtLittle">Бесплатная консультация по оценке и зачету жилья.
        <br/>
            <? }elseif ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "ipoteka/") { ?>
            <span class="watqtBig">Возникли вопросы?  Позвоните!</span>
        <br/>
        <span class="watqtLittle">Бесплатная консультация по вопросам ипотеки по телефону
        <br/>

            <? }else{
            ?>
            <span class="watqtBig">Возникли вопросы? Позвоните!</span>
        <br/>
        <span class="watqtLittle">Бесплатная консультация и подбор жилья по телефону
        <br/>
            <? } ?>


            <span class="ya-elama-phone call_phone_1">+7(921) 325-68-63</span> <a data-who="footer_feedback" onclick="yaCounter21785827.reachGoal('question_click'); return true;" data-formsend="question_send" class="showIt">оставить заявку</a></span>
    </p>

	<div class="QW_block_ph point_border showIt" onclick="yaCounter21785827.reachGoal('question_click'); return true;" data-formsend="question_send" data-who="footer_feedback" ></div>
	<div data-who="footer_feedback" class="showIt" style="background: url('/bitrix/templates/szvdom/images/contact_us4.png')no-repeat; cursor:pointer; width: 100px;height: 100px;position: absolute;display: inline-block;right: 26px;top: 40px;"></div>

</div>
<? } ?>
<div style="clear: both;"></div>
<!-- end of edit -->

<?
// До


if (!(strpos($APPLICATION->GetCurPage(),"/vtorichnaja/") === false) || (isset($GLOBALS['vtorichnaja'])))
	$viborka_id = 79;
else
	$viborka_id = 80;
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"viborki",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "vyborki",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "5",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "3000",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PROPERTY_CODE" => array("SELECT_GROUPS",""),
		"SECTION_CODE" => "",
		"SECTION_ID" => $viborka_id,
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array("",""),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N"
	)
);?>


    <div class="blueSection">
        <div class="threeColumns">
            <div class="firstColumn">
                <div class="icon"></div>
                <div class="firstColumnInner">
                    <div class="boldTitle">
                        Позвоните по телефону
                    </div>
                    <div class="regularText">
                        Для получения актуальной информации о наличии и стоимости интересующих объектов обращайтесь по телефону:
                    </div>
                    <br/>

                    <div class="firstColumnBottom">
						<a href="tel:+7(812)902-50-50" style="text-decoration:none; font-weight: bold;" class="phone_alloka firstColumnBottomPhone">
                            <span>+7(812) 902-50-50</span>
                            <!--<span class="ya-elama-phone call_phone_1">+7(812) 907-15-15</span>-->
                        </a>

                        <p class="firstColumnBottomTime">
                            без выходных с 9.00 до 22.00
                        </p>
                        <a href="/kontakty/">Контакты</a>
                    </div>
                </div>
            </div>
            <div class="secondColumn">
                <div class="icon"></div>
                <div class="secondColumnInner">
                    <div class="boldTitle">
                        Получите консультацию
                    </div>
                    <div class="regularText">
                        В течении нескольких минут
                        Вам перезвонит специалист,
                        который ответит на все интересующие вопросы
                    </div>
                    <br/>

                    <div class="secondColumnBottom">
                        <a data-who="footer_feedback" onclick="yaCounter21785827.reachGoal('foot_click'); return true;" data-formsend="foot_send"  class="buttonGreen showIt">ЗАКАЗАТЬ ЗВОНОК</a>
                    </div>



                </div>
            </div>
            <div class="thirdColumn">
                <div class="icon"></div>
                <div class="thirdColumnInner">
                    <div class="boldTitle">
                        Приходите в наш офис
                    </div>
                    <div class="regularText">
                        Департамент строящегося
                        жилья находится всего в 1 минуте
                        от м.Волковская. Режим работы - ежедневно с 9 до 22
                    </div>
                    <br/>

                    <div class="thirdColumnBottom">
                        <a href="/kontakty/">СПб, Волковский пр., д. 32А,
                            офис 5-12, БЦ “РАДИУС”</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="companyPartCopyright" style="text-align: center;margin-left: 90px;">
                <img src="/bitrix/templates/szvdom/images/sovet-text1.png" style="position: absolute;top: -70px;left: 187px;">
                <a href="http://vk.com/szvdom1" rel="nofollow" target="_blank" style="color:#18d1f9;display: inline-block;margin-top: 15px; text-decoration:none;"><img src="/bitrix/templates/szvdom/images/vk_img.png"><p style="color: #18d1f9;margin-top:-20px;"><span style="color:#18d1f9;">Мы</span> <span style="text-decoration:underline;" class="sos_class">Вконтакте</span></p></a>
            </div>
            <div class="lawPartCopyright" style="line-height: 1.5;">Вся информация на сайте носит справочный характер и не является публичной офертой, определяемой статьёй 476 ГК РФ.
                © <?=date(Y);?> Компания «Созвездие Недвижимости»
                <a href="/sitemap/" style="display:block;">Карта сайта</a>
                <span id="bx-composite-banner" style="margin-top: 5px;display:block;margin-left: -15px;"></span>

                </div>

        </div>
    </div>

	<div class="footerbox">
        <a class="showIt" data-who="podbor_feedback" style="display: inline-block;vertical-align: top;margin-right: -60px;margin-top: 72px;"><img src="/bitrix/templates/szvdom/images/vkladka_podbor.png"></a>
        <a href="/akcii-i-skidki/" style="display: inline-block;vertical-align: top;margin-right: -50px;margin-top: 75px;"><img src="/bitrix/templates/szvdom/images/vkladka_skidka.png"></a>
        <a href="/sposoby-pokupki/zachet-kvartiry/" style="display: inline-block;vertical-align: top;margin-right: -50px;margin-top: 75px;"><img src="/bitrix/templates/szvdom/images/vkladka_zachet.png"></a>
        <a class="showIt" data-who="skidki_feedback" style="display: inline-block;vertical-align: top;margin-right: -45px;margin-top: 75px;"><img src="/bitrix/templates/szvdom/images/vkladka_zapis.png"></a>
		<a class="showIt callibri_phone cpc2" data-who="otv_vopr_feedback" style="display: inline-block;position:relative;vertical-align:top;margin-top: 52px;margin-right:-20px;background: url('/bitrix/templates/szvdom/images/vknadka_number.png')no-repeat;width: 303px;height: 68px;" class="callibri_phone">
			<span style="position: absolute;top: 31px;left: 82px;font-size: 24px;font-family: bold;color:#fff;" class="phone_alloka">
				+7(812) 902-50-50
			</span>
		</a>
	</div>

	<style>
		.cpc2 span{position: absolute;top: 31px;left: 82px;font-size: 24px;font-family: bold;color:#fff;}
	</style>


		</div>
</div>
</div>

<?
/*if ($USER -> isAdmin()){
    echo "<div class='mainPageContent' style='height: 510px;'><h2 style='text-align:center;'>Если Вы видете эту форму - Вы либо админ, либо что-то пошло не так ;)</h2>";  
    $APPLICATION->IncludeComponent(
            "szv:main.feedback_szv",
            "test",
            array(
                "USE_CAPTCHA" => "N",
                "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                "EMAIL_TO" => "sendmail@szvdom.ru",
                "REQUIRED_FIELDS" => array(
                    0 => "PHONE",
                ),
                "EVENT_MESSAGE_ID" => array(
                    0 => "9",
                ),
                "AJAX_MODE" => "Y",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_ADDITIONAL" => "undefined"
            ),
            false
        ); 
    echo "</div>";
}*/
?>

<div class="popUpWindowOverlay" onclick="$('.feedbackWrap').fadeOut(500); $('.otv_vopr_feedback').fadeOut(500); $(this).fadeOut(500);$('.gotovie_podborki').fadeOut(500);"></div>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.fs.scroller.min.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/maphilight.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jscript.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.tinycarousel.min.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/ipotCalc.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.tinyscrollbar.min.js"></script>
<!-- edited by coder 28.04.2016 -->
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/slick.js"></script>
<!-- end of edit -->

<div style="display:none">






    <!--noindex-->

    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-19166424-7']);

    // РџРѕРёСЃРє РєР°СЂС‚РёРЅРѕРє
      _gaq.push(['_addOrganic', 'images.yandex.ru', 'q', true]);
      // РџРѕРёСЃРє РїРѕ Р±Р»РѕРіР°Рј
      _gaq.push(['_addOrganic', 'blogsearch.google.ru', 'q', true]);
      _gaq.push(['_addOrganic', 'blogs.yandex.ru', 'text', true]);
      // РџРѕРёСЃРєРѕРІРёРєРё Р РѕСЃСЃРёРё
      _gaq.push(['_addOrganic', 'go.mail.ru', 'q']);
      _gaq.push(['_addOrganic', 'nova.rambler.ru', 'query']);
      _gaq.push(['_addOrganic', 'nigma.ru', 's']);
      _gaq.push(['_addOrganic', 'webalta.ru', 'q']);
      _gaq.push(['_addOrganic', 'aport.ru', 'r']);
      _gaq.push(['_addOrganic', 'poisk.ru', 'text']);
      _gaq.push(['_addOrganic', 'km.ru', 'sq']);
      _gaq.push(['_addOrganic', 'liveinternet.ru', 'ask']);
      _gaq.push(['_addOrganic', 'quintura.ru', 'request']);
      _gaq.push(['_addOrganic', 'search.qip.ru', 'query']);
      _gaq.push(['_addOrganic', 'gde.ru', 'keywords']);
      _gaq.push(['_addOrganic', 'gogo.ru', 'q']);
      _gaq.push(['_addOrganic', 'ru.yahoo.com', 'p']);
      // РџРѕРёСЃРєРѕРІРёРєРё Р‘РµР»РѕСЂСѓСЃСЃРёРё
      _gaq.push(['_addOrganic', 'akavita.by', 'z']);
      _gaq.push(['_addOrganic', 'tut.by', 'query']);
      _gaq.push(['_addOrganic', 'all.by', 'query']);
      // РџРѕРёСЃРєРѕРІРёРєРё РЈРєСЂР°РёРЅС‹
      _gaq.push(['_addOrganic', 'meta.ua', 'q']);
      _gaq.push(['_addOrganic', 'bigmir.net', 'q']);
      _gaq.push(['_addOrganic', 'i.ua', 'q']);
      _gaq.push(['_addOrganic', 'online.ua', 'q']);
      _gaq.push(['_addOrganic', 'a.ua', 's']);
      _gaq.push(['_addOrganic', 'ukr.net', 'search_query']);
      _gaq.push(['_addOrganic', 'search.com.ua', 'q']);
      _gaq.push(['_addOrganic', 'search.ua', 'query']);
      _gaq.push(['_addOrganic', 'search.ukr.net', 'search_query']);

      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
    <!--/noindex-->
</div>
<div id="top"></div>

<!-- <div class="szv-but">
    <div class="szv_cal-ph szv-animation showIt" onclick="yaCounter21785827.reachGoal('phone_click'); return true;" data-formsend="phone_send"  data-who="footer_feedback">
        <div class="szv_call-track"></div>
        <div class="szv_cal-circle"></div>
        <div class="szv-circle">
            <div class="szv_cir-handset"></div>
        </div>
    </div>
</div> -->

<?php /*
<!-- {literal} -->
<script type='text/javascript'>
    window['liv'+'eT'+'ex'] = true,
    window['live'+'T'+'exI'+'D'] = 114967,
    window['l'+'ive'+'Tex'+'_'+'o'+'bject'] = true;
    (function() {
        var t = document['cre'+'at'+'e'+'El'+'e'+'men'+'t']('script');
        t.type ='text/javascript';
        t.async = true;
        t.src = '//cs'+'15.liv'+'et'+'ex.ru'+'/js/c'+'lient.js';
        var c = document['getEleme'+'n'+'tsBy'+'TagNa'+'me']('script')[0];
        if ( c ) c['pa'+'re'+'ntNo'+'de']['inse'+'rtBef'+'ore'](t, c);
        else document['docu'+'men'+'tEleme'+'nt']['fi'+'r'+'stCh'+'ild']['app'+'endC'+'hild'](t);
    })();
</script>
<!-- {/literal} -->
*/ ?>

<script type="text/javascript">
window['liv'+'eT'+'ex'] = true,
window['live'+'T'+'exI'+'D'] = 114967,
window['l'+'ive'+'Tex'+'_'+'o'+'bject'] = true;

var liveTex = true,
liveTexID = 114967,
liveTex_object = true;
window.LiveTex = {
	onLiveTexReady: function () {

		var desc1 = LiveTex.addEventListener(
			LiveTex.Event.CONVERSATION_STARTED,
			function (data) {
				yaCounter21785827.reachGoal ("CONVERSATION_STARTED");
			}
		);
		var desc2 = LiveTex.addEventListener(
			LiveTex.Event.OFFLINE_MESSAGE_SENT,
			function (data) {
				yaCounter21785827.reachGoal ("OFFLINE_MESSAGE_SENT");	
			}
		);
		var desc3 = LiveTex.addEventListener(
			LiveTex.Event.CALL_STARTED,
			function (data) {
				yaCounter21785827.reachGoal ("CALL_STARTED");
			}
		);
		var desc4 = LiveTex.addEventListener(
			LiveTex.Event.CALL_ESTABLISHED,
			function (data) {
				yaCounter21785827.reachGoal ("CALL_ESTABLISHED");
			}
		);
		var desc5 = LiveTex.addEventListener(
			LiveTex.Event.INVITATION_WINDOW_SHOWN,
			function (data) {
				yaCounter21785827.reachGoal ("INVITATION_WINDOW_SHOWN");
			}
		);
		var desc6 = LiveTex.addEventListener(
			LiveTex.Event.EMPLOYEE_MESSAGE_SENT,
			function (data) {
				yaCounter21785827.reachGoal ("EMPLOYEE_MESSAGE_SENT");
			}
		);
		var desc7 = LiveTex.addEventListener(
			LiveTex.Event.X_WINDOW_SHOWN,
			function (data) {
				yaCounter21785827.reachGoal ("X_WINDOW_SHOWN");
			}
		);
	}
};
(function() {
	var lt = document.createElement('script');
	lt.type ='text/javascript';
	lt.async = true;
	lt.src = '//cs15.livetex.ru/js/client.js';
	var sc = document.getElementsByTagName('script')[0];
	if ( sc ) sc.parentNode.insertBefore(lt, sc);
	else document.documentElement.firstChild.appendChild(lt);
})();
</script>

<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=NT3NE/wL/lwYxQ1I4upc*igxGZ2kAbPNtPT/dSg7KMCUt*jfaM8Z6AKGW5dsPsPrwSKOxfXhYj9yJOxhodxcigwbCXMNrK9ag9REATa8Eh54yramOdnxon7FiPt3xn*aO4Sdxx5xHKclBSlx*A9ghr6OqV46tWyrgmZ8qFNMypI-';</script>





<?
// start block
if(preg_match('#/obekty/(.*[^/])/#siU', $_SERVER['REQUEST_URI'], $matches)):

$sPage = "default";

if(preg_match('#/obekty/.*[^/]/foto/#siU', $_SERVER['REQUEST_URI'])) {
	$sPage = "photo";
}

if(preg_match('#/obekty/.*[^/]/hod-stroitelstva/#siU', $_SERVER['REQUEST_URI'])) {
	$sPage = "stroy";
}

if(preg_match('#/obekty/.*[^/]/tseny-na-kvartiry/#siU', $_SERVER['REQUEST_URI'])) {
	$sPage = "price";
}

if(preg_match('#/obekty/.*[^/]/planirovki/#siU', $_SERVER['REQUEST_URI'])) {
	$sPage = "planir";
}

if(preg_match('#/obekty/.*[^/]/ipoteka/#siU', $_SERVER['REQUEST_URI'])) {
	$sPage = "ipot";
}

if(preg_match('#/obekty/.*[^/]/zachet-zhilja/#siU', $_SERVER['REQUEST_URI'])) {
	$sPage = "zachet";
}

if(preg_match('#/obekty/.*[^/]/pohozhie-obekty/#siU', $_SERVER['REQUEST_URI'])) {
	$sPage = "poh";
}

//echo $matches[1].'<br>';
//echo $sPage;
//$Zag = $APPLICATION->GetTitle(false);
//echo $Zag;

$arSeoFields = array(
    "default" => array(78,47,52,57,21),
    "stroy" => array(87,88,89,90,91),
    "photo" => array(82,83,84,85,86),
    "price" => array(81,49,54,58,22),
    "planir" => array(79,50,55,59,23),
    "ipot" => array(97,98,99,100,101),
    "zachet" => array(92,93,94,95,96),
    "poh" => array(92,93,94,95,96)
);

$arrNeedPropertis = Array();
foreach ($arSeoFields[$sPage] as $sField)
    array_push($arrNeedPropertis, "PROPERTY_".$sField);

	   //array_push($arrNeedPropertis, "DETAIL_PAGE_URL");
array_push($arrNeedPropertis, "CODE");


$arFilter = Array("IBLOCK_ID"=> "1", "CODE" => $matches[1]);


$getElements = CIBlockElement::GetList(Array('left_margin' => 'ASC'), $arFilter, false, false, $arrNeedPropertis);
    while ($arrElements = $getElements->GetNext()) {
		if (!empty($arrElements[$arrNeedPropertis[0].'_VALUE']))
			$APPLICATION->SetPageProperty('h1', $arrElements[$arrNeedPropertis[0].'_VALUE']);
		if (!empty($arrElements[$arrNeedPropertis[1].'_VALUE']))
			$APPLICATION->SetPageProperty('title', $arrElements[$arrNeedPropertis[1].'_VALUE']);
		if (!empty($arrElements[$arrNeedPropertis[2].'_VALUE']))
			$APPLICATION->SetPageProperty('description', $arrElements[$arrNeedPropertis[2].'_VALUE']);
		if (!empty($arrElements[$arrNeedPropertis[3].'_VALUE']))
			$APPLICATION->SetPageProperty('keywords', $arrElements[$arrNeedPropertis[3].'_VALUE']);
		if (!empty($arrElements[$arrNeedPropertis[4].'_VALUE']))
			$APPLICATION->SetPageProperty('seo-txt', $arrElements[$arrNeedPropertis[4].'_VALUE']);
		/*
		echo 'h1:' . $arrElements[$arrNeedPropertis[0].'_VALUE'].'<br>';
		echo 'title: ', $arrElements[$arrNeedPropertis[1].'_VALUE'].'<br>';
		echo 'description; ', $arrElements[$arrNeedPropertis[2].'_VALUE'].'<br>';
		echo 'keywords: ', $arrElements[$arrNeedPropertis[3].'_VALUE'].'<br>';
		echo 'seo-txt; ', $arrElements[$arrNeedPropertis[4].'_VALUE']["TEXT"].'<br>';
		*/
    }

endif;
// end block
?>



<?/*
if(preg_match('#/novosti/.*#siU', $_SERVER['REQUEST_URI']) && !empty($_GET['PAGEN_1']) && ($page = (int)$_GET['PAGEN_1']) > 1) {
$APPLICATION->SetPageProperty("title", $APPLICATION->GetPageProperty("title") . ' | Страница ' . $page);
}
if(preg_match('#/obekty/.*#siU', $_SERVER['REQUEST_URI']) && !empty($_GET['PAGEN_1']) && ($page = (int)$_GET['PAGEN_1']) > 1) {
$APPLICATION->SetPageProperty("title", $APPLICATION->GetPageProperty("title") . ' | Страница ' . $page);
}*/
?>



<div id="clickfrog_counter_container" style="width:0px;height:0px;overflow:hidden;"></div><script type="text/javascript" data-skip-moving="true">(function(d, w) {var clickfrog = function() {if(!d.getElementById('clickfrog_js_container')) {var sc = document.createElement('script');sc.type = 'text/javascript';sc.async = true;sc.src = "//stat.clickfrog.ru/c.js?r="+Math.random();sc.id = 'clickfrog_js_container';var c = document.getElementById('clickfrog_counter_container');c.parentNode.insertBefore(sc, c);}};if(w.opera == "[object Opera]"){d.addEventListener("DOMContentLoaded",clickfrog,false);}else {clickfrog();}})(document, window);</script><noscript><div style="width:0px;height:0px;overflow:hidden;"><img src="//stat.clickfrog.ru/no_script.php?img" style="width:0px; height:0px;" alt=""/></div></noscript><script type="text/javascript" data-skip-moving="true">var clickfrogru_uidh='14efcf64470f8e895702523bbd841ace';</script>

</body>
</html>