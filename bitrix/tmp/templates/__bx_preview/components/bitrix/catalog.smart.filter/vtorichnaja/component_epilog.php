<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
global $APPLICATION;
CJSCore::Init(array("fx"));

if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}


?>

<?
if (isset($_SESSION['userfilter']))
{
$userfilter = $_SESSION['userfilter'];
parse_str($userfilter , $filter_array[1]);
$_SESSION['arrFilter'] = $filter_array;
$GLOBALS['arrFilter'] = $filter_array;
}

?>