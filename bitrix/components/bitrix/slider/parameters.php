<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$slider_effects = array('sliceDownRight'=>'sliceDownRight',
						'sliceDownLeft'=>'sliceDownLeft',
						'sliceUpRight'=>'sliceUpRight',
						'sliceUpLeft'=>'sliceUpLeft',
						'sliceUpDown'=>'sliceUpDown',
						'sliceUpDownLeft'=>'sliceUpDownLeft',
						'fold'=>'fold',
						'fade'=>'fade',
						'boxRandom'=>'boxRandom',
						'boxRain'=>'boxRain',
						'boxRainReverse'=>'boxRainReverse',
						'boxRainGrow'=>'boxRainGrow',
						'boxRainGrowReverse'=>'boxRainGrowReverse');

$arComponentParameters = array(
	"PARAMETERS" => array(
		"SPEED" => Array(
			"NAME" => "Speed", 
			"TYPE" => "STRING",
			"DEFAULT" => "3000", 
			"PARENT" => "BASE",
		),
		"IBLOCK_ID" => Array(
			"NAME" => "iblock ID", 
			"TYPE" => "STRING",
			"DEFAULT" => "", 
			"PARENT" => "BASE",
		),
		"EFFECT" => Array(
			"NAME" => "Slide change effect", 
			"TYPE"=>"LIST", 
			"VALUES" => $slider_effects,
			"DEFAULT"=>"fade", 
			"MULTIPLE"=>"N", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
		"CLASS" => Array(
			"NAME" => "CSS class", 
			"TYPE" => "STRING",
			"DEFAULT" => "theme-default", 
			"PARENT" => "BASE",
		),
		"PEGINATION" => Array(
			"NAME" => "Pegination", 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"CONTROLS" => Array(
			"NAME" => "Controls", 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"DESCRIPTION" => Array(
			"NAME" => "Descripton", 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
	)
);


?>