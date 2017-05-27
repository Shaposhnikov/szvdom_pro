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
<h1 itemprop="name"><?=$arResult['NAME']?></h1>
    <?
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
    if (!empty($arResult["PROPERTIES"]["LOGO_DEVELOPER"]["VALUE"])) {
        $logoDev = CFile::GetFileArray($arResult["PROPERTIES"]["LOGO_DEVELOPER"]["VALUE"]); ?>
        <img width="228" height="60" src="<?= $logoDev["SRC"] ?>" title="<?= $arResult["PROPERTIES"]["BUILDER"]["VALUE"] ?>" alt="<?= $arResult["PROPERTIES"]["BUILDER"]["VALUE"] ?>" class="logoDev"/>
    <? } ?>

</div><div style="display: none;" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<span itemprop="price">Узнать цены</span>
<span itemprop="priceCurrency">RUB</span>
    </div>

<? $descr = strip_tags($description); echo "<meta itemprop='description' content='Описание: ".$descr."'/>";?>

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


<!--<div class="commercialElement">
	<span class="hLine"><span>#SEO#</span></span>
</div>-->
<!--<div style="padding: 15px 38px 15px;"><h2>#SEO#</h2></div>-->
<?//echo'<pre>';print_r($arResult);echo'</pre>';?>


#DYNAMIC#


<?if ($APPLICATION->GetCurPage() != $arResult['DETAIL_PAGE_URL'] . "zachet-zhilja/") {?>
<!-- <div class="ipoteka_calc"><a data-who="calculate_feedback" onclick="yaCounter21785827.reachGoal('ipoteka_click'); return true;" data-formsend="ipoteka_send"  class="showIt"></a></div> -->





<div class="new_ipoteka_calc">

    <h2>Ипотечный калькулятор</h2>
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
</div>


<div class="specblcs"></div>
<div class="specialAndBuying">
<!-- вынули specialBlockElement -->
<!-- вынули byingBlockElement -->
</div>
<div class="mortgageAndCalculator">
    <img src="/bitrix/templates/szvdom/images/ipoteka1.png" alt="Зачет жилья" title="Зачет жилья"/>

    <div class="innerMortgageAndCalculator">
        <p style="margin-bottom:10px;">Зачет жилья</p>
        <ul>
            <li><span>Продать свою квартиру и оплатить новую</span></li>
            <li><span>Платить в рассрочку, сделать ремонт, а затем продать свою старую квартиру</span></li>
            <li><span>Въехать в новую квартиру, а затем продать свою старую и рассчитаться за новую</span></li>
            <li><span>Взять ипотеку, въехать в новую квартиру, продать старую и расплатиться с кредитом</span></li>
        </ul>
        <a href="<?= $arResult['DETAIL_PAGE_URL']; ?>zachet-zhilja/" Style="display:inline-block; margin-top:15px;">Узнать подробности</a>
    </div>
    <div style="clear:both;"></div>
    <br/>

    <?/*<div class="calcul_block" id="calc_ankor">
        <div class="calcHead">
            <p>Расчет ипотеки</p>

            <div class="calcul_block_tit">Мы раскроем для вас секреты работы с ипотечными программами и рассрочками, о которых вам не говорили.
                Вы можете записаться на бесплатную консультацию ипотечного менеджера и получить ипотеку с вероятностью 99%! <a class="showIt" data-who="footer_feedback" style="color: #18D1F9;">Записаться</a></div>
        </div>
        <div class="calcul_block_main">
            <div class="ipotCalcArea Q W inline">
                <!--noindex-->
                <table class="inline" cellpadding="3" cellspacing="0">
                    <tbody>
                    <tr class="blueTextTd">
                        <td width="215">Стоимость</td>
                        <td width="215">Срок кредитования</td>
                        <td width="430" colspan="2">Первоначальный взнос</td>
                    </tr>
                    <tr>
                        <td style="padding-right: 20px"><input id="flatPrice" type="text" placeholder="2 000 000"><span class="calk_text">р.</span></td>
                        <td style="padding-right: 20px"><input id="yearsCount" type="text" placeholder="10"><span class="calk_text">лет</span></td>
                        <td style="padding-right: 20px"><input id="firstPay" type="text" placeholder="200 000"><span class="calk_text">р.</span><select id="yearPercent" class="none" style="display: none;">
                                <option selected="selected" value="11.5">11.5</option>
                            </select></td>
                        <td>
                            <div class="buttonGreen calcIpotBtn" style="height: 34px;line-height: 34px;width: 220px;">Рассчитать ипотеку</div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--/noindex-->
                <div style="clear: both"></div>
                <div class="calculator_result">
                    <div class="calculator_result_tit">Вы сможете платить по <span id="result_div">0</span> р. в месяц</div>
                    <input id="result" value="" type="hidden">

                </div>
            </div>

        </div>
        <div class="calcBottom">
            <div class="inText">
                    <span>
                        Расчет носит информационный характер и не является окончательным.
                    </span>
                <br>
                <span>ВОЗНИКЛИ ВОПРОСЫ? ПОЗВОНИТЕ!</span><br>Консультация и расчет платежей по кредиту: <span class="ya-elama-phone call_phone_1" style="font-size: 17px;">+7(812) 902-50-50</span> или <a data-who="footer_feedback" class="showIt">оставьте заявку</a>
            </div>

        </div>


        <!--<div class="calcBottom">
            <div class="inText">
                    <span>
                        Расчет носит информационный характер и не является окончательным.
                    </span>
                <br/>
                Обратитесь, пожалуйста, к специалистам ипотечного центра для расчета платежей по кредиту по телефону или <a onclick="$('.footer_feedback').css({'display':'block','top':'125px'});">оставьте заявку</a>.
            </div>

        </div>-->
    </div>*/?>
</div>
<?}?>
<div class="whatAreQuestion">
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


            <span class="ya-elama-phone call_phone_1">+7(812) 902-50-50</span> <a data-who="footer_feedback" onclick="yaCounter21785827.reachGoal('question_click'); return true;" data-formsend="question_send" class="showIt">оставить заявку</a></span>
    </p>
	
	<div class="QW_block_ph point_border showIt" onclick="yaCounter21785827.reachGoal('question_click'); return true;" data-formsend="question_send" data-who="footer_feedback" ></div>
	<div data-who="footer_feedback" class="showIt" style="background: url('/bitrix/templates/szvdom/images/contact_us4.png')no-repeat; cursor:pointer; width: 100px;height: 100px;position: absolute;display: inline-block;right: 26px;top: 40px;"></div>
	
</div>
<div style="clear: both;"></div>
<?
$APPLICATION->IncludeFile('photo.php');
?>
<?if (!empty($description)){?>
<div class="elementDesc mainPageContent">
    <div class="specialBlockElementTitle" style="padding: 0;">Описание</div>
            <div class="overview">
                <?= $description; ?>
            </div>
        </div>
<?}?>
<div class="popUpWindowOverlayImage" onclick="$('.popupFullScreen2').fadeOut();$('.popUpWindowOverlayImage').fadeOut();"></div>
<?
$this->__component->arResult["CACHED_TPL"] = @ob_get_contents();
  ob_get_clean();
?>
