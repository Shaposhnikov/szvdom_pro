<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><!DOCTYPE html>
<html>
<head>
<title><?$APPLICATION->ShowTitle()?></title>
<meta property="og:image" content="http://szvdom.ru/bitrix/templates/szvdom/images/logo.png" />
<?
$Last_Modified = @date ( 'D, d M Y H:i:00' , time () - 432000 );
$Expires = @date ( 'D, d M Y H:i:00' , time () + 432000 );
echo "<!--" . $Expires . "-->";
?>
<meta http-equiv="Last-Modified" content='<?print "$Last_Modified"?> GMT'/>
<meta http-equiv="Expires" content='<?print "$Expires"?> GMT'/>

<meta name="viewport" content="width=1100" />
<meta name='yandex-verification' content='47a829d0b97a9b9c' />
<meta name="google-site-verification" content="9Ui0r0aAOKKov_CaLoXc2yXUezmqGfw5uy6_XrLy9RM" />
<?if ($_SERVER['REQUEST_URI'] == '/obekty/zhk-bogemiya/pohozhie-obekty/' || $_SERVER['REQUEST_URI'] == '/obekty/zhk-flagman/ipoteka/' || $_SERVER['REQUEST_URI'] == '/obekty/zhk-pribaltiyskiy-2/' || $_SERVER['REQUEST_URI'] == '/obekty/zhk-vnutri/ipoteka/' || $_SERVER['REQUEST_URI'] == '/obekty/zhk-vnutri/planirovki/' || $_SERVER['REQUEST_URI'] == '/obekty/zhk-ya-romantik/foto/' || $_SERVER['REQUEST_URI'] == '/obekty/zhk-ya-romantik/ipoteka/'){
echo '<meta name="robots" content="noindex"/>
';}?>
<!-- <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'> -->

<?

//$APPLICATION->SetAdditionalCSS("http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css");
$APPLICATION->SetAdditionalCSS("/bitrix/templates/.default/css/fotorama.css");
//<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
$APPLICATION->SetAdditionalCSS("/bitrix/templates/.default/css/font-awesome.min.css");


if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/d-robots.php')) {
    include_once ($_SERVER['DOCUMENT_ROOT'] . '/d-robots.php');
    $dRobots = dRobots::fromFile();
    $noindex = $dRobots->checkUrl($_SERVER['REQUEST_URI']) ? '<meta name="googlebot" content="noindex">' . PHP_EOL : '';
} else $noindex = '';
echo $noindex;

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/clickfrogru_tcp.php')) {
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/clickfrogru_tcp.php');
$noclickfrog = '<!--clickfrog:ok-->';
} else {
$noclickfrog = '<!--clickfrog:warning-->';
}
echo $noclickfrog;
?>
<? 
$gets = array(); 
foreach($_GET as $gettik=>$val) { 
if(strpos($gettik, 'PAGEN_') === false) { 
$gets[$gettik] = $val; 
} 
} 
$page = $APPLICATION->GetCurPageParam("", array_keys($gets), false); 
if($APPLICATION->GetCurPageParam("", "", false) !== $page) { 
	$APPLICATION->AddHeadString('<link href="http://szvdom.ru'.$page.'" rel="canonical" />',true); 
} 
?> 
<!--noindex--><script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.js"></script><!--/noindex-->
<!--noindex--><script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/fotorama.js"></script><!--/noindex-->
<!--noindex--><script>
	/* 
jQuery(document).ready(function($){

<?php if (preg_match("/tseny-na-kvartiry/",$_SERVER['REQUEST_URI'])):?>      
	//var div = $('.show_tablehead');
	//  var start = $('#table111').offset().top-82;
	//  var end = $('#tableEnd').offset().top;
<?php endif;?>  

if ($('.menuForElements').length){       
        var div2 = $('.menuForElements');
        var start2 = $('.menuForElements').offset().top;
        var end2 = $('.menuForElements').offset().top;
}     
	// $.event.add(window, "scroll", function() {
	       var p = $(window).scrollTop();
<?php if (preg_match("/tseny-na-kvartiry/",$_SERVER['REQUEST_URI'])):?>            
            $(div).css('position',(p>start && p<end) ? 'fixed' : 'static');
            $(div).css('display',(p>start && p<end) ? 'block' : 'none');
            $(div).css('top',(p>start && p<end) ? '54px' : '');
<?php endif;?> 
            if ($('.menuForElements').length){            
                $(div2).css('position',(p>start2) ? 'fixed' : 'static');
                //$(div2).css('display',(p>start2 && p<end2) ? 'block' : 'block');
                $(div2).css('top',(p>start2) ? '0px' : '');
                $(div2).css('z-index',(p>start2) ? '999' : '');
            }
			  //});
	});
	});

*/
</script><!--/noindex-->





