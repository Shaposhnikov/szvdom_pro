<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetPageProperty("keywords", "недвижимость питер квартира купить база санкт петербург каталог цена сайт продажа спб покупка жилья стоимость спб");
$APPLICATION->SetPageProperty("description", "120 000 квартир в новостройках Санкт-Петербурга только от надежных застройщиков. Квартиры вторичного рынка жилья, коммерческая и загородная недвижимость на сайте \"Созвездие Недвижимости\"");
$APPLICATION->SetTitle("Квартиры в новостройках Санкт-Петербурга - «Созвездие Недвижимости»");
//$APPLICATION->AddHeadString('<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>', true);
?>  
    <br/>
    <h3 class="mainPageh3" style="margin-top: -25px;">Объекты на карте</h3>
<?


$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
if (CModule::IncludeModule("iblock")) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
			// $('#sliderTiny').tinycarousel();
        });
    </script>
    <?$arSelect = Array(
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "NAME",
        "CODE",
        "ACTIVE",
        "DETAIL_PAGE_URL",
        "PREVIEW_PICTURE",
        "PREVIEW_TEXT",
        "PREVIEW_PICTURE",
        "PROPERTY_REGION",
        "PROPERTY_LATITUDE",
        "PROPERTY_LONGITUDE",
        "PROPERTY_ADDRESS",
        "PROPERTY_SECOND_ID",
        "PROPERTY_SHOW_THIS_ON_MAIN",
        "PROPERTY_SHOW_ON_MAP"
    );
    $blockStr = "";
    $first = true;

    $arFilter = Array("IBLOCK_ID" => 1, "SECTION_ID" => 1);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while ($ob = $res->GetNextElement()) {
        $buf = $ob->GetFields();
        $blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $buf["PROPERTY_SECOND_ID_VALUE"] . "']");
        $imago = (string)$blocks[0]["avatar"];
        if (!empty($buf["PREVIEW_PICTURE"])) {
            $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
            $buf["PREVIEW_PICTURE"] = "" . $image["SRC"];
        } else {
            $buf["PREVIEW_PICTURE"] = "/include/images/" . $imago;
        }
        if ($buf["ACTIVE"] == "N") {
            $specTemp = true;
        } else {
            $specTemp = false;
        }
        if (strtolower($buf["PROPERTY_SHOW_ON_MAP_VALUE"]) != "нет") {
            $mapSimalarLabel[] = array(
                "Y" => (float)$buf ["PROPERTY_LONGITUDE_VALUE"],
                "X" => (float)$buf ["PROPERTY_LATITUDE_VALUE"],
                "NAME" => (string)$buf ["NAME"],
                "URL" => (string)$buf ["DETAIL_PAGE_URL"],
                "REGION" => (string)$buf ["PROPERTY_REGION_VALUE"],
                "ADDRESS" => (string)$buf ["PROPERTY_ADDRESS_VALUE"],
                "IMG" => (string)$buf["PREVIEW_PICTURE"],
                "SPEC_TEMP" => $specTemp
            );
        }
        if ($buf["PROPERTY_SHOW_THIS_ON_MAIN_VALUE"] == "да") {
            $bufProp = $ob->GetProperties($propSelect);
            $buf["PROPERTIES"] = $bufProp;

            $blockStr .= "<li>";
            if (!empty($buf["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"])) {
                $blockStr .= '<div class="redLabelMark">' . $buf["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"] . '</div>';
            }
            $blockStr .= '<a href="' . $buf["DETAIL_PAGE_URL"] . '"><img width="225" height="172" src="/thumb/225x172xcut' . $buf["PREVIEW_PICTURE"] . '" title="' . $buf["NAME"] . '" alt="' . $buf["NAME"] . '" /><a href="' . $buf["DETAIL_PAGE_URL"] . '" class="buildName">' . $buf["NAME"] . '</a><div class="buildText"><p style="color:#2579CB;">';
             echo "<!--";
  print_r($buf["PROPERTIES"]["ENDINGPERIOD"]); 
echo "-->";
            foreach ($buf["PROPERTIES"]["REGION"]["VALUE"] as $key => $subValue) {

                if ($key != (count($buf["PROPERTIES"]["REGION"]["VALUE"]) - 1)) {
                    $blockStr .= $subValue . ',';
                } else {
                    $blockStr .= $subValue;
                }
            }
            if (count($buf["PROPERTIES"]["REGION"]["VALUE"]) == 1) {
                $blockStr .= ' район';
            } else {
                $blockStr .= ' районы';
            }
            $blockStr .= '</p><p style="color:#2579CB;"><span class="subwayLabel inline_m"></span> ' . $buf["PROPERTIES"]["SUBWAYS"]["VALUE"][0] . '</p><p>' . $buf["PROPERTIES"]["ADDRESS"]["VALUE"] . '</p>';

            if ($buf["PROPERTIES"]["ENDINGPERIOD"]["VALUE"] != false) {
                if (count($buf["PROPERTIES"]["ENDINGPERIOD"]["VALUE"]) != 2) {
                    $blockStr .= '<p><span style="font-family: Bold;">Срок сдачи: </span>' . $buf["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0];
                    if (strtolower($buf["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0]) != "сдан") {
                        $blockStr .= "г.";
                    }
                    $blockStr .= '</p>';
                } else {
                    $blockStr .= '<p class="mini_on_ab"><span style="font-family: Bold;">Срок сдачи: </span> ';
                    if ($buf["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0] != $buf["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][1]) {
                        $blockStr .= $buf["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0] . ' - ' . $buf["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][1] . ' гг.';
                    } else {
                        $blockStr .= $buf["PROPERTIES"]["ENDINGPERIOD"]["VALUE"][0] . "г.";
                    }

                    $blockStr .= '</p>';
                }
            }
            $blockStr .= '</div><a href="' . $buf["DETAIL_PAGE_URL"] . '" class="pseudoButton">от <span>' . number_format($buf["PROPERTIES"]["FLATCOST"]["VALUE"][0], 0, ',', ' ') . '</span> Р</a></a></li>';
        }
    }
    ?>
    <script type="text/javascript">
        var myMap2;
        function init() {
            var myMap2 = new ymaps.Map("mapMain", {
                    center: [<?=$mapSimalarLabel[0]["X"]?>, <?=$mapSimalarLabel[0]["Y"]?>],
                    zoom: 9,
                    controls: ['smallMapDefaultSet']
                }),
                MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
                    '<div class="popover top">' +
                    '<a class="close" href="#"></a>' +
                    '<div class="arrow"></div>' +
                    '<div class="popover-inner">' +
                    '$[[options.contentLayout observeSize minWidth=280 maxWidth=400 maxHeight=350]]' +
                    '</div>' +
                    '</div>', {

                        build: function () {
                            this.constructor.superclass.build.call(this);

                            this._$element = $('.popover', this.getParentElement());

                            this.applyElementOffset();

                            this._$element.find('.close')
                                .on('click', $.proxy(this.onCloseClick, this));
                        },


                        clear: function () {
                            this._$element.find('.close')
                                .off('click');

                            this.constructor.superclass.clear.call(this);
                        },


                        onSublayoutSizeChange: function () {
                            MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);

                            if (!this._isElement(this._$element)) {
                                return;
                            }

                            this.applyElementOffset();

                            this.events.fire('shapechange');
                        },


                        applyElementOffset: function () {
                            this._$element.css({
                                left: -(this._$element[0].offsetWidth / 2),
                                top: -(this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight)
                            });
                        },


                        onCloseClick: function (e) {
                            e.preventDefault();

                            this.events.fire('userclose');
                        },


                        getShape: function () {
                            if (!this._isElement(this._$element)) {
                                return MyBalloonLayout.superclass.getShape.call(this);
                            }

                            var position = this._$element.position();

                            return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
                                [position.left, position.top], [
                                    position.left + this._$element[0].offsetWidth,
                                    position.top + this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight
                                ]
                            ]));
                        },

                        _isElement: function (element) {
                            return element && element[0] && element.find('.arrow')[0];
                        }
                    }),
                MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
                    '<div class="mainPageMapPopover">' +
                    '<img width="120" class="mainPageMapPopoverImg" src="$[properties.balloonContentSrc]" />' +
                    '<div class="popover-content"><span>$[properties.balloonContent]</span>' +
                    '<span>$[properties.balloonContent2]</span><br/>' +
                    '<div><a href="$[properties.balloonContentUrl]">Описание</a><a class="sec" href="$[properties.balloonContentUrl]tseny-na-kvartiry/">Цены</a><a class="sec" href="$[properties.balloonContentUrl]planirovki/">Планировки</a></div>' +
                    '</div></div>'
                ),
                MyBalloonContentLayout2 = ymaps.templateLayoutFactory.createClass(
                    '<div class="mainPageMapPopover">' +
                    '<div class="popover-content">' +
                    '<span style="font-size: 13px;padding-bottom: 5px;font-family: Bold;">$[properties.balloonContent]</span>' +
                    '<br/>' +
                    '<span style="font-size: 13px;padding-bottom: 5px;">+7(812) 902-50-50 </span>' +
                    '<br/>' +
                    '<a style="line-height: 25px; height: 25px;width: 205px;" data-who="footer_feedback" class="buttonGreen showIt" onclick="mapClick($(this));">ЗАКАЗАТЬ ЗВОНОК</a>' +
                    '</div></div>'
                );
            myMap2.geoObjects
                <?foreach ($mapSimalarLabel as $key => $value){
           
                //if ($key < 100){
                ?>
                .add(new ymaps.Placemark([<?=$value["X"]?>, <?=$value["Y"]?>],
                    {
                        balloonContent: '<?=$value["NAME"]?>',
                        balloonContent2: '<?if (!empty($value["ADDRESS"])){echo $value["ADDRESS"]."<br/>";}?><?=$value["REGION"]?>',
                        balloonContentSrc: '/thumb/120x0xcut<?=$value["IMG"]?>',
                        balloonContentUrl: '<?=$value["URL"]?>'
                    },
                    {
                        balloonShadow: true,
                        balloonLayout: MyBalloonLayout,
                        balloonContentLayout: <?=($value["SPEC_TEMP"] == true)?"MyBalloonContentLayout2":"MyBalloonContentLayout"?>,
                        balloonCloseButton: true,
                        balloonPanelMaxMapArea: 0,
                        hideIconOnBalloonOpen: false,
                        balloonOffset: [40, -70],
                        iconLayout: 'default#image',
                        iconImageHref: '/bitrix/templates/szvdom/images/mapLabel.png',
                        iconImageSize: [30, 42],
                        iconImageOffset: [-3, -42]
                    }
                ))
            <?if ($key == (count($mapSimalarLabel) - 1)){echo ";";}?>
            <?
            //}
            }?>
        }
        function mapClick(value) {
            var who = value.data('who');
            if (who == "popUpSelect") {
                tp = value.data('type');
                changeRightColumnPopUp(tp);
                if (tp !== "По метро") {
                    $('.popUpSelectInner #rightColumnPopUp').css('height', '660px');
                } else {
                    $('.popUpSelectInner #rightColumnPopUp').css('height', '798px');
                }
            }
            $('.' + who).fadeIn(500);
            $('.popUpWindowOverlay').css('display', 'block');
            var DH = $(document).height(), WH = $(window).height(), ST = $(window).scrollTop(), PH = $(this).outerHeight();
            if (WH < PH) {
                if (ST + WH > DH - 10) {
                    $('.feedbackWrap').css({bottom: '10px', top: ''});
                } else {
                    $('.feedbackWrap').css('top', 50 + ST);
                }
            } else {
                $('.feedbackWrap').css('top', 50 + ST);
            }
        }
    </script>
    <div id='mapMain' style="width: 1056px;height: 400px;">

