<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();/** @var array $arParams */
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
$APPLICATION->AddHeadString('<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>', true);

//echo'<pre>->';print_r($GLOBALS['arMyFilter']);echo'</pre>';
//echo'<pre>->';print_r($arResult);echo'</pre>';
//echo'<pre>->';print_r($arResult['ITEMS']);echo'</pre>';
//echo sizeof($arResult['ITEMS']);
?>
<?
$xml = simplexml_load_file("http://szvdom.ru/include/xml/SiteData.xml") or die("Error: Cannot create object");
?>
<div class='specOfferMainPage similarOnePage'>
<h1><?$APPLICATION->ShowTitle('h1')?> </h1>

	<?//map?>
            <div id="toggle" data-status="close" data-map="empty" >
                <div class="teaserBody">
                    <span class="mapText">
                        Познакомиться со всеми новостройками
                        <br/> 
                        Санкт-Петербурга и Ленинградской области,
                        <br/> 
                        Вы можете

                        <a href="javascript:void(0)" class="clickPiece"> на карте</a>
                    </span>
                </div>
            </div>
            <div class="mapWindow" style="top: 0;margin-left: -38px;">
                <div class="mapHead">Бесплатная консультация и подбор жилья:  +7(812) 406-11-48 <a data-who="footer_feedback" class="buttonGreen showIt" onclick="yaCounter21785827.reachGoal('map_click'); return true;" data-formsend="map_send">ЗАКАЗАТЬ ЗВОНОК</a> </div>
                <div class="closeMapPopUp" onclick="$('.mapWindow').fadeOut(500);$('.mapWindowOverlay').fadeOut(500);$('#toggle').data('status','close');"></div>
                <div class="mapkBody">
                    <div id="specMap" class="popUpMap"></div>
                </div>
            </div>
<div class="mapWindowOverlay" onclick="$('.mapWindow').fadeOut(500);$(this).fadeOut(500);$('#toggle').data('status','close');"></div>
	<?//end map?>
