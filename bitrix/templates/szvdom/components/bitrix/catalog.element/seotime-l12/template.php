<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$masssa = array();
$arsss = Array("IBLOCK_ID"=> 6, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","PROPERTY_BUILD" => $arResult["ID"]);
$rss = CIBlockElement::GetList(Array(), $arsss, false, false, array());
while($ob = $rss->GetNextElement())
{
    $masssa[] = $ob->GetFields();
}
if (!empty($arResult["PROPERTIES"]["SECOND_ID"]["VALUE"])){
	$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
	$blockidall = $xml->xpath("/Ads/Apartments/Apartment[@blockid='" . $arResult["PROPERTIES"]["SECOND_ID"]["VALUE"]. "']");
}
ob_start();
$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
    'ID' => $strMainID,
    'PICT' => $strMainID . '_pict',
    'DISCOUNT_PICT_ID' => $strMainID . '_dsc_pict',
    'STICKER_ID' => $strMainID . '_sticker',
    'BIG_SLIDER_ID' => $strMainID . '_big_slider',
    'BIG_IMG_CONT_ID' => $strMainID . '_bigimg_cont',
    'SLIDER_CONT_ID' => $strMainID . '_slider_cont',
    'SLIDER_LIST' => $strMainID . '_slider_list',
    'SLIDER_LEFT' => $strMainID . '_slider_left',
    'SLIDER_RIGHT' => $strMainID . '_slider_right',
    'OLD_PRICE' => $strMainID . '_old_price',
    'PRICE' => $strMainID . '_price',
    'DISCOUNT_PRICE' => $strMainID . '_price_discount',
    'SLIDER_CONT_OF_ID' => $strMainID . '_slider_cont_',
    'SLIDER_LIST_OF_ID' => $strMainID . '_slider_list_',
    'SLIDER_LEFT_OF_ID' => $strMainID . '_slider_left_',
    'SLIDER_RIGHT_OF_ID' => $strMainID . '_slider_right_',
    'QUANTITY' => $strMainID . '_quantity',
    'QUANTITY_DOWN' => $strMainID . '_quant_down',
    'QUANTITY_UP' => $strMainID . '_quant_up',
    'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
    'QUANTITY_LIMIT' => $strMainID . '_quant_limit',
    'BASIS_PRICE' => $strMainID . '_basis_price',
    'BUY_LINK' => $strMainID . '_buy_link',
    'ADD_BASKET_LINK' => $strMainID . '_add_basket_link',
    'BASKET_ACTIONS' => $strMainID . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $strMainID . '_not_avail',
    'COMPARE_LINK' => $strMainID . '_compare_link',
    'PROP' => $strMainID . '_prop_',
    'PROP_DIV' => $strMainID . '_skudiv',
    'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
    'OFFER_GROUP' => $strMainID . '_set_group_',
    'BASKET_PROP_DIV' => $strMainID . '_basket_prop',
);
$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
    ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
    : $arResult['NAME']
);
$strAlt = (
isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
    ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
    : $arResult['NAME']
);
?>
<div class="scroll_top" style="height:8px;"></div><div itemscope itemtype="http://schema.org/Product">
<div class="elementTitle">
<!--<div><h1>#SEO#</h1></div>-->
<div><h1>ЖК "Легенда Дальневосточного"</h1></div>

    <?
	//echo $APPLICATION->GetCurPage();
/*
    if ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "pohozhie-obekty/") {
        $description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_OBJECT"]["VALUE"]["TEXT"]);
    } elseif ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "hod-stroitelstva/") {
        $description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_WORK"]["VALUE"]["TEXT"]);
    } elseif ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "foto/") {
        $description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_PHOTO"]["VALUE"]["TEXT"]);
    } elseif ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "ipoteka/") {
        $description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_IPOTEKY"]["VALUE"]["TEXT"]);
    } elseif ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "zachet-zhilja/") {
        $description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_ZACHET"]["VALUE"]["TEXT"]);
    } elseif ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "tseny-na-kvartiry/") {
        $description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_PRICE"]["VALUE"]["TEXT"]);
    } elseif ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL'] . "planirovki/") {
        $description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_PLAN"]["VALUE"]["TEXT"]);
    } elseif ($APPLICATION->GetCurPage() == $arResult['DETAIL_PAGE_URL']) {
        $description = htmlspecialcharsBack($arResult["PROPERTIES"]["DESCRIPTION_SEO_MAIN"]["VALUE"]["TEXT"]);
    } 
*/
?>
     <!-- _new -->
	<img width="105" height="100" src="/bitrix/images/seotime/img/img01.png" title="" alt="" class="best-offer"/>
  <!-- /new -->