<!-- Больше не грузим Yandex.Maps API сразу. Грузим только при клике -->
		<div id="yaMapLoadOnClick" style="position: relative; left: 0px; top: 0px; width: 100%; height: 100%; text-align: center; cursor: pointer;"><img src="/bitrix/templates/szvdom/images/tmp_map_31.gif"></div>
<script>
	$(document).ready(function(){
		$("#yaMapLoadOnClick").click(function(){
			var layer = $(this);
			layer.html("<br><br><br>Загружаем карту...");
			$.getScript('http://api-maps.yandex.ru/2.1/?lang=ru_RU', function() {
  			    ymaps.ready(function() {
					layer.hide();
					ymaps.ready(init);
			  });
			});
		});
	});
</script>

	</div>

<!--noindex-->
    <h3 class="mainPageh3">Интересные подборки</h3>
    <div class="specialsMainPage">
        <ul>

            <?$arSelect = Array("ID", "NAME", "PROPERTY_SHOW_ON_MAIN_PAGE", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PREVIEW_TEXT", "PROPERTY_FILTER_VAL");
            $arFilter = Array("IBLOCK_ID" => 2);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNextElement()) {
                $buf = $ob->GetFields();
                if ($buf["PROPERTY_SHOW_ON_MAIN_PAGE_VALUE"] == "да") {
                    if (!empty($buf["PREVIEW_PICTURE"])) {
                        $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
                        $buf["PREVIEW_PICTURE"] = "/thumb/225x352xcut" . $image["SRC"];
                    } else {
                        $buf["PREVIEW_PICTURE"] = "/bitrix/templates/szvdom/components/bitrix/catalog/szv/bitrix/catalog.section/.default/images/no_photo.png";
                    }?>
                    <li class="specialItemForSelect">
                        <a href="<?= $buf["DETAIL_PAGE_URL"] ?>">
                            <img width='225' height='352' src='<?= $buf["PREVIEW_PICTURE"]; ?>' alt='<?= $buf["NAME"]; ?>' title='<?= $buf["NAME"]; ?>'/>

                            <div class="labelForSelectList"><span><?= $buf["NAME"] ?></span></div>
                        </a>
                    </li>
                <?
                }
            } ?>
        </ul>
		<div style="padding-top: 15px; text-align: right;"><a href="javascript: void(0);" data-who="popUpSelect" data-type="По цене" class="showIt" style="font-size: 16px;">Посмотреть все подборки</a></div>
    </div>
    <div style="clear: both;"></div>