<ul>
<?
foreach ($arResult['ITEMS'] as $key => $buf) {
	$blocks = $xml->xpath("/Ads/Blocks/Block[@id='" . $buf["PROPERTIES"]["SECOND_ID"]["VALUE"] . "']");
	//echo'<pre>->';print_r($blocks);echo'</pre>';

	if (!empty($buffo["PREVIEW_PICTURE"])) {
		$image = CFile::GetFileArray($buf["PREVIEW_PICTURE"]);
	} else {
		if (empty($blocks[0]["avatar"])) {
			$image = CFile::GetFileArray($buf["PROPERTIES"]["MULTI_IMAGES"]["VALUE"][0]);
		} else {
			$image["SRC"] = "/include/images/" . (string)$blocks[0]["avatar"];
		}
	}
	$buf["PREVIEW_PICTURE"] = $image["SRC"];
	$arMap[] = array(
		"X" => $buf["PROPERTIES"]["LATITUDE"]["VALUE"],
		"Y" => $buf["PROPERTIES"]["LONGITUDE"]["VALUE"],
		"REGION" => $buf["PROPERTIES"]["REGION"]["VALUE"][0],
		"ADDRESS" => $buf["PROPERTIES"]["ADDRESS"]["VALUE"],
		"NAME" => $buf["NAME"],
		"URL" => $buf["DETAIL_PAGE_URL"],
		"IMG" => $image["SRC"]
	);
?>
    <li>
        <div class="firstCol">
            <img width="250" src="/thumb/250x187xin<?= $buf["PREVIEW_PICTURE"]; ?>" alt="<?= $buf["NAME"] ?>" title="<?= $buf["NAME"] ?>"/>
            <? if (!empty($buf["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"])) { ?>
                <div style="top: 35px;" class="redLabelMark"><?= $buf["PROPERTIES"]["RED_LABEL_MARK"]["VALUE"]; ?></div>
                <?
            } ?>
        </div>
        <div class="secondCol">
            <a href='<?= $buf["DETAIL_PAGE_URL"] ?>'><?= $buf["NAME"] ?></a>
            <ul>
                <? foreach ($buf["PROPERTIES"]["SPECIAL_OFFER"]["VALUE"] as $subValue) { ?>
                    <li><span><?= $subValue; ?></span></li>
                    <?
                } ?>
            </ul>
        </div>
        <div class="thirdCol">
            <p>
                <? foreach ($buf["PROPERTIES"]["REGION"]["VALUE"] as $keys => $subValue) {
                    if ($keys != (count($buf["PROPERTIES"]["REGION"]["VALUE"]) - 1)) { ?>
                        <?= $subValue; ?>,
                    <? } else { ?>
                        <?= $subValue; ?>
                        <?
                    }
                } ?>
                <? if (count($buf["PROPERTIES"]["REGION"]["VALUE"]) == 1) { ?>
                    район
                    <?
                } else { ?>
                    районы
                    <?
                } ?>
            </p>

            <div style="clear: both;"></div>
            <p>
                <span class="subwayLabel inline_m"></span>
                <? foreach ($buf["PROPERTIES"]["SUBWAYS"]["VALUE"] as $keys => $subValue) {
                    if ($keys != (count($buf["PROPERTIES"]["SUBWAYS"]["VALUE"]) - 1)) { ?>
                        <?= $subValue; ?>,
                    <? } else { ?>
                        <?= $subValue; ?>
                        <?
                    }
                } ?>
            </p>

            <div style="clear: both;"></div>
            <p><?= $buf["PROPERTIES"]["ADDRESS"]["VALUE"]; ?></p>

            <?/*<p class="priceSpecLook">от <span style="font-size: 22px !important;color: #EE3C31;"><?= number_format($buf["PROPERTIES"]["FLATCOST"]["VALUE"][0], 0, ',', ' '); ?></span> <span class="rub inline_m"></span></p>*/ ?>
            <a href="javascript: void(0);" data-who="detail_feedback" class="psevdoorange showIt" onclick="yaCounter21785827.reachGoal('spec_click'); return true;" data-formsend="spec_send"  style="width: 225px;text-transform: none;margin-top: 50px;">Узнать подробности</a>
			
        </div>
        <br/><br/>

        <div style="font-size: 11px;color: #909090;position: absolute; bottom: 0; left: 330px;">В данном разделе указаны не все акции и не полностью раскрыт их смысл</div>
    </li>

    <?

}
echo "</ul></div>";
?>


    <script type="text/javascript">
        $(document).ready(function(){
            $('.mapHead .buttonGreen').click(function(){
                $('.mapWindow').fadeOut(100);
                $('.mapWindowOverlay').fadeOut(100);
                $('#toggle').data('status','close');
            });
        });
        ymaps.ready(init);
        function init() {
            var myMap;
            $('#toggle').bind({
                click: function () {
                    if ($(this).data('map') == "empty") {
                        var myMap = new ymaps.Map("specMap", {
                                    center: [<?=$arMap[0]["X"]?>, <?=$arMap[0]["Y"]?>],
                                    zoom: 9,
                                    controls: ['smallMapDefaultSet']
                                },
                                {autoFitToViewport: 'always'}
                            ),
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
                                '<div class="popover-content"><span>$[properties.balloonContent]</span><br/>' +
                                '<span>$[properties.balloonContent2]</span><br/><br/>' +
                                '<div><a href="$[properties.balloonContentUrl]">Описание</a><a class="sec" href="$[properties.balloonContentUrl]tseny-na-kvartiry/">Цены</a><a class="sec" href="$[properties.balloonContentUrl]foto/">Фото</a></div>' +
                                '</div></div>'
                            );
                        myMap.geoObjects
                            <?foreach ($arMap as $key => $value){
                                if (empty($value["X"]) || empty($value["Y"])){
                                    continue;
                                }
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
                                    balloonContentLayout: MyBalloonContentLayout,
                                    balloonCloseButton: true,
                                    balloonMinHeight: 100,
                                    balloonMinWidth: 200,
                                    balloonPanelMaxMapArea: 0,
                                    hideIconOnBalloonOpen: false,
                                    balloonOffset: [40, -70],
                                    iconLayout: 'default#image',
                                    iconImageHref: '/bitrix/templates/szvdom/images/mapLabel.png',
                                    iconImageSize: [30, 42],
                                    iconImageOffset: [-3, -42]
                                }))
                        <?if ($key == (count($arMap) - 1)){echo ";";}?>
                        <?}?>

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
    </script>



<div class="whatAreQuestion">
	<p class="whatAreQuestionText">
		<span class="watqtBig">Возникли вопросы? Позвоните!</span>
		<br/>
		<span class="watqtLittle">Бесплатная консультация и подбор жилья по телефону
		<br/>
		<span class="ya-elama-phone call_phone_1">+7(812) 902-50-50</span> <a data-who="footer_feedback" class="showIt">оставить заявку</a></span>
	</p>
	<div class="QW_block_ph point_border showIt" data-who="footer_feedback" ></div>
	<div data-who="footer_feedback" class="showIt" style="background: url('/bitrix/templates/szvdom/images/contact_us4.png')no-repeat; cursor:pointer; width: 100px;height: 100px;position: absolute;display: inline-block;right: 26px;top: 40px;"></div>
</div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
