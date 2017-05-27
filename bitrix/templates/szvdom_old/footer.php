<!-- coder -->
<div class="feedbackWrap popUpSelect">
    <div class="popUpSelectInner">
        <div class="closeElementPopUp" onclick="$(this).parent('.popUpSelectInner').parent('.popUpSelect').fadeOut(500);$('.popUpWindowOverlay').fadeOut(500);"></div>
        <?
        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL");
        $arFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arProps = $ob->GetProperties();
            $arFields["PROPERTIES"] = $arProps;
            $arResult["ITEMS"][] = $arFields;
        }
        $values = array();
        foreach ($arResult["ITEMS"] as $value) {
            foreach ($value["PROPERTIES"]["SELECT_GROUPS"]["VALUE"] as $subValue) {
                $values[] = $subValue;
            }
        }
        $arResult["VALUES"] = array_unique($values);

        ?>
        <div class="leftColumnPopUp">
            <ul>
                <? foreach ($arResult["VALUES"] as $value) { ?>
                    <li data-rel="<?= $value; ?>" class="changeIt"> &mdash;<?= $value; ?></li>
                <? } ?>
            </ul>
        </div>

        <div id="rightColumnPopUp">
            <p class="selectCategoryListTitle">Готовые подборки новостроек</p>
            <? foreach ($arResult["VALUES"] as $key => $value) { ?>
                <div data-rel="<?= $value; ?>" class="searchBlockPopUp">
                    <? foreach ($arResult["ITEMS"] as $subKey => $subValue) {
                        if (in_array($value, $subValue["PROPERTIES"]["SELECT_GROUPS"]["VALUE"])) {
                           /* if (!empty($subValue["PROPERTIES"]["FILTER_VAL"]["VALUE"])){
                                $query = "?".$subValue["PROPERTIES"]["FILTER_VAL"]["VALUE"];
                            }else{
                                $query = "";
                            }*/
                            ?>
                            <a href="<?=$subValue["DETAIL_PAGE_URL"];?>"><?= $subValue["NAME"]; ?></a>

                        <?
                        }
                    } ?>
                    <br/>
                </div>
            <? } ?>
        </div>
    </div>
</div>

<div class="price_plan_feedback feedbackWrap">
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

