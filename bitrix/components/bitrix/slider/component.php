<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
	
if (CModule::IncludeModule("iblock")) {

	$arSelect = Array("ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "PREVIEW_PICTURE", "DETAIL_PICTURE");
	$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"],"ACTIVE" => "Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arResult[] = $ob->GetFields();
	}

}
			
$this->IncludeComponentTemplate();
