<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();    

	$imageArray = array();
    $arResult= $arParams["ALL"];

	// $APPLICATION->AddHeadString('<!--noindex--><script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script><!--/noindex-->', true);
	$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");

	$blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $arResult["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
	$region = $xml->xpath("/Ads/Regions/Region[@id='" . $blocks[0]["region"] . "']");
	$roomType = $xml->xpath("/Ads/RoomTypes/RoomType");
	$subwayBlock = $xml->xpath("/Ads/BlockSubways/BlockSubway[@blockid='" . $arResult["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
	$subway = $xml->xpath("/Ads/Subways/Subway[@id='" . $subwayBlock[0]["subwayid"] . "']");
	$rLine = $xml->xpath("/Ads/Buildings/Building[@blockid='" . $arResult["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
	$blockidall = $xml->xpath("/Ads/Apartments/Apartment[@blockid='" . $arResult["PROPERTIES"]["SECOND_ID"]["VALUE"]. "']");

	if (!is_null($blocks[0]["latitude"])) {
	    $shir = (float)$blocks[0]["latitude"];
	} else {
	    $shir = $arResult["PROPERTIES"]["LATITUDE"]["VALUE"];
	}
	if (!is_null($blocks[0]["longitude"])) {
	    $dol = (float)$blocks[0]["longitude"];
	} else {
	    $dol = $arResult["PROPERTIES"]["LONGITUDE"]["VALUE"];
	}
	$mapLabel = array("X" => $dol, "Y" => $shir, "NAME" => $arResult["NAME"]);
    foreach ($arResult["PROPERTIES"]["MULTI_IMAGES"]["VALUE"] as $key => $value) {
        $Image = CFile::GetFileArray($value);
        $imageArray[] = array("SRC" => $Image["SRC"], "DESCRIPTION" => $arResult["PROPERTIES"]["DESCRIPTION_MULTI_IMAGES"]["VALUE"][$key]);
    }
    ?>    <div class="objectHead">
        <div class="objectHeadFotoGroup">
            <? if (!empty($imageArray)) { ?>
                <div class="fotorama" data-nav="thumbs"
                     data-width="520"
                     data-height="330"
                     data-minwidth="520"
                     data-maxwidth="520"
                     data-minheight="330"
                     data-maxheight="330"
                     data-allowfullscreen="true"
                     data-transition="crossfade"
                     data-keyboard="true"
                     data-arrows="true"
                     data-click="true"
                     data-swipe="false"
                     data-fit="cover"
                    >
                    <? foreach ($imageArray as $value) {
                        ?>
                        <a href="<?= $value["SRC"]; ?>"> <img src="<?= $value["SRC"]; ?>" title="<?= $value["DESCRIPTION"]; ?>" alt="<?= $value["DESCRIPTION"]; ?>" width="103" height="65"/></a>
                    <? } ?>
                </div>
            <? } else {
                $imger = (string)$blocks[0]["avatar"];
                ?>
                <img src="/include/images/<?= $imger; ?>" title="<?= $value["DESCRIPTION"]; ?>" alt="<?= $value["DESCRIPTION"]; ?>" width="520" height="400"/>
                <?
            } ?>
            <? if (!empty($arResult["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"])) { ?>
                <div class="redLabelMark"><?= $arResult["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"]; ?></div>
            <?
            } ?>
<!-- Генерация скрипта карты -->

			<? //if (!empty($mapLabel)) { ?>
            <!--noindex--><script type="text/javascript">
                $(document).ready(function(){
                    $('#toggle2 a').click(function(){
                        $('#togglezhkmap a').trigger('click');
                    })
                    $('.mapHead .buttonGreen').click(function(){
                        $('.mapWindow').fadeOut(100);
                        $('.mapWindowOverlay').fadeOut(100);
                        $('#togglezhkmap').data('status','close');
                    });
                });
				  $.getScript('http://api-maps.yandex.ru/2.1/?lang=ru_RU', function() {
				// ymaps.ready(function() {
				    ymaps.ready(init);

				// });
				});
                function init() {
                    var myMap;

                    $('#togglezhkmap').bind({
                        click: function () {
                            if ($(this).data('map') == "empty") {
								//
 var myMap = new ymaps.Map("specMap", {
                                            center: [<?=$mapLabel["Y"]?>, <?=$mapLabel["X"]?>],
                                            zoom: 15,
                                            controls: ['smallMapDefaultSet']
                                        },
                                        {autoFitToViewport: 'always'}),
                                    myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
                    hintContent: '<?=$mapLabel["NAME"]?>'
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: '/bitrix/templates/szvdom/images/markII.png',
                    iconImageSize: [90, 67],
                    iconImageOffset: [-3, -42]
                });

myMap.geoObjects.add(myPlacemark);

                                $(this).data('map', "create");
                                $(this).data('status', "open");
                                $('.mapWindow ').fadeIn(500);
                                $('.mapWindowOverlay').css('display', 'block');

                            } else {
                                if ($(this).data('status') == "close") {
                                    $('.mapWindow ').fadeIn(500);
                                    $('.mapWindowOverlay').css('display', 'block');
                                    $(this).data('status', "open");
                                } else {
                                    $('.mapWindow ').fadeOut(500);
                                    $('.mapWindowOverlay').css('display', 'none');
                                    $(this).data('status', "close");
                                }
                            }
                        }
                    });


                }
            </script><!--/noindex-->





			<div id="togglezhkmap" data-status="close" data-map="empty" style=" margin-left: -38px; margin-bottom: 25px;background-image:none;height:auto;" class="openMap"><a href="javascript:void(0)" class=" clickPiece allObjects">смотреть на карте</a></div>
<!-- вызов модального окна-->
			<div class="mapWindow" style="top: 50px;/* margin-left: -38px;*/position:fixed;">
                <div class="mapHead">Бесплатная консультация и подбор жилья:  +7(812) 902-50-50 <a data-who="footer_feedback" class="buttonGreen showIt">ЗАКАЗАТЬ ЗВОНОК</a> </div>
                <div class="closeMapPopUp" onclick="$('.mapWindow').fadeOut(500);$('.mapWindowOverlay').fadeOut(500);$('#togglezhkmap').data('status','close');$('#toggle2').data('status','close');"></div>
                <div class="mapkBody">
                    <div id="specMap" class="popUpMap"></div>
                </div>
            </div>
<div class="mapWindowOverlay" onclick="$('.mapWindow').fadeOut(500);$(this).fadeOut(500);$('#togglezhkmap').data('status','close');$('#toggle2').data('status','close');"></div>
<!-- конец вызова модального окна -->
        </div>
		<div class="objectHeadMapPlace2 objectHeadMapPlace3">

<div class="objectPropertiesRightSide2">
<div class="commercialElement">
    <span class="hLine">ВСЕГДА <span class="bigTexton">0<span style="font-size: 16px;">%</span></span> <span>комиссии</span> на новостройки</span>
</div>
<!-- код карты -->
<!-- вставка параметров (район, метро...) -->
	<table>
                <tbody>
                <tr>
                    <td width="120">Район :</td>
                    <td><?
                        if (!empty($arResult["PROPERTIES"]["REGION"]["VALUE"])) {
                            $str = "";
                            foreach ($arResult["PROPERTIES"]["REGION"]["VALUE"] as $key => $value) {
                                if ($key != (count($arResult["PROPERTIES"]["REGION"]["VALUE"]) - 1)) {
                                    $str .= $value . ", ";
                                } else {
                                    $str .= $value;
                                }

                            }
							//echo  $str;
							// подбор url районов
switch ($str) {
    case 'Невский':
	echo "<a href='/vyborki/nevskiy-rayon/'>$str</a>";
        break;
    case 'Красногвардейский':
	echo "<a href='/vyborki/krasnogvardeyskiy-rayon/'>$str</a>";
        break;
    case 'Петроградский':
	echo "<a href='/vyborki/petrogradskiy-rayon/'>$str</a>";
        break;
    case 'Кировский':
	echo "<a href='/vyborki/kirovskiy-rayon/'>$str</a>";
        break;
    case 'Приморский':
	echo "<a href='/vyborki/primorskiy-rayon/'>$str</a>";
        break;
    case 'Фрунзенский':
	echo "<a href='/vyborki/frunzenskiy-rayon/'>$str</a>";
        break;
    case 'Калининский':
	echo "<a href='/vyborki/kalininskiy-rayon/'>$str</a>";
        break;
    case 'Василеостровский':
	echo "<a href='/vyborki/vasileostrovskiy-rayon/'>$str</a>";
        break;
    case 'Красносельский':
	echo "<a href='/vyborki/krasnoselskiy-rayon/'>$str</a>";
        break;
    case 'Московский':
	echo "<a href='/vyborki/moskovskiy-rayon/'>$str</a>";
        break;
    case 'Выборгский':
	echo "<a href='/vyborki/vyborgskiy-rayon/'>$str</a>";
        break;
    case 'Тосненский':
	echo "<a href='/vyborki/tosnenskiy-rayon/'>$str</a>";
        break;
    case 'Сертолово':
	echo "<a href='/vyborki/rayon-sertolovo/'>$str</a>";
        break;
    case 'Всеволожский':
	echo "<a href='/vyborki/vsevolozhskiy-rayon/'>$str</a>";
        break;
    case 'Курортный':
	echo "<a href='/vyborki/kurortnyy-rayon/'>$str</a>";
        break;
    case 'Адмиралтейский':
	echo "<a href='/vyborki/admiralteyskiy-rayon/'>$str</a>";
        break;
    case 'Центральный':
	echo "<a href='/vyborki/tsentralnyy-rayon/'>$str</a>";
        break;
    case 'Гатчинский':
	echo "<a href='/vyborki/gatchinskiy-rayon/'>$str</a>";
        break;
    case 'Колпинский':
	echo "<a href='/vyborki/kolpinskiy-rayon/'>$str</a>";
        break;
    case 'Приозерский':
	echo "<a href='/vyborki/priozerskiy-rayon/'>$str</a>";
        break;
    case 'Кронштадский':
	echo "<a href='/vyborki/kronshtadskiy-rayon/'>$str</a>";
        break;
    case 'Петродворцовый':
	echo "<a href='/vyborki/petrodvortsovyy-rayon/'>$str</a>";
        break;

    default:
      echo $str;
}

							// конец подбора районов
                        } else {
                            echo $region[0]["name"];
                        } ?></td>
                </tr>
                <tr>
                    <td>Улица :</td>
                    <td><?= (!empty($arResult["PROPERTIES"]["ADDRESS"]["VALUE"])) ? $arResult["PROPERTIES"]["ADDRESS"]["VALUE"] : $blocks[0]["address"] ?></td>
                </tr>
                <tr>
                    <td>Метро :</td>
                    <td><? if (!empty($arResult["PROPERTIES"]["SUBWAYS"]["VALUE"])) {
                            $str = "";
                            foreach ($arResult["PROPERTIES"]["SUBWAYS"]["VALUE"] as $key => $value) {
                                if ($key != (count($arResult["PROPERTIES"]["SUBWAYS"]["VALUE"]) - 1)) {
                                    $str .= $value . ", ";
                                } else {
                                    $str .= $value;
                                }

                            }
							//echo $str;
switch ($str) {
case 'Академическая': echo "<a href='/vyborki/akademicheskaya/'>Академическая</a>"; break;
case 'Ладожская': echo "<a href='/vyborki/metro-ladozhskaya/'>Ладожская</a>"; break;
case 'Лесная': echo "<a href='/vyborki/metro-lesnaya/'>Лесная</a>"; break;
case 'Международная': echo "<a href='/vyborki/metro-mezhdunarodnaya/'>Международная</a>"; break;
case 'Гражданский проспект': echo "<a href='/vyborki/metro-grazhdanskiy-prospekt/'>Гражданский проспект</a>"; break;
case 'Автово': echo "<a href='/vyborki/metro-avtovo/'>Автово</a>"; break;
case 'Дыбенко': echo "<a href='/vyborki/metro-dybenko/'>Дыбенко</a>"; break;
case 'Удельная': echo "<a href='/vyborki/metro-udelnaya/'>Удельная</a>"; break;
case 'Нарвская': echo "<a href='/vyborki/metro-narvskaya/'>Нарвская</a>"; break;
case 'Новочеркасская': echo "<a href='/vyborki/metro-novocherkasskaya/'>Новочеркасская</a>"; break;
case 'Черная речка': echo "<a href='/vyborki/metro-chernaya-rechka/'>Черная речка</a>"; break;
case 'Электросила': echo "<a href='/vyborki/metro-elektrosila/'>Электросила</a>"; break;
case 'Фрунзенская': echo "<a href='/vyborki/metro-frunzenskaya/'>Фрунзенская</a>"; break;
case 'Приморская': echo "<a href='/vyborki/metro-primorskaya/'>Приморская</a>"; break;
case 'Проспект Ветеранов': echo "<a href='/vyborki/metro-prospekt-veteranov/'>Проспект Ветеранов</a>"; break;
case 'Проспект Славы': echo "<a href='/vyborki/metro-prospekt-slavy/'>Проспект Славы</a>"; break;
case 'Старая Деревня': echo "<a href='/vyborki/metro-staraya-derevnya/'>Старая Деревня</a>"; break;
case 'Рыбацкое': echo "<a href='/vyborki/metro-rybatskoe/'>Рыбацкое</a>"; break;
case 'Купчино': echo "<a href='/vyborki/metro-kupchino/'>Купчино</a>"; break;
case 'Ленинский проспект': echo "<a href='/vyborki/metro-leninskiy-prospekt/'>Ленинский проспект</a>"; break;
case 'Комендантский проспект': echo "<a href='/vyborki/metro-komendantskiy-prospekt/'>Комендантский проспект</a>"; break;
case 'Звездная': echo "<a href='/vyborki/metro-zvezdnaya/'>Звездная</a>"; break;
case 'Василеостровская': echo "<a href='/vyborki/metro-vasileostrovskaya/'>Василеостровская</a>"; break;
case 'Девяткино': echo "<a href='/vyborki/metro-devyatkino/'>Девяткино</a>"; break;
case 'Ломоносовская': echo "<a href='/vyborki/metro-lomonosovskaya/'>Ломоносовская</a>"; break;
case 'Московская': echo "<a href='/vyborki/metro-moskovskaya/'>Московская</a>"; break;
case 'Проспект Большевиков': echo "<a href='/vyborki/metro-prospekt-bolshevikov/'>Проспект Большевиков</a>"; break;
case 'Проспект Просвещения': echo "<a href='/vyborki/metro-prospekt-prosveshcheniya/'>Проспект Просвещения</a>"; break;
case 'Пролетарская': echo "<a href='/vyborki/metro-proletarskaya/'>Пролетарская</a>"; break;
case 'Парнас': echo "<a href='/vyborki/metro-parnas/'>Парнас</a>"; break;
case 'Озерки': echo "<a href='/vyborki/metro-ozerki/'>Озерки</a>"; break;
case 'Парк Победы': echo "<a href='/vyborki/metro-park-pobedy/'>Парк Победы</a>"; break;
case 'Академическая': echo "<a href='/vyborki/metro-akademicheskaya/'>Академическая</a>"; break;
case 'Елизаровская': echo "<a href='/vyborki/metro-elizarovskaya/'>Елизаровская</a>"; break;
case 'Площадь Мужества': echo "<a href='/vyborki/metro-ploshchad-muzhestva/'>Площадь Мужества</a>"; break;
case 'Площадь Восстания': echo "<a href='/vyborki/metro-ploshchad-vosstaniya/'>Площадь Восстания</a>"; break;
case 'Площадь Ленина': echo "<a href='/vyborki/metro-ploshchad-lenina/'>Площадь Ленина</a>"; break;
case 'Чернышевская': echo "<a href='/vyborki/metro-chernyshevskaya/'>Чернышевская</a>"; break;
case 'Балтийская': echo "<a href='/vyborki/metro-baltiyskaya/'>Балтийская</a>"; break;
case 'Пионерская': echo "<a href='/vyborki/metro-pionerskaya/'>Пионерская</a>"; break;
case 'Горьковская': echo "<a href='/vyborki/metro-gorkovskaya/'>Горьковская</a>"; break;
case 'Московские ворота': echo "<a href='/vyborki/metro-moskovskie-vorota/'>Московские ворота</a>"; break;
case 'Крестовский остров': echo "<a href='/vyborki/metro-krestovskiy-ostrov/'>Крестовский остров</a>"; break;
case 'Обухово': echo "<a href='/vyborki/metro-obukhovo/'>Обухово</a>"; break;
case 'Площадь Александра Невского': echo "<a href='/vyborki/metro-ploshchad-aleksandra-nevskogo/'>Площадь Александра Невского</a>"; break;
case 'Петроградская': echo "<a href='/vyborki/metro-petrogradskaya/'>Петроградская</a>"; break;
case 'Политехническая': echo "<a href='/vyborki/metro-politekhnicheskaya/'>Политехническая</a>"; break;
case 'Адмиралтейская': echo "<a href='/vyborki/metro-admiralteyskaya/'>Адмиралтейская</a>"; break;
case 'Балканская': echo "<a href='/vyborki/metro-balkanskaya/'>Балканская</a>"; break;
case 'Бухарестская': echo "<a href='/vyborki/metro-bukharestskaya/'>Бухарестская</a>"; break;
case 'Владимирская': echo "<a href='/vyborki/metro-vladimirskaya/'>Владимирская</a>"; break;
case 'Волковская': echo "<a href='/vyborki/metro-volkovskaya/'>Волковская</a>"; break;
case 'Выборгская': echo "<a href='/vyborki/metro-vyborgskaya/'>Выборгская</a>"; break;
case 'Гостинный двор': echo "<a href='/vyborki/metro-gostinnyy-dvor/'>Гостинный двор</a>"; break;
case 'Достоевская': echo "<a href='/vyborki/metro-dostoevskaya/'>Достоевская</a>"; break;
case 'Дунайский проспект': echo "<a href='/vyborki/metro-dunayskiy-prospekt/'>Дунайский проспект</a>"; break;
case 'Звенигородская': echo "<a href='/vyborki/metro-zvenigorodskaya/'>Звенигородская</a>"; break;
case 'Кировский завод': echo "<a href='/vyborki/metro-kirovskiy-zavod/'>Кировский завод</a>"; break;
case 'Маяковская': echo "<a href='/vyborki/metro-mayakovskaya/'>Маяковская</a>"; break;
case 'Невский проспект': echo "<a href='/vyborki/metro-nevskiy-prospekt/'>Невский проспект</a>"; break;
case 'Пушкинская': echo "<a href='/vyborki/metro-pushkinskaya/'>Пушкинская</a>"; break;
case 'Садовая': echo "<a href='/vyborki/metro-sadovaya/'>Садовая</a>"; break;
case 'Сенная площадь': echo "<a href='/vyborki/metro-sennaya-ploshchad/'>Сенная площадь</a>"; break;
case 'Спасская': echo "<a href='/vyborki/metro-spasskaya/'>Спасская</a>"; break;
case 'Спортивная': echo "<a href='/vyborki/metro-sportivnaya/'>Спортивная</a>"; break;
case 'Технологический институт': echo "<a href='/vyborki/metro-tekhnologicheskiy-institut/'>Технологический институт</a>"; break;
case 'Чкаловская': echo "<a href='/vyborki/metro-chkalovskaya/'>Чкаловская</a>"; break;
case 'Улица Дыбенко': echo "<a href='/vyborki/metro-dybenko/'>Улица Дыбенко</a>"; break;



   default:
      echo $str;
}

                        } else {
                            echo $subway[0]["name"];
                        } ?></td>
                </tr>


                <? if (!empty($arResult["PROPERTIES"]["LINE"]["VALUE"])) {
                    $str = "<tr>";
                    $str .= "<td>Срок сдачи :</td>";
                    $str .= "<td><div class='ulwrap'><ul class='corpus'>";
                    foreach ($arResult["PROPERTIES"]["LINE"]["VALUE"] as $key => $value) {
                        $str .= "<li>" . $value . "</li>";
                    }
							$str .= "</ul></div></td>";
                    $str .= "</tr>";
                    echo $str;
                } elseif (!empty($rLine)) {
                    foreach ($rLine as $value) {
                        $ar_donnn[] = (string)$rLine[0]["line"];
                    }
                    $arLine = array_unique($ar_donnn);
                    $str = "<tr>";
                    $str .= "<td>Срок сдачи :</td>";
                    $str .= "<td>";
                    foreach ($arLine as $key => $value) {
                        if ($key != (count($arResult["PROPERTIES"]["LINE"]["VALUE"]) - 1)) {
							$str .= $value . ", ";
                        } else {
                            $str .= $value;
                        }

                    }
                    $str .= "</td>";
                    $str .= "</tr>";
                    echo $str;
                } ?>

                <? if (!empty($arResult["PROPERTIES"]["PATH_DESCRIPTION"]["VALUE"])) {
                    ?>
                    <tr>
                        <td>Удалённость</td>
                        <td><?= $arResult["PROPERTIES"]["PATH_DESCRIPTION"]["VALUE"]; ?></td>
                    </tr>
                    <?
                } ?>
                </tbody>
            </table>
			<!-- / вставка параметров (район, метро...) -->

<!-- _new -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=cyrillic" rel="stylesheet">
<link href="/bitrix/images/seotime/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/bitrix/images/seotime/js/seotime_forms.js"></script>
<!-- /new -->


<!-- вставка КАК КУПИТЬ -->
<div class="best-conditions">
    <div class="heading">Сейчас доступны выгодные условия покупки:</div>
    <table>
      <tbody>
        <tr>
          <td width="50%">
			  <img src="/bitrix/images/seotime/img/icon01.svg" alt="">
            <p>Ипотека с лучшими условиями от ведущих банков!</p>
          </td>
          <td width="50%">
            <img src="/bitrix/images/seotime/img/icon02.svg" alt="">
            <p>Первый взнос по ипотеке — 0%</p>
          </td>
        </tr>
        <tr>
          <td width="50%">
            <img src="/bitrix/images/seotime/img/icon04.svg" alt="">
            <p>Используйте материнский капитал</p>
          </td>
          <td width="50%">
            <img src="/bitrix/images/seotime/img/icon03.svg" alt="">
            <p>Рассрочка без % от застройщика!</p>
          </td>
        </tr>
      </tbody>
    </table>
    <a href="#form01" class="buttonGreen">Получить консультацию по одной из программ</a>
  </div>
<!-- /вставка КАК КУПИТЬ -->


		</div><!-- objectPropertiesRightSide -->
    </div><!-- Конец дива бывшего блока карты на районе-->



<!-- here was anther corpusa -->

    <div class="propblcs"></div>
<!-- op2 -->
    <div class="objectProperties objectProperties2">
  <div class="objectPropertiesRightSide">                         
    <div class="heading">В комплексе:</div>
    <div class="overview">
      <ul>
        <li>Европейские планировки </li>
        <li>Закрытый, охраняемый двор</li>
        <li>Невский район. Прописка городская</li>
        <li>Единое социальное окружение</li>
        <li>Высокотехнологичный современный проект</li>
        <li>Wi-Fi по всей территории комплекса</li>
      </ul>
    </div>
  </div>
  <div class="objectPropertiesLeftSide">
    <img src="/bitrix/images/seotime/img/icon05.svg" alt="">
    <div class="available">Пока еще есть в наличии</div>
    <div class="heading">Квартиры от 3,7 млн руб.<span>C "белой" отделкой в подарок!</span></div>
  </div>
</div>
	<!-- /op2 -->

<!-- op3 -->
<div class="objectProperties objectProperties3">
  <div class="h1 text-center">Только в этом месяце весенняя распродажа<br>квартир в ЖК Legenda по лучшим ценам в этом году!</div>
  <div class="objectPropertiesRightSide">                         
    <div class="available">Эксклюзив</div>
    <div class="heading">Скидки от 400 тыс.<br>до 1,8 млн рублей!<span>на покупку квартир<br>в этом комплексе</span></div>
    <a href="javascript:void();" class="buttonGreen buttonBlue">Узнать подробности</a>
  </div>
  <div class="objectPropertiesLeftSide">
      <div class="available green">спецпредложение марта</div>
    <div class="heading">0% первоначальный<br>взнос по ипотеке</div>
	  <p> Сверхвыгодное предложение<br>по ипотеке в марте!<br>Действуют специальные программы!<br/><br/><br/><br/></p>
  </div>
</div>

	<!-- /op3 -->

<!-- review -->
<div class="reviewBlock">
  <a href="#form03" class="buttonGreen">Записаться на просмотр квартир в шоу-руме</a>
  <p>Торопитесь, количество квартир по спецпредложению ограничено <strong>С 18 января на этот ЖК открыта горячая линия</strong></p>
  <p class="phone">+7 (812) 426-70-59</p>
  <p class="note">принимаем звонки до 22:00 вечера</p>
</div>
	<!-- /review -->

    </div>



<!-- block another korpusa -->

<!-- /block another korpusa -->




    <?

foreach($rLine as $item) {
	$id = (string)$item[0]['id'];
	$corp = (string)$item[0]['corp'];
	$floors = (string)$item[0]['floors'];
	$endingperiod = (string)$item[0]['endingperiod'];
	$new_building[$id] = array("corp" => $corp, "floors" => $floors, "endingperiod" => $endingperiod);
}

$json = json_encode($blockidall);
$arrayXml = json_decode($json,TRUE);
$json2 = json_encode($blocks);
$arrayXml2 = json_decode($json2,TRUE);
foreach ($arrayXml as $key => $value) {
	if ($value["@attributes"]["rooms"] == 25){
		continue;
	}
	$blockIdDone[] = $value["@attributes"];
}
$ourBlock = $arrayXml2[0]["@attributes"];

$skitchenArray = array();
$squareArray = array();
$pricesArray = array();
$arResult["BLOCK"] = $ourBlock;
foreach ($blockIdDone as $key => $value) {
	foreach ($roomType as $tkey => $type) {
		if ($value["rooms"] == (string)$type[0]["id"]){
			$blockIdDone[$key]["roomtype"] = (string)$type[0]["name"];
		}
	}
	$b_id = (string)$value['buildingid'];
	$blockIdDone[$key]['endingperiod'] = $new_building[$b_id]['endingperiod'];
	$blockIdDone[$key]['corp'] = $new_building[$b_id]['corp'];
	$blockIdDone[$key]['floors'] = $new_building[$b_id]['floors'];
	$skitchenArray[] = $value["skitchen"];
	$squareArray[] = $value["stotal"];
	$pricesArray[] = $value["baseflatcost"];
}
if (!empty($arParams["ALL"]["ID"])){
    $arFilter = Array("IBLOCK_ID"=> 6, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","PROPERTY_BUILD" => $arParams["ALL"]["ID"]);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    $atFormat = array();
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $prop = $ob->GetProperties();
        $atFormat = array(
            "id" => $prop["ID_FOR_REAL"]["VALUE"],
            "stotal" => $prop["SQUARE"]["VALUE"],
            "rooms" => $prop["ROOM_AMOUNT"]["VALUE"],
            "skitchen" => $prop["SQUARE_KITCHEN"]["VALUE"],
            "baseflatcost" => $prop["PRICE"]["VALUE"],
            "corp" => $prop["BUILD_PART"]["VALUE"],
            "sbalcony" => $prop["SQUARE_BALCONY"]["VALUE"],
            "scorridor" => $prop["SQUARE_HALL"]["VALUE"],
            "cwatercloset" => $prop["SQUARE_WC"]["VALUE"],
            "decoration" => $prop["FINISHING"]["VALUE"],
            "flatplan" => $img,
            "height" => $prop["CEILING_HEIGHT"]["VALUE"],
            "flatfloor" => $prop["FLOAT_NUM"]["VALUE"],
            "sroom" => $prop["LIVING_AREA"]["VALUE"],
            "floors" =>  $floor ,
            "buildingplace" => array(
                "title" => $ourBlock["title"],
            ),
            "from_iblock" => "Y"
        );

        $blockIdDone[] = $atFormat;
    }
}
$bufLabel =array();
foreach ($blockIdDone as $value) {
	$bufLabel[] = $value["rooms"]; 
}
$arMirror = array_unique($bufLabel);
$arLabel = array();
foreach ($blockIdDone as $value) {
	$arLabel[$value["rooms"]]["PRICE_BASIC"][] = $value["baseflatcost"];
    $query = "";
    if ($value["rooms"] == "4"){
        $query .= "?arrFilter_5_2366072709=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }elseif ($value["rooms"] == "3" || $value["rooms"] == "23"){
        $query .= "?arrFilter_5_4194326291=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }elseif ($value["rooms"] == "2" || $value["rooms"] == "22"){
        $query .= "?arrFilter_5_1790921346=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }elseif ($value["rooms"] == "1"){
        $query .= "?arrFilter_5_498629140=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }elseif ($value["rooms"] == "0"){
        $query .= "?arrFilter_5_2226203566=Y&arrFilter_2_MIN=&arrFilter_2_MAX=&arrFilter_1_MIN=&arrFilter_1_MAX=&arrFilter_66_MIN=&arrFilter_66_MAX=&set_filter=Показать+варианты";
    }
	$arLabel[$value["rooms"]]["PRICE_PER_METER"][] = round(($value["baseflatcost"]/$value["stotal"]),0);
    if (!empty($value["flatcostwithdiscounts"])) {
        $arLabel[$value["rooms"]]["PRICE_DISCOUNT"][] = $value["flatcostwithdiscounts"];
    }
	$arLabel[$value["rooms"]]["SQUARE"][] = $value["stotal"];
	if (!isset($arLabel[$value["rooms"]]["COUNT"])){
		$arLabel[$value["rooms"]]["COUNT"] = 1;
	}else{
		$arLabel[$value["rooms"]]["COUNT"]++;
	}
    if (!empty($value["flatplan"])) {
        $arLabel[$value["rooms"]]["IMAGE"] = $value["flatplan"];
    }
    if (!empty($value["rooms"])) {
        $arLabel[$value["rooms"]]["LABEL"] = $value["rooms"];
    }
    if (!empty($value["roomtype"])){
        $arLabel[$value["rooms"]]["LABEL_TYPE"] = $value["roomtype"];
    }
    if ($value["from_iblock"] == "Y"){
		$arLabel[$value["rooms"]]["LABEL_TYPE"] = $value["rooms"];
    }
    $arLabel[$value["rooms"]]["QUERY_STRING"] = $query;
}
ksort($arLabel);

if (!empty($arLabel)){
?>
<!--
<div class="summChar">
    <p class="elementTitleInner">Смотреть цены и планировки</p>
</div>
-->

<?}?>