<!--/noindex-->

	<h3 class="mainPageh3" style="padding-bottom: 0px;">Спецпредложения</h3>
    <div class="buildMainPage" id="sliderTiny">

	<ul><?= $blockStr; ?></ul>
		<div style="clear: both;"></div>

        <!-- <a class="buttons prev" href="#"></a>


        <div class="viewport">
            <ul class="overview">

            </ul>
        </div>
        <a class="buttons next" href="#"></a> -->
		<div style="padding-top: 15px; text-align: right;"><a href="/akcii-i-skidki/" style="font-size: 16px;">Посмотреть все спецпредложения</a></div>

    </div>


    <div style="clear: both;"></div>


    <h3 class="mainPageh3" style="padding: 30px 38px 15px;">Аналитика</h3>
    <div class="newsMainPage">
        <ul>
            <?$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PREVIEW_TEXT", "ACTIVE_FROM", "PROPERTY_SHOW_THIS_ON_MAIN");
            $arFilter = Array("IBLOCK_ID" => 3, "SECTION_ID" => 76);
            $res = CIBlockElement::GetList(Array("active_from" => desc), $arFilter, false, array("nPageSize" => 4), $arSelect);
            while ($ob = $res->GetNextElement()) {
                $buf = $ob->GetFields();
                if (!empty($buf["PREVIEW_PICTURE"])) {
                    $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
                    $buf["PREVIEW_PICTURE"] = $image["SRC"];
                }?>
                <li>
                    <img src="/thumb/120x82xcut<?= $buf["PREVIEW_PICTURE"]; ?>" alt="<?= $buf["NAME"] ?>" title="<?= $buf["NAME"] ?>" width="120" height="82"/>

                    <p><?= $buf["ACTIVE_FROM"]; ?></p>
                    <a href="<?= $buf["DETAIL_PAGE_URL"] ?>"><?= $buf["NAME"] ?></a>
                </li>
            <?
            } ?>
        </ul>
        <a href="/analytica/" class="rightBlock">Вся аналитика</a>
    </div>