<?
ob_start();
$bro = getBrowser($_SERVER["HTTP_USER_AGENT"]);
if ($bro === false){?>
    <!--noindex--><script type="text/javascript">
        document.location.href = "http://szvdom.ru/toold.php";
    </script><!--/noindex--> 
<?}
ob_get_clean();
?>
<? $APPLICATION->ShowHead(); ?>
<link href="<?=SITE_TEMPLATE_PATH?>/css/jquery.fs.scroller.min.css" type="text/css"  rel="stylesheet" />
<link href="<?=SITE_TEMPLATE_PATH?>/css/reset.css" type="text/css"  rel="stylesheet" />
<link href="/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.fancybox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/styles.css" media="screen" />
<!--noindex--><script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/inputmask.js"></script><!--/noindex-->
<!--noindex--><script type="text/javascript" src="<?= SITE_TEMPLATE_PATH ?>/js/jquery.inputmask.js"></script><!--/noindex-->

<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.datetimepicker.css" media="screen" />
<!--noindex--><script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.datetimepicker.full.min.js"></script><!--/noindex-->

<!--noindex--><script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.price_format.2.0.min.js"></script><!--/noindex-->

<!--noindex--><script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-42390472-1', 'szvdom.ru');
      ga('send', 'pageview');

    </script><!--/noindex-->
<!--noindex--><script>
$(function () { 
    $('.forAllPageRightSide a').each(function () {
        var location = window.location.href;
        var link = this.href; 
        if(location == link) {
            $(this).addClass('active');
        }
    });
});

$(function () { 
    $('.menuForElements a').each(function () {
        var location = window.location.href;
        var link = this.href; 
        if(location == link) {
            $(this).addClass('active_1');
        }
    });
});

$(function () { 
    $('.bottomMenuHeader a').each(function () {
        var location = window.location.href;
        var link = this.href; 
        if(location == link) {
            $(this).addClass('active_2');
        }
    });
});
</script><!--/noindex-->




<!-- Yandex.Metrika counter -->
    <!--noindex--><script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter21785827 = new Ya.Metrika({id:21785827,
                        webvisor:true,
                        clickmap:true,
                        trackLinks:true,
                        trackHash:true});
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
    </script><!--/noindex-->
    <noscript><div><img src="//mc.yandex.ru/watch/21785827" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->


<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '287833154924968');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=287833154924968&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
	
<!-- Alloka Main -->
<script type="text/javascript">

var _alloka = {
objects: {
'54e4044ad62ac08a': {
block_class: 'phone_alloka'
}
},
trackable_source_types: ["type_in", "referrer", "utm"],
last_source: false,
use_geo: true
};
</script>
<script src="http://analytics.alloka.ru/v4/alloka.js" type="text/javascript"></script>
<!-- Alloka Main end-->
<!-- Alloka Form -->
<script src="https://analytics.alloka.ru/integrations/catch_form.js" type="text/javascript"></script>

<!-- Alloka Form end -->

<meta name="wot-verification" content="413cd0ecded79e3bd34a"/>
</head>
<body>
<?


$APPLICATION->ShowPanel();

$arMenuHeaderUp = array(
    0 => array("NAME" => "компания","URL" => "/kompaniya/"),
    1 => array("NAME" => "почему мы","URL" => "/preimushhestva/"),
    2 => array("NAME" => "услуги","URL" => "/uslugi/"),
    3 => array("NAME" => "покупателям","URL" => "/pokupateljam/"),
    4 => array("NAME" => "инвесторам","URL" => "/ivestoram/"),
    5 => array("NAME" => "новости","URL" => "/novosti/"),
    6 => array("NAME" => "сотрудничество","URL" => "/sotrudnichestvo/")
);
$arMenuHeaderDown = array(
    0 => array("NAME" => "каталог новостроек","URL" => "/obekty/"),
    1 => array("NAME" => "спецпредложения","URL" => "/akcii-i-skidki/"),
    2 => array("NAME" => "переуступки","URL" => "/pereustupki/"),
    3 => array("NAME" => "ипотека","URL" => "/ipoteka/"),
	4 => array("NAME" => "зачет жилья","URL" => "/sposoby-pokupki/zachet-kvartiry/"),
    5 => array("NAME" => "контакты","URL" => "/kontakty/")
);

?>
<div class="main">
	<div class="header">
        <div class="headerTopPart">

            <div class="topMenuHeader">
                <ul>
                    <?
                    $nowPage = $APPLICATION->GetCurPage();

                    foreach($arMenuHeaderUp as $value){
                    	if (strrpos($nowPage, $value["URL"]) !== false){?>
								<li class="active"><a href="<?=$value["URL"]?>"><?=strtoupper($value["NAME"])?></a></li>
                    		<?
                        }else{?>
							<li><a href="<?=$value["URL"]?>"><?=strtoupper($value["NAME"])?></a></li>
                    	<?}
                    }?>
                </ul>
            </div>

<?=$section["SEO"]["SECTION_PAGE_TITLE"];?><?$APPLICATION->IncludeComponent(
    "bitrix:search.form",
    "suggest",
    Array(
    )
);?>

            <div class="headerMainBody">
                <div class="headerMainBodyLeft">
            	   <a href="/" class="logo"><img src="<?=SITE_TEMPLATE_PATH?>/images/logo.png" alt="Компания 'Созвездие недвижимости'" title="Компания 'Созвездие недвижимости'"/> </a>
                   <div class="texgt">
                       <p><span class="bigTest">0</span><span class="tinyText">%</span></p>
                       <div class="upperText">
                           квартиры в новостройках
                           <br/>
                            без комиссии
                       </div>
                   </div>
                </div>
                <div class="headerMainBodyRight">
                        <div class="secondColumnBottom">
                            <a data-who="footer_feedback" onclick="yaCounter21785827.reachGoal('head_click'); return true;" data-formsend="head_send" class="buttonGreen showIt" style="float: left;width:180px;line-height:36px;height:36px;margin-top:25px;" >ЗАКАЗАТЬ ЗВОНОК</a>
                        </div>

                    <div class="phone2">
<?
if (strpos($_SERVER["REQUEST_URI"], "vtorichnaja")){
?>
						<a href="tel:+7(812) 907-15-15" style="text-decoration:none;"><span class="phone phone_alloka">+7(812) 902-50-50</span></a>
<?
} elseif (strpos($_SERVER["REQUEST_URI"], "obekty")) {
?>
						<a href="tel:+7(812) 907-15-15"  style="text-decoration:none;"><span class="comagic phone_alloka">+7(812) 902-50-50</span></a>
						<? 
} elseif (strpos($_SERVER["REQUEST_URI"], "kommercheskaja")) {
?>
						<a href="tel:+7(812) 907-15-15" style="text-decoration:none;"><span  class="comagic2 phone_alloka">+7(812) 902-50-50</span></a>
						<? 
} elseif (strpos($_SERVER["REQUEST_URI"], "pereustupki")) {
?>
						<a href="tel:+7(812) 907-15-15" style="text-decoration:none;"><span  class="comagic3 phone_alloka">+7(812) 902-50-50</span></a>
						<? 
} else {
?>
<a href="tel:+7(812) 907-15-15" style="text-decoration:none;"><span class="phone phone_alloka">+7(812) 902-50-50</span></a>
<?
}
?>
                        <!--<span class="ya-elama-phone call_phone_1">+7(812) 902-50-50</span>-->
                        <p>без выходных с 9 до 22</p>
                    </div>
                </div>
            </div>




            <div class="bottomMenuHeader">
                <ul>
                    <?foreach($arMenuHeaderDown as $value){?>
                        <li><a href="<?=$value["URL"]?>"><?=$value["NAME"]?></a></li>
                    <?}?>
                </ul>
            </div>
        </div>
        <div style="clear: both;"></div>
        <?if ($APPLICATION->getCurPage() == "/"){?>
        <div class="headerSliderPart">
            <div class="slider_wrap<?=($APPLICATION->GetCurPage() == "/") ? "" : " inner_page";?>">
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:slider",
                    ".default",
                    array(
                        "SPEED" => "5000",
                        "IBLOCK_TYPE" => "service",
                        "IBLOCK_ID" => "4",
                        "EFFECT" => "boxRainGrowReverse",
                        "PEGINATION" => "Y",
                        "CONTROLS" => "Y",
                        "DESCRIPTION" => "N",
                        "CLASS" => "theme_szv"
                    ),
                    false
                );
                ?>
            </div>
        </div>
        <?}?>

<br>
<? if ($APPLICATION->getCurPage() == "/") {
$APPLICATION->IncludeComponent("bitrix:menu", "ver1", Array(
	"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
		"MENU_CACHE_TYPE" => "N",	// Тип кеширования
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
		"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	),
	false
);
}?>

<? if ($APPLICATION->getCurPage() == "/"): ?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter",
	"szv",
	array(
		"IBLOCK_TYPE" => "obekty",
		"IBLOCK_ID" => "1",
		"SECTION_ID" => "",
		"SECTION_CODE" => "all",
		"FILTER_NAME" => "arrFilter",
		"TEMPLATE_THEME" => "blue",
		"FILTER_VIEW_MODE" => "vertical",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => (preg_match("/vyborki/i", $APPLICATION->GetCurPage()) ? "Y" : "N"),
		"INSTANT_RELOAD" => "N",
		"XML_EXPORT" => "Y",
		"SECTION_TITLE" => "-",
		"SECTION_DESCRIPTION" => "-",
		"POPUP_POSITION" => "left",
		"DISPLAY_ELEMENT_COUNT" => "N"
	),
	false
);?>
<? endif; ?>

<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "ver1", Array(
	"START_FROM" => "1",	// Номер пункта, начиная с которого будет построена навигационная цепочка
		"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
		"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
	),
	false
);
$APPLICATION->AddChainItem("Главная", "/");
?>