<!--
<div class="skidki_feedback feedbackWrap">
    <div class="feedbackBody">
        <? $APPLICATION->IncludeComponent(
            "szv:main.feedback_szv",
            "skidki",
            array(
                "USE_CAPTCHA" => "N",
                "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                "EMAIL_TO" => "sendmail@szvdom.ru",
                "REQUIRED_FIELDS" => array(
                    0 => "PHONE",
                ),
                "EVENT_MESSAGE_ID" => array(
                    0 => "16",
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
-->

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
		"USE_CAPTCHA" => "Y",
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


<!--
<div class="otv_vopr_feedback feedbackWrap">
    <div class="feedbackBody">
        <? $APPLICATION->IncludeComponent(
            "szv:main.feedback_szv",
            "otv_vopr",
            array(
                "USE_CAPTCHA" => "N",
                "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                "EMAIL_TO" => "sendmail@szvdom.ru",
                "REQUIRED_FIELDS" => array(
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
-->

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
                        <td><input type="button" style="width: 200px" class="popup_send showIt" name="submit_popup" value="Сделать запрос" onclick="$('.otv_vopr_feedback').hide(); $('.zapros_feedback').show();" data-who="podbor_feedback"><br></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!--
<div class="superForm feedbackWrap" style="background: transparent !important;">
    <div class="feedbackBody" style="background: transparent !important;">
        <? $APPLICATION->IncludeComponent(
            "szv:main.feedback_szv",
            "annoying",
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
-->

<?/* if ($USER -> isAdmin()){?>
    <a data-who="testForm" class="buttonGreen showIt">Тестовая форма</a>
    <div class="testForm feedbackWrap" style="background: transparent !important;">
        <div class="feedbackBody" style="background: transparent !important;">
            <? $APPLICATION->IncludeComponent(
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
                        0 => "15",
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
<? }*/?>
<div class="footer">

    <? if (strstr($APPLICATION->GetCurPage(),'/obekty/') || (strpos($APPLICATION->GetCurPage(),'/obekty/') === false) && (strpos($APPLICATION->GetCurPage(),'/vyborki/') === false) && (strpos($APPLICATION->GetCurPage(),'/akcii-i-skidki/') === false) ){?>
        <div class="howWeWorkAndFriendTip">
            <div class="how_text"><p class="text_up">Схема работы</p><p id="toggleWork">свернуть<i class=""></i></p></div>

            <? if (strstr($APPLICATION->GetCurPage(),'/vtorichnaja/')){?>
                <div class="how_table">
                <div class="block">
                <?$APPLICATION->IncludeFile('/vtorichnaja/howWeWork.php', Array(), Array("MODE"=> "php","NAME"=> "Редактирование включаемой области раздела"));$dbl='none';?>
                <?} else { $dbl='block';?>

                <div class="how_table old">
                    <div class="block old">

            <?}?>

                    </div>               
                </div>

            <div style="display:<?=$dbl?>;" class="how_text"><p class="text_down">Наши услуги для Вас абсолютно бесплатны!</p> <a data-who="footer_feedback" onclick="yaCounter21785827.reachGoal('how_work_click'); return true;" data-formsend="how_work_send"  class="buttonGreen showIt">Оставить заявку</a>

                <div class="clear"></div>
            </div>
        </div>
    <?} ?>





<? if (!strstr($APPLICATION->GetCurPage(),'/vtorichnaja/')){?>
   <!--noindex--> <div class="selectCategoryListForPopUp">
        <p>Готовые подборки новостроек <a data-who="popUpSelect" data-type="По цене" class="greyLink showIt" style="margin-left: 10px;"> Смотреть все подборки</a></p>
        <ul>
            <? foreach ($arResult["VALUES"] as $value) { ?>
                <li data-who="popUpSelect" class="showIt" data-type="<?= $value; ?>" ><span style="border-bottom: none"></span><span><?= $value; ?></span></li>
            <? } ?>
        </ul>

    </div><!--/noindex-->
<?}?>
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
						<a href="tel:+7(812)902-50-50" style="text-decoration:none; font-weight: bold;" class="firstColumnBottomPhone">
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
        <a href="/akcii-i-skidki/" style="display: inline-block;vertical-align: top;margin-right: -50px;margin-top: 52px;"><img src="/bitrix/templates/szvdom/images/vkladka_skidka.png"></a>
        <a href="/sposoby-pokupki/zachet-kvartiry/" style="display: inline-block;vertical-align: top;margin-right: -50px;margin-top: 52px;"><img src="/bitrix/templates/szvdom/images/vkladka_zachet.png"></a>
        <a class="showIt" data-who="skidki_feedback" style="display: inline-block;vertical-align: top;margin-right: -45px;margin-top: 52px;"><img src="/bitrix/templates/szvdom/images/vkladka_zapis.png"></a>
        <a class="showIt" data-who="otv_vopr_feedback" style="display: inline-block;position:relative;vertical-align:top;margin-top: 52px;margin-right:-20px;background: url('/bitrix/templates/szvdom/images/vknadka_number.png')no-repeat;width: 303px;height: 68px;"><span style="position: absolute;top: 31px;left: 82px;font-size: 24px;font-family: bold;color:#fff;">+7(812) 902-50-50</span></a>
	</div>

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

<div class="popUpWindowOverlay" onclick="$('.feedbackWrap').fadeOut(500); $('.otv_vopr_feedback').fadeOut(500); $(this).fadeOut(500);"></div>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.fs.scroller.min.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/maphilight.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jscript.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/fotorama.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.tinycarousel.min.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/ipotCalc.js"></script>
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.tinyscrollbar.min.js"></script>
<div style="display:none">
    <!--LiveInternet counter-->
    <script type="text/javascript"><!--
        document.write("<a href='http://www.liveinternet.ru/click' " +
        "target=_blank><img src='//counter.yadro.ru/hit?t44.1;r" +
        escape(top.document.referrer) + ((typeof(screen) == "undefined") ? "" :
        ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
            screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
        ";h" + escape(document.title.substring(0, 80)) + ";" + Math.random() +
        "' alt='' title='LiveInternet: показано число посетителей за" +
        " сегодня' " +
        "border='0' width='31' height='31'><\/a>")
        //--></script>
    <!--/LiveInternet-->


    <!-- Rating@Mail.ru logo -->
    <a href="http://top.mail.ru/jump?from=2386740" rel="nofollow">
    <img src="//top-fwz1.mail.ru/counter?id=2386740;t=295;l=1"
    style="border:0;" height="29" width="38" alt="Рейтинг@Mail.ru" /></a>
    <!-- //Rating@Mail.ru logo -->

    <!-- begin of Top100 code -->
    <script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?2782139"></script>
    <noscript>
    <a href="http://top100.rambler.ru/navi/2782139/" rel="nofollow">
    <img src="http://counter.rambler.ru/top100.cnt?2782139" alt="Rambler's Top100" border="0" />
    </a>
    </noscript>
    <!-- end of Top100 code -->


		<?php /*
    <!-- Rating@Mail.ru counter -->
<script type="text/javascript">//<![CDATA[
var _tmr = _tmr || [];
_tmr.push({id: "2386740", type: "pageView", start: (new Date()).getTime()});
(function (d, w) {
   var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true;
   ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
   var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
   if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window);
//]]></script><noscript><div style="position:absolute;left:-10000px;">
<img src="//top-fwz1.mail.ru/counter?id=2386740;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->
*/ ?>

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
<?/*
   <div id="clickfrog_counter_container" style="width:0px;height:0px;overflow:hidden;"></div><script type="text/javascript">(function(d, w) {var clickfrog = function() {if(!d.getElementById('clickfrog_js_container')) {var sc = document.createElement('script');sc.type = 'text/javascript';sc.async = true;sc.src = "//stat.clickfrog.ru/c.js?r="+Math.random();sc.id = 'clickfrog_js_container';var c = document.getElementById('clickfrog_counter_container');c.parentNode.insertBefore(sc, c);}};if(w.opera == "[object Opera]"){d.addEventListener("DOMContentLoaded",clickfrog,false);}else {clickfrog();}})(document, window);</script><noscript><div style="width:0px;height:0px;overflow:hidden;"><img src="//stat.clickfrog.ru/no_script.php?img" style="width:0px; height:0px;" alt=""/></div></noscript><script type="text/javascript">var clickfrogru_uidh='0243015d402868a672e49f2ef182b74d';</script>
*/?>
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

<?$getElements = CIBlockElement::GetList(Array('left_margin' => 'ASC'), Array("IBLOCK_ID"=> "1"), false, false, Array("PROPERTY_47", "PROPERTY_52", "PROPERTY_57", "PROPERTY_49", "PROPERTY_54", "PROPERTY_58", "DETAIL_PAGE_URL"));
    while ($arrElements = $getElements->GetNext()) {
                   if ($_SERVER['REQUEST_URI'] == $arrElements['DETAIL_PAGE_URL'] || $_SERVER['REQUEST_URI'] == $arrElements['DETAIL_PAGE_URL'].'tseny-na-kvartiry/') {
                        if (!empty($arrElements['PROPERTY_47_VALUE'])){
                            $APPLICATION->SetPageProperty('title', $arrElements['PROPERTY_47_VALUE']);
                        }
                        if (!empty($arrElements['PROPERTY_52_VALUE'])){
                            $APPLICATION->SetPageProperty('description', $arrElements['PROPERTY_52_VALUE']);
                        }
                        if (!empty($arrElements['PROPERTY_57_VALUE'])){
                            $APPLICATION->SetPageProperty('keywords', $arrElements['PROPERTY_57_VALUE']);
                        }
                        if (!empty($arrElements['PROPERTY_49_VALUE'])){
                            $APPLICATION->SetPageProperty('title', $arrElements['PROPERTY_49_VALUE']);
                        }
                        if (!empty($arrElements['PROPERTY_54_VALUE'])){
                            $APPLICATION->SetPageProperty('description', $arrElements['PROPERTY_54_VALUE']);
                        }
                        if (!empty($arrElements['PROPERTY_58_VALUE'])){
                            $APPLICATION->SetPageProperty('keywords', $arrElements['PROPERTY_58_VALUE']);
                        }

                    }
    }
/*
 $Zag = $APPLICATION->GetTitle(false);

if(preg_match('#/obekty/.*[^/]/$#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-samotsvety/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-medalist/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-shuvalovskiy/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-tri-kita/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-tri-kita-2/tseny-na-kvartiry/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-zhivi-v-rybatskom/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-devyatyy-val/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-life-primorskiy/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-severnyy-vals/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-tri-kita-3/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-cinema/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-vesna-2/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-skladskaya-28/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-petrovskaya-rivera/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-aleksandriya/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-novyy-okkervil/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-lastochkino-gnezdo/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-yubileynyy-kvartal/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-pulkovskiy/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-alfavit/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-molodezhnyy/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-sofiya/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-tsarskaya-stolitsa/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-o-yunost/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-vitamin/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-gorod-masterov/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-vesna/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-ya-romantik/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-murinskiy-posad/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-novaya-okhta/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-chistyy-ruchey/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-aleksandr-nevskiy/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-novoe-murino/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-prinevskiy/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/zhk-yutteri/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-yuzhnaya-akvatoriya/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-kremlevskie-zvezdy/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-jaanila-country/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-kvartet/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-kantemirovskiy/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-kalina-park/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-novoe-yanino/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-shuvalovskiy-duet/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-nevskaya-zvezda/#siU', $_SERVER['REQUEST_URI'])
&& !preg_match('#/obekty/zhk-zolotye-kupola/#siU', $_SERVER['REQUEST_URI'])) {
 $APPLICATION->SetPageProperty('title', $Zag . ' | Покупка и продажа жилой и коммерческой недвижимости в Санкт-Петербурге');
 $APPLICATION->SetPageProperty('description', 'Квартиры в ' . $Zag . ' и других жилых комплексах от застройщика. Продажа жилой и коммерческой недвижимости  в Санкт-Петербурге и Ленинградской области без комиссии. Строящееся и готовое жилье: описание, планировки, цены, скидки. ');
 $APPLICATION->SetPageProperty('keywords', mb_strtolower($Zag).' покупка продажа жилая коммерческая недвижимость санкт петербург спб');
} 

if(preg_match('#/obekty/.*[^/]/foto/#siU', $_SERVER['REQUEST_URI'])) {
 $APPLICATION->SetPageProperty('title', $Zag . ' | Фото | Квартиры в новостройках Санкт-Петербурга: описание, планировки, цены, скидки');
 $APPLICATION->SetPageProperty('description', 'Фото ' . $Zag . ' и других жилых комплексов. Продажа жилой и коммерческой недвижимости в Санкт-Петербурге и Ленинградской области без комиссии. Квартиры в новостройках СПб: описание, планировки, цены, скидки. ');
 $APPLICATION->SetPageProperty('keywords', mb_strtolower($Zag).' фото');
}

if(preg_match('#/obekty/.*[^/]/hod-stroitelstva/#siU', $_SERVER['REQUEST_URI'])) {
 $APPLICATION->SetPageProperty('title', $Zag . ' | Ход строительства | Квартиры в новостройках Санкт-Петербурга: описание, планировки, цены, скидки');
 $APPLICATION->SetPageProperty('description', 'Ход строительства ' . $Zag . ' и других жилых комплексов. Продажа жилой и коммерческой недвижимости в Санкт-Петербурге и Ленинградской области без комиссии. Квартиры в новостройках СПб: описание, планировки, цены, скидки. ');
  $APPLICATION->SetPageProperty('keywords', mb_strtolower($Zag).' ход строительства');
}

if(preg_match('#/obekty/.*[^/]/tseny-na-kvartiry/#siU', $_SERVER['REQUEST_URI'])) {
 $APPLICATION->SetPageProperty('title', $Zag . ' | Цены на квартиры | Недвижимость в новостройках Санкт-Петербурга: описание, планировки, скидки');
 $APPLICATION->SetPageProperty('description', 'Цены на квартиры в ' . $Zag . ' и других жилых комплексах. Продажа жилой и коммерческой недвижимости в Санкт-Петербурге и Ленинградской области без комиссии. Квартиры в новостройках СПб: описание, планировки, цены, скидки. ');
  $APPLICATION->SetPageProperty('keywords', mb_strtolower($Zag).' цены на квартиры');
}

if(preg_match('#/obekty/.*[^/]/planirovki/#siU', $_SERVER['REQUEST_URI'])) {
 $APPLICATION->SetPageProperty('title', $Zag . ' | Планировки квартир | Недвижимость в новостройках Санкт-Петербурга: описание, цены, скидки');
 $APPLICATION->SetPageProperty('description', 'Планировки квартир в ' . $Zag . ' и других жилых комплексах. Продажа жилой и коммерческой недвижимости в Санкт-Петербурге и Ленинградской области без комиссии. Квартиры в новостройках СПб: описание, планировки, цены, скидки.');
  $APPLICATION->SetPageProperty('keywords', mb_strtolower($Zag).' планировки квартир');
}

if(preg_match('#/obekty/.*[^/]/ipoteka/#siU', $_SERVER['REQUEST_URI'])) {
 $APPLICATION->SetPageProperty('title', $Zag . ' | Ипотека на квартиры | Недвижимость в новостройках Санкт-Петербурга: описание, цены, скидки');
 $APPLICATION->SetPageProperty('description', 'Квартиры в ' . $Zag . ' и других жилых комплексах в ипотеку. Продажа жилой и коммерческой недвижимости в Санкт-Петербурге и Ленинградской области без комиссии. Квартиры в новостройках СПб: описание, планировки, цены, скидки.');
  $APPLICATION->SetPageProperty('keywords', mb_strtolower($Zag).' квартиры в ипотеку');
}

if(preg_match('#/obekty/.*[^/]/zachet-zhilja/#siU', $_SERVER['REQUEST_URI'])) {
 $APPLICATION->SetPageProperty('title', $Zag . ' | Зачет жилья | Квартиры в новостройках Санкт-Петербурга: описание, цены, скидки');
 $APPLICATION->SetPageProperty('description', 'Квартиры в ' . $Zag . ' и других жилых комплексах. Программа «Зачет жилья». Продажа жилой и коммерческой недвижимости в Санкт-Петербурге и Ленинградской области без комиссии. Квартиры в новостройках СПб: описание, планировки, цены, скидки. ');
  $APPLICATION->SetPageProperty('keywords', mb_strtolower($Zag).' зачет жилья');
}

if(preg_match('#/obekty/.*[^/]/pohozhie-obekty/#siU', $_SERVER['REQUEST_URI'])) {
 $APPLICATION->SetPageProperty('title', $Zag . ' | Похожие объекты | Квартиры в новостройках Санкт-Петербурга: описание, цены, скидки');
 $APPLICATION->SetPageProperty('description', $Zag . ' и похожие жилые комплексы СПб. Продажа жилой и коммерческой недвижимости в Санкт-Петербурге и Ленинградской области без комиссии. Квартиры в новостройках: описание, планировки, цены, скидки. ');
  $APPLICATION->SetPageProperty('keywords', mb_strtolower($Zag).' похожие объекты');
}





if(preg_match('#/obekty/zhk-tri-kita-3/tseny-na-kvartiry/#siU', $_SERVER['REQUEST_URI'])) {
 $APPLICATION->SetPageProperty('title', 'ЖК «Три кита 3» – цены на квартиры | Недвижимость в новостройках Санкт-Петербурга: описание, планировки, цены, скидки');
 $APPLICATION->SetPageProperty('description', 'Цены на квартиры в ЖК «Три кита 3» и других жилых комплексах от застройщика в СПб. Продажа жилой недвижимости в новостройках Санкт-Петербурга и Ленинградской области без комиссии. Строящееся и готовое жилье: описание, планировки, цены, скидки.');
 $APPLICATION->SetPageProperty('keywords', 'жк три кита 3 очередь цены');
}   
   */
    ?>
<?/*
if(preg_match('#/novosti/.*#siU', $_SERVER['REQUEST_URI']) && !empty($_GET['PAGEN_1']) && ($page = (int)$_GET['PAGEN_1']) > 1) {
$APPLICATION->SetPageProperty("title", $APPLICATION->GetPageProperty("title") . ' | Страница ' . $page);
}
if(preg_match('#/obekty/.*#siU', $_SERVER['REQUEST_URI']) && !empty($_GET['PAGEN_1']) && ($page = (int)$_GET['PAGEN_1']) > 1) {
$APPLICATION->SetPageProperty("title", $APPLICATION->GetPageProperty("title") . ' | Страница ' . $page);
}*/
?>

</body>
</html>