<br/>

    <h3 class="mainPageh3" style="padding: 30px 38px 15px;">Новости</h3>
    <div class="newsMainPage">
        <ul>
            <?$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PREVIEW_TEXT", "ACTIVE_FROM", "PROPERTY_SHOW_THIS_ON_MAIN");
            $arFilter = Array("IBLOCK_ID" => 3, "SECTION_ID" => 10);
            $res = CIBlockElement::GetList(Array("active_from" => desc), $arFilter, false, array("nPageSize" => 4), $arSelect);
            while ($ob = $res->GetNextElement()) {
                $buf = $ob->GetFields();
                if (!empty($buf["PREVIEW_PICTURE"])) {
                    $image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
                    $buf["PREVIEW_PICTURE"] = $image["SRC"];
                }?>
                <li>
                    <img src="/thumb/120x82xcut<?= $buf["PREVIEW_PICTURE"]; ?>" alt="<?= $buf["NAME"] ?>" title="<?= $buf["NAME"] ?>" width="120" height="82"/>

                    <p><?= $buf["ACTIVE_FROM"]; ?></p>
                    <a href="<?= $buf["DETAIL_PAGE_URL"] ?>"><?= $buf["NAME"] ?></a>
                </li>
            <?
            } ?>
        </ul>
        <a href="/novosti/" class="rightBlock">Все новости</a>
    </div>
