<?php
$ret = array(
    'code' => 0,
    'message' => '<b>Что-то пошло не так :(</b><p>Пожалуйста, обновите страницу</p>'
);

$mail_subjects = array(
    1 => 'Заявка на получение консультации',
    2 => 'Хотят узнать подробности',
    3 => 'Заявка на просмотр',
    4 => 'Хотят узнать цену',
    5 => 'Заявка на расчет ипотеки',
    6 => 'Хотя узнать про лучшее предложение'
);

$type = isset($_POST['type']) && is_numeric($_POST['type']) && array_key_exists($_POST['type'], $mail_subjects) ? (int) $_POST['type'] : null;
$user = isset($_POST['user']) && is_array($_POST['user']) && sizeof($_POST['user']) > 0 ? $_POST['user'] : null;

if ( !is_null($user) && !is_null($type) && isset($user['phone']) && strlen($user['phone']) > 0 ) {

	$mail_to = 'zapros@szvdom.ru';
	//$mail_to = 'sakuradesign@yandex.ru';
	//$mail_cc = 'aleksey-nikolayenko@seotime.ru, dain1982plus@mail.ru';

    $price = isset($_POST['price']) && strlen($_POST['price']) > 0 ? (int) preg_replace('/\D/i', '', $_POST['price']) : null;

    $days = array('m' => 'сегодня', 't' => 'завтра');
    $day = isset($user['day']) && array_key_exists($user['day'], $days) ? $days[$user['day']] : null;

    $times = array('m' => 'утро', 'd' => 'день', 'e' => 'вечер', 'n' => 'ночь');
    $time = isset($user['time']) && array_key_exists($user['time'], $times) ? $times[$user['time']] : null;

    $mail_message =
        date('Y-m-d H:i:s') . '<br><br>' .
        'Телефон: ' . $user['phone'] . '<br>'.
        ( isset($user['name']) && strlen($user['name']) > 0 ? 'Имя: ' . $user['name'] . '<br>' : '' ).
        ( !is_null($price) && $price > 0 ? 'Ежемесячный платеж: ' . number_format($price, 0, '', ' ') . ' руб.<br>' : '' ).
        ( !is_null($day) ? 'Когда: ' . $day . (!is_null($time) ? ', '.$time : '') . '<br>' : '' );

    $mail_message .= '<br><hr><small><i>Это письмо создано автоматически. Пожалуйста, не отвечайте на него</i></small>';
    $mail_subject = "=?UTF-8?B?" . base64_encode($mail_subjects[$type]) . "?=";
    $mail_headers =
		//  'From: no-reply <zapros@szvdom.ru>' . "\r\n" .
        'Cc: ' . $mail_cc . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/html; charset=utf-8' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if ( mail($mail_to, $mail_subject, $mail_message, $mail_headers) ) {
        $ret = array(
            'code' => 1,
            'message' => '<b>Спасибо! Мы очень рады Вашему обращению.</b><p>Наш менеджер свяжется с Вами в ближайшее время</p>'
        );
    }
}
echo json_encode($ret);