</div><div style="display: none;" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<span itemprop="price">Узнать цены</span>
<span itemprop="priceCurrency">RUB</span>
    </div>

<? $descr = strip_tags($description); echo "<meta itemprop='description' content='Описание: ".$descr."'/>";?>

<?
if (preg_match('#/obekty/zhk-legenda-na-komendantskom-58/.*#siU', $_SERVER['REQUEST_URI'])) {
echo "<!-- lk -->";
																							}

?>
<ul class="menuForElements">
    <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>">Описание</a></li>
    <? if (!empty($arResult["PROPERTIES"]["MULTI_IMAGES"]["VALUE"]) && !preg_match('#/obekty/zhk-ya-romantik/.*#siU', $_SERVER['REQUEST_URI'])) { ?>
        <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>foto/">Фото</a></li>
    <? } ?>
    <? if (!empty($arResult["PROPERTIES"]["MULTI_IMAGES_JOB"]["VALUE"])) { ?>
        <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>hod-stroitelstva/">Ход строительства</a></li>
    <? } ?>
    <?if (empty($arResult["PROPERTIES"]["SECOND_ID"]["VALUE"])){
    	if (!empty($masssa)){?>
		    <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>tseny-na-kvartiry/">Цены</a></li>
		    <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>planirovki/">Планировки</a></li>
    	<?}
	}else{
    	if (!empty($blockidall)){?>
		    <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>tseny-na-kvartiry/">Цены</a></li>
		    <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>planirovki/">Планировки</a></li>
    	<?}
    }?><?if (!preg_match('#/obekty/zhk-flagman/.*#siU', $_SERVER['REQUEST_URI']) && !preg_match('#/obekty/zhk-vnutri/.*#siU', $_SERVER['REQUEST_URI']) && !preg_match('#/obekty/zhk-ya-romantik/.*#siU', $_SERVER['REQUEST_URI'])){?>
    <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>ipoteka/">Ипотека</a></li><?}?>
    <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>zachet-zhilja/">Зачет жилья</a></li>
    <? if (!empty($arResult["PROPERTIES"]["OBJECTS_FOR_THIS"]["VALUE"]) || !empty($arResult["PROPERTIES"]["MAP_OBJECTS"]["VALUE"]) || !empty($arResult["PROPERTIES"]["OBJECT_SELECTIONS"]["VALUE"])) { ?>
        <li class="inline"><a href="<?= $arResult['DETAIL_PAGE_URL']; ?>pohozhie-obekty/">Похожие объекты</a></li>
    <? } ?>
</ul>
</div>





#DYNAMIC#


<?if ($APPLICATION->GetCurPage() != $arResult['DETAIL_PAGE_URL'] . "zachet-zhilja/") {?>



<div class="new_ipoteka_calc">

   <div class="heading">Воспользуйтесь нашим ипотечным калькулятором</div>
    <div class="background">

        <div class="showen_part">
            <div class="input_wrap input_wrap1">
                <div class="title">Стоимость квартиры</div>
                <div class="input"><input type="text" placeholder="2 000 000" id="flatPrice"> <span>р.</span></div>
            </div>

            <div class="input_wrap input_wrap2">
                <div class="title">Собственные средства</div>
                <div class="input"><input type="text" placeholder="200 000" id="firstPay"> <span>р.</span></div>
            </div>

            <div class="vertical_line"></div>

            <div class="input_wrap input_wrap3">
                <div class="title">Срок кредитования</div>
                <div class="input"><input type="text" placeholder="10" id="yearsCount"> <span>лет</span></div>
            </div>

            <div class="input_wrap input_wrap4">
                <div class="title">Годовая ставка, %</div>
                <div class="input">
                    <select id="yearPercent2">
                        <option value="10">10 %</option>
                        <option value="11">11 %</option>
                        <option value="11">11,4 %</option>
                        <option value="11">11,8 %</option>
                        <option value="12">12 %</option>
                        <option value="13">13 %</option>
                        <option value="14">14 %</option>
                        <option value="15">15 %</option>
                        <option value="16">16 %</option>
                        <option value="17">17 %</option>
                        <option value="18">18 %</option>
                    </select>
                </div>
            </div>

            <script>
            $('#flatPrice').priceFormat({
                thousandsSeparator: ' ',
                prefix: '',
                clearPrefix: true,
                centsLimit: 0
            });

            $('#firstPay').priceFormat({
                thousandsSeparator: ' ',
                prefix: '',
                clearPrefix: true,
                centsLimit: 0
            });

            $('#yearsCount').priceFormat({
                limit: 2,
                thousandsSeparator: '',
                prefix: '',
                clearPrefix: true,
                centsLimit: 0
            });
            </script>

            <div style="clear: both;"></div>

            <div class="button_section">
                <div class="button_left_line"></div>
                <div class="button calcIpotBtn">Рассчитать ипотеку</div>
                <div class="button_right_line"></div>
                <div style="clear: both;"></div>
            </div>
        </div>


        <div class="hidden_part">
            <div class="title">Ваш платёж составит:</div>
            <div class="summa"> <div class="result"id="result_div">0</div> <div class="sub">руб.</div> <div style="clear: both;"></div> <input id="result" value="" type="hidden"> </div>
            <div class="text">Расчет носит информационный характер и не является окончательным.<br>Вы можете записаться на бесплатную консультацию ипотечного менеджера и получить ипотеку с вероятностью 99%!</div>
            <div class="phone_button">
                <span class="ya-elama-phone">+7 (812) 902-50-50</span>
                <a href="javascript: void(0);" onclick="$('.sendIpotekaForm').show();">оставить заявку</a>
            </div>

            <div class="sendIpotekaForm ipotekaMailTable">
                <input type="text" placeholder="Ваше имя" id="ipotekaMailTableFio">
                <input type="text" placeholder="Ваш телефон" id="ipotekaMailTablePhone">
                <div class="button" onclick="sendIpotekaMail();">Отправить</div>
                <div style="clear: both;"></div>
            </div>

        </div>

    </div>
<!-- partners -->
<div class="ipoteka-partners">
      <div class="heading">Подбор лучшего предложения<br>от ведущих банков партнеров!</div>
      <div class="partners-img"><img src="/bitrix/images/seotime/img/partners_dalnevost.jpg" alt="Подбор лучшего предложения от 60 банков партнеров"></div>
    </div>
<!-- / partners -->

</div>




<?}?>

<div class="get-offers">
  <div class="leftSide">
    <img src="/bitrix/images/seotime/img/smirnova.jpg" class="img-circle" alt="">
    <p>Смирнова Юлия</p>
  </div>
  <div class="rightSide">
	  <div class="heading">Хотите получить лучшее предложение <br/>по покупке квартиры?</div>
    <p>— Сравнить этот комплекс с другими самыми горячими и выгодными предложениями на рынке!</p>
    <p>— Получить эксклюзивную скидку на покупку квартиры у этого застройщика!</p>
    <p>— Получить полную и достоверную информацию о понравившихся ЖК и необходимых документах</p>
    <a href="#form06" class="buttonGreen">ДА, я хочу лучшее предложение</a>
    <div class="note">КОНСУЛЬТАЦИЯ БЕСПЛАТНА<br>и вас ни к чему не обязывает!</div>
  </div>
  <div style="clear: both;"></div>
</div>



<!-- see also-->

<div class="see-also">
  <div class="heading">Другие комплексы застройщика LEGENDA Intelligent Development с лучшими ценами:</div>
  <div class="see-also-block">
    <img src="/bitrix/images/seotime/img/also04.jpg" alt="">
    <a href="http://szvdom.ru/obekty/zhk-legenda-na-komendantskom-58/"><strong>ЖК Легенда Комендантского</strong>от 2,6 млн руб</a>
  </div>
  <div class="see-also-block">
    <img src="/bitrix/images/seotime/img/also02.jpg" alt="">
    <a href="http://szvdom.ru/obekty/zhk-legenda-na-optikov-34/"><strong>ЖК Легенда на Оптиков 34</strong></a>
  </div>
  <div class="see-also-block">
    <img src="/bitrix/images/seotime/img/also03.jpg" alt="">
    <a href="http://szvdom.ru/obekty/zhk-legenda-na-yakhtennoy-24/"><strong>ЖК Легенда на Яхтенной 24</strong></a>
  </div>
</div>
<!-- /see also-->
<div style="clear: both;"></div>
<div class="elementDesc mainPageContent">
  <div class="overview">

    <h1>Квартиры в ЖК «Легенда Дальневосточного»</h1>
    <p>Комплекс находится в одном из самых красивых районов СПб — Невском. </p>
    <h2>О комплексе и условиях покупки</h2>
    <p>Дом сдается единомоментно во 2 квартале 2018 года, поэтому предложенные сегодня в ЖК Легенда на Дальневосточном 12 цены вас приятно удивят. Двухкомнатная квартира  будет стоить от 3,7 млн рублей.</p>
    <p>В свою очередь покупателям обещаны европейские стандарты в планировке и техническом обеспечении жилья, закрытый двор с охраной и единым социальным окружением. В качестве дополнительного бонуса — Wi-Fi на всей территории комплекса.</p>
    <p>Более подробную информацию о жилом комплексе «Легенда на Дальневосточном 12» Вы всегда можете получить, связавшись с отделом продаж как по телефону +7 (812) 902-50-50, так и с помощью онлайн формы связи, на официальном сайте компании «Созвездие недвижимости».</p>

  </div>
</div>

<?
$APPLICATION->IncludeFile('photo.php');
?>
<!-- _new modals -->
<div id="form01" class="modalDialog">
    <div>
        <a href="#close" title="Close" class="close"></a>
        <div class="heading">Бесплатная консультация по выгодным условиям покупки!
            <span>Оставьте свой номер телефона, мы свяжемся с вами в течении 15 минут и ответим на все интересующие вас вопросы по действующим программам!</span></div>
        <form class="popup-form">
            <div class="input-group">
                <label for="i101">Телефон</label>
                <input type="text" class="input-phone" placeholder="+7 (___) ___-____" id="i101" name="user[phone]">
            </div>
            <div class="input-group">
                <label for="i102">Имя</label>
                <input type="text" placeholder="Иван Иванов" id="i102" name="user[name]">
            </div>
            <div class="input-group">
                <input type="submit" class="buttonGreen" value="Получить консультацию">
            </div>
        </form>
    </div>
</div>


<div id="form02" class="modalDialog">
    <div>
        <a href="#close" title="Close" class="close"></a>
        <div class="heading">Узнайте стоимость квартир со скидкой и доступные планировки на ЖК будущего Legenda!
            <span>Сейчас пока еще доступны лучшие цены и предложения! Введите свой номер телефона и Вы сможете узнать, а так же забронировать для себя выгодные условия покупки!</span></div>
        <form class="popup-form">
            <div class="input-group">
                <label for="i201">Телефон</label>
                <input type="text" class="input-phone" placeholder="+7 (___) ___-____" id="i201" name="user[phone]">
            </div>
            <div class="input-group">
                <label for="i202">Имя</label>
                <input type="text" placeholder="Иван Иванов" id="i202" name="user[name]">
            </div>
            <div class="input-group">
                <input type="submit" class="buttonGreen" value="Узнать стоимость квартир со скидкой">
            </div>
        </form>
        <div class="note">Предложение эксклюзивно. Кол-во квартир по акции ограниченно. Только сейчас доступны лучшие цены в этом году</div>
    </div>
</div>


<div id="form03" class="modalDialog">
    <div>
        <a href="#close" title="Close" class="close"></a>
        <div class="heading">Лучше один раз увидеть собственными глазами!
            <span>Запишитесь на просмотр квартир и экскурсию в любое удобное для вас время. Это абсолютно бесплатно и вас ни к чему не обзывает!</span></div>
        <form class="popup-form">
            <div class="input-group">
                <label for="i301">Телефон</label>
                <input type="text" class="input-phone" placeholder="+7 (___) ___-____" id="i301" name="user[phone]">
            </div>
            <div class="input-group">
                <label for="i302">Имя</label>
                <input type="text" placeholder="Иван Иванов" id="i302" name="user[name]">
            </div>
            <div class="input-group half-group">
                <label for="i304">День</label>
                <div class="select-style">
                    <select id="i304" name="user[day]">
                        <option value="m">Сегодня</option>
                        <option value="t">Завтра</option>
                    </select>
                </div>
            </div>
            <div class="input-group half-group">
                <label for="i305">Время</label>
                <div class="select-style">
                    <select id="i305" name="user[time]">
                        <option value="m">Утро</option>
                        <option value="d">День</option>
                        <option value="e">Вечер</option>
                        <option value="n">Ночь</option>
                    </select>
                </div>
            </div>
            <div class="clear"></div>
            <div class="input-group">
                <p>Наш менеджер свяжется с Вами для уточнения деталей</p>
            </div>
            <div class="input-group">
                <input type="submit" class="buttonGreen" value="Записаться на просмотр">
            </div>
        </form>
    </div>
</div>


<div id="form04" class="modalDialog">
    <div>
        <a href="#close" title="Close" class="close"></a>
        <div class="heading">Узнайте стоимость квартир со скидкой по нашему эксклюзивному предложению прямо сейчас!
            <span>Введите свой номер телефона и Вы сможете узнать, а так же забронировать для себя выгодные условия покупки!</span></div>
        <form class="popup-form">
            <div class="input-group">
                <label for="i401">Телефон</label>
                <input type="text" class="input-phone" placeholder="+7 (___) ___-____" id="i401" name="user[phone]">
            </div>
            <div class="input-group">
                <label for="i402">Имя</label>
                <input type="text" placeholder="Иван Иванов" id="i402" name="user[name]">
            </div>
            <div class="input-group">
                <input type="submit" class="buttonGreen" value="Узнать стоимость квартир со скидкой">
            </div>
        </form>
        <div class="form04 modalFooter">
            <img width="105" height="100" src="/bitrix/images/seotime/img/img01.png" title="" alt="" class="">
            <div class="txt">
                <p>— Предложение эксклюзивно.</p>
                <p>— Кол-во квартир по акции ограниченно.</p>
                <p>— Только сейчас доступны лучшие цены в этом году</p>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</div>


<div id="form05" class="modalDialog">
    <div>
        <div class="circle">
            <p>Ваш расчетный<br>ежемесячный платеж:</p>
            <p class="price">22 010 руб.</p>
            <p><strong>Но можно гораздо<br>лучше!</strong></p>
        </div>
        <a href="#close" title="Close" class="close"></a>
        <div class="heading">Хотите взять ипотеку по умному?
            <span>Получите лучшее предложения от 60 банков-партнеров с вероятностью одобрения 99%!</span></div>
        <form class="popup-form">
            <div class="input-group">
                <label for="i501">Телефон</label>
                <input type="text" class="input-phone" placeholder="+7 (___) ___-____" id="i501" name="user[phone]">
            </div>
            <div class="input-group">
                <input type="submit" class="buttonGreen" value="Получить лучшее условия по ипотеке">
            </div>
        </form>
        <div class="note">*Все данные конфиденциальны</div>
        <div class="form05 modalFooter">
            <div class="item">
                <img width="70" height="50" src="/bitrix/images/seotime/img/icon07.png" title="" alt="" class="">
                <p>Лучшая ставка! Банки соревнуются за вас</p>
            </div>
            <div class="item">
                <img width="70" height="50" src="/bitrix/images/seotime/img/icon08.png" title="" alt="" class="">
                <p>Без первоначального взноса</p>
            </div>
            <div class="item">
                <img width="70" height="50" src="/bitrix/images/seotime/img/icon09.png" title="" alt="" class="">
                <p>Ускоренное решение по двум документам</p>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</div>


<div id="form06" class="modalDialog">
    <div>
        <a href="#close" title="Close" class="close"></a>
        <div class="heading">Прямо сегодня вы получите самое выгодное предложение исходя из Ваших требований по недвижимости!
            <span>Кроме того, мы расскажем Вам про все "подводные камни" и ответим на все интересующие Вас вопросы</span></div>
        <form class="popup-form">
            <div class="input-group">
                <label for="i601">Телефон</label>
                <input type="text" class="input-phone" placeholder="+7 (___) ___-____" id="i601" name="user[phone]">
            </div>
            <div class="input-group">
                <input type="submit" class="buttonGreen" value="Получить самое лучшее предложение!">
            </div>
        </form>
    </div>
</div>

<!-- /new -->

<div class="popUpWindowOverlayImage" onclick="$('.popupFullScreen2').fadeOut();$('.popUpWindowOverlayImage').fadeOut();"></div>
<?
$this->__component->arResult["CACHED_TPL"] = @ob_get_contents();
  ob_get_clean();
?>
