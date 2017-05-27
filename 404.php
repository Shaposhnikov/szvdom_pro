<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?><?php

include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

$sapi_type = php_sapi_name();
if ($sapi_type=="cgi") 
   header("Status: 404");
else 
   header("HTTP/1.1 404 Not Found");
@define("ERROR_404","Y");
//Тут уже подключение верней части шаблона и присваивание заголовка
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ошибка 404 - Страница не найдена");
?>

<div id="404" style="margin-left:40px;">
<img src="/bitrix/templates/szvdom/images/14024272008686.jpg" align="left">
	<p style="font-weight: bold;font-size:57px;color:#276cb2;padding-bottom:30px;padding-top:30px;">Ой! Ошибка 404</p>

<h1>Страницу которую вы ищите, не удалось найти.</h1>
<br>
<div><p style="font-size: 12pt;">Вероятно это произошло потому что:</p>
<br>
	<p style="font-size: 14px;">Не верно указан URL адресс..................<a href="http://szvdom.ru/">перейти на главную</a></p>
	<p style="font-size: 14px;">Страницы больше не существует.........<a href="/obekty/">каталог объектов</a></p>
	<p style="font-size: 14px;">Другие причины.....................................<a href="/sitemap/">карта сайта</a></p>



</div>

<br>


 <br>
	<p style="font-size: 12pt; font-weight: bold;"> <span style="align: center; font-size: 32pt;color:#276cb2; ">+7(812) 902-50-50</span> <br><br>Поможем найти страницу за минуту, звоните!</p>
<br>

</div>





<?php 
function show_form() 
{ 
?> 
<form action="" method=post > 
<div align="center"> 
	<br /><p style="font-size:16px;">Пожалуйста, сообщите нам, как Вы попали на эту страницу? <br> Мы обязательно исправим эту ошибку!</p><br /> 
              <textarea rows="6" name="mess" cols="80" style="border:1px solid #777777; border-radius:3px; font-size:18px;"></textarea> 
              <br /><input type="submit" value="Отправить" name="submit" style="padding:10px 20px 10px 20px;margin:20px;background:#276cb2;color:#fff;"> 
</div> 
</form> 

<? 
} 
 
function complete_mail() { 
        $_POST['title'] =  substr(htmlspecialchars(trim($_POST['title'])), 0, 1000); 
        $_POST['mess'] =  substr(htmlspecialchars(trim($_POST['mess'])), 0, 1000000); 
        $_POST['name'] =  substr(htmlspecialchars(trim($_POST['name'])), 0, 30); 
        $_POST['tel'] =  substr(htmlspecialchars(trim($_POST['tel'])), 0, 30); 
        $_POST['email'] =  substr(htmlspecialchars(trim($_POST['email'])), 0, 50); 
        // если не заполнено поле "Имя" - показываем ошибку 0 

        // если неправильно заполнено поле email - показываем ошибку 1 

        // если не заполнено поле "Сообщение" - показываем ошибку 2 
        if(empty($_POST['mess'])) 
             output_err(2); 
        // создаем наше сообщение 
        $mess = ' 
        '.$_POST['name'].' 
        '.$_POST['tel'].' 
        '.$_POST['email'].' 

        '.$_POST['mess']; 
        // $to - кому отправляем 
        $to = 'it@szvdom.ru'; 
        // $from - от кого 
        $from='404@szvdom.ru'; 
        mail($to, $_POST['title'], $mess, "From:".$from); 
	echo '<center><p style="font-size:16px;padding:25px;margin-bottom:30px;background:#e6ffca;">Спасибо за Ваше сообщение! Скоро мы все исправим.<p></center>'; 
} 

function output_err($num) 
{ 
	$err[0] = ' '; 
    $err[1] = ' '; 
    $err[2] = '<p style="text-align: center;    padding: 15px;    background: rgb(245, 201, 201);   font-size: 16px;    font-weight: 700;">ОШИБКА! Не введено сообщение.</p>'; 
    echo '<p>'.$err[$num].'</p>'; 
    show_form(); 
    exit(); 
} 

if (!empty($_POST['submit'])) complete_mail(); 
else show_form(); 
?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>