<?
}
?><!--noindex-->
    <div class="ourPatners">
        <h3 class="mainPageh3" style="padding-left: 0; padding-top: 20px;">Наши партнеры</h3>
        <ul>
            <li>
                <a href="/vyborki/obekty-lsr/"><img src="http://dev.szvdom.ru/cdn/partner/1.jpg" title="ЛСР Недвижимость" alt="ЛСР Недвижимость"/></a>
            </li>
            <li>
                <a href="/vyborki/obekty-severnyy-gorod/"><img src="http://dev.szvdom.ru/cdn/partner/5.jpg" title="Северный город" alt="Северный город"/></a>
            </li>
            <li>
                <a href="/vyborki/obekty-lenstroytrest/"><img src="http://dev.szvdom.ru/cdn/partner/8.jpg" title="Ленстройтрест" alt="Ленстройтрест"/></a>
            </li>
            <li>
                <a href="/vyborki/obekty-petrostroy/"><img src="http://dev.szvdom.ru/cdn/partner/4.jpg" title="Петрострой" alt="Петрострой"/></a>
            </li>
            <li>
                <a href="/vyborki/obekty-7suns/"><img src="http://dev.szvdom.ru/cdn/partner/9.jpg" title="Лидер групп" alt="Лидер групп"/></a>
            </li>
            <li>
                <a href="/vyborki/obekty-prok/"><img src="http://dev.szvdom.ru/cdn/partner/10.jpg" title="ПРОК" alt="ПРОК"/></a>
            </li>
            <li>
                <img src="http://dev.szvdom.ru/cdn/partner/13.jpg" title="Петербургская недвижимость" alt="Петербургская недвижимость"/>
            </li>
            <li>
                <img src="http://dev.szvdom.ru/cdn/partner/14.jpg" title="Полис" alt="Полис"/>
            </li>
            <li>
                <a href="/vyborki/obekty-yuit/"><img src="http://dev.szvdom.ru/cdn/partner/11.jpg" title="ЮИТ" alt="ЮИТ"/></a>
            </li>
            <li>
                <img src="http://dev.szvdom.ru/cdn/partner/12.jpg" title="Легенда" alt="Легенда"/>
            </li>
        </ul>
        <div class="clear"></div>
        <div class="allPathers"><a class="greyLink" href="/kompaniya/partnery/">Все партнеры</a></div>
    </div><!--/noindex-->
    <div class="mainPageContent" style="padding-top: 33px;">
        <h1>Как выгодно приобрести недвижимость в новостройках Санкт-Петербурга?</h1>
                <div class="overview"> 
                    <p>Рынок недвижимости на сегодняшний день полон предложений от застройщиков — они выставляют на продажу различные варианты жилья. Проезжая по улицам города, можно увидеть, что появляется все больше строящихся объектов, а значит, и возможностей для покупки жилья. Предлагаются квартиры в различных местах города. Можно <a href='http://szvdom.ru/vyborki/kalininskiy-rayon/'>купить жилье в Калининском районе</a> или апартаменты <a href='http://szvdom.ru/vyborki/primorskiy-rayon/'>в Приморском районе</a>.</p>
<p>Конечно, если вы хотите приобрести недвижимость, то задумываетесь о выборе оптимального варианта — первичный рынок или «вторичка»? Готовая квартира или строящийся объект? Нужно сделать это с максимальной выгодой, при этом получить действительно хороший вариант. Ведь покупка недвижимости в Питере, будь то квартира или комната, требует значительных финансовых вложений. Приобрести жилье многие из нас могут лишь один раз в жизни, а потому сохранность денег в этом случае — один из важнейших вопросов.</p>
<h2>Как купить квартиру в Санкт-Петербурге?</h2>
<p>Выбирая жилье от застройщиков, нужно решить, каковы ваши требования к нему. Предпочитаемые районы города, количество комнат, планировка, максимально возможная стоимость, этажность и прочие «мелочи», которые впоследствии могут оказаться существенными. Обязательно стоит определить, какие застройщики пользуются доверием в этом городе.</p>
<p>Когда главные требования выделены, можно изучать предложения на рынке недвижимости, читать отзывы в интернете, консультироваться со знакомыми и друзьями, имеющими опыт приобретения жилья в новостройках.</p>
<p>Можно поступить гораздо проще — прийти в компанию «Созвездие Недвижимости». У нас вы абсолютно бесплатно получите консультацию о выборе предложений от застройщиков. Наши специалисты регулярно обновляют базу недвижимости Санкт-Петербурга, ведут каталог с актуальными ценами. Мы знаем все о новостройках Северной столицы, а потому обратиться к нам — значит получить помощь настоящих профессионалов.</p>
<p>Продажа недвижимости в СПб — это основное направление работы компании, на сайте представлена полная информация о строящихся в городе объектах, надежности застройщиков, темпах строительства, стоимости и прочем.</p>
<h2>Условия покупки и стоимость жилья в СПб</h2>
<p>Прежде чем приобрести квартиру в строящемся доме, нужно посетить приглянувшийся объект, оценить стадию строительства, проанализировать, что находится поблизости, каковы транспортная доступность, инфраструктура, перспективы развития.</p>
<p>Для этого можно позвонить каждому из застройщиков, согласовать дату и время посещения, узнать, что нужно для того, чтобы пройти на объект. Это достаточно трудоемкая работа, понадобится много времени и сил.</p>
<p>А можно обратиться в нашу компанию. Мы организуем поездку сразу на несколько объектов в один день. На служебном автомобиле компании вы в сопровождении сотрудника приедете на стройку, сможете посмотреть жилье, узнать, каковы условия продажи в конкретной строительной организации.</p>
<p>После выбора квартиры встает вопрос о юридической стороне вопроса. Правильно ли составлен договор? Безопасна ли эта покупка? Какие документы должен предоставить застройщик? Лучше взять рассрочку или ипотеку?</p>
<p>Конечно, можно нанять квалифицированного юриста, который проконсультирует вас по этим вопросам. Однако вам придется заплатить ему внушительную сумму. Есть вариант выгоднее — обратиться к нам. Мы совершенно бесплатно расскажем обо всех нюансах покупки квартиры в новостройке.</p>
<p>Более того, мы предлагаем полное юридическое сопровождение сделки: специалист будет с вами на всех этапах покупки. И это тоже бесплатно.</p>
<p>Но почему? Любые агентства недвижимости берут за такие услуги деньги. Где здесь подвох, думаете вы? </p>
<p>У нас нет подвохов — все честно и прозрачно. Все дело в том, что у нас широкая партнерская сеть и действительно большой объем продаваемых помещений. Мы заключаем с застройщиками партнерский договор, на основании которого получаем процент от продажи каждого объекта. Стоимость для клиента при этом не увеличивается. Это действительно выгодное предложение!</p>
<p>Мы гарантируем, что стоимость квартиры, купленной с нашей помощью, ничуть не выше, чем при заключении договора непосредственно с застройщиком! Позвоните нам и убедитесь в этом прямо сейчас! С нами купить квартиру в Санкт-Петербурге можно действительно выгодно!</p>
        </div> 

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#scrollbarY').tinyscrollbar({wheel: 40, scroll: true});
        });
    </script>
<?$APPLICATION->SetTitle("Квартиры в новостройках Санкт-Петербурга - «Созвездие Недвижимости»");?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>