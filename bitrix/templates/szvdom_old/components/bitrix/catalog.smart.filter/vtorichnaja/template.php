<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
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

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/colors.css',
    'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
);
?>
<div class="bx_filter bx_blue">
	<div class="bx_filter_section ">
		<form name="_form" action="/vtorichnaja/" method="get" class="smartfilter">
<div class="openRemoteControlPopup Metro">Выберите метро</div>
	<div class="openRemoteControlPopup Region">Выберите район</div>



<? foreach ($arResult['ITEMS'] as $item) {
	switch($item['CODE']) {
		case "TYPE_HOUSE":

 ?>

<div class="bx_filter_parameters_box BUILDINGTYPE" style="display:block;">
	<div class="bx_filter_parameters_box_title"><?echo $item['NAME']; ?></div>
	<div class="bx_filter_block">
		<div class="bx_filter_parameters_box_container">

			<? foreach($item['VALUES'] as $option) { ?>

<label data-role="label_<? echo $option['CONTROL_NAME']; ?>" class="bx_filter_param_label  " for="<? echo $option['CONTROL_ID']; ?>">
	<span class="bx_filter_input_checkbox">
		<input type="checkbox" value="<? echo $option['HTML_VALUE']; ?>" name="<? echo $option['CONTROL_NAME']; ?>" id="<? echo $option['CONTROL_ID']; ?>" onclick="smartFilter.click(this)">
		<span class="bx_filter_param_text"><? echo $option['VALUE']; ?></span>
	</span>
</label>

			<? } ?>
		</div>
	</div>
</div>


<?

break;
		case "ROOM_AMOUNT": 

?>

<div class="bx_filter_parameters_box ROOM_NUM">
	<div class="bx_filter_parameters_box_title"><?echo $item['NAME']; ?></div>
	<div class="bx_filter_block">
		<div class="bx_filter_parameters_box_container">

			<? foreach($item['VALUES'] as $option) { ?>

			<label data-role="label_<? echo $option['CONTROL_NAME']; ?>" class="bx_filter_param_label  " for="<? echo $option['CONTROL_ID']; ?>">
				<span class="bx_filter_input_checkbox">
					<input type="checkbox" value="<? echo $option['HTML_VALUE']; ?>" name="<? echo $option['CONTROL_NAME']; ?>" id="<? echo $option['CONTROL_ID']; ?>" onclick="smartFilter.click(this)">
					<span class="bx_filter_param_text"><? echo $option['VALUE']; ?></span>
				</span>
			</label>

			<? } ?>
	
		</div>

	</div>


</div>
<?

				break;
		case "S_ALL": 
?>

<div class="bx_filter_parameters_box">
	<div class="bx_filter_parameters_box_title"><? echo $item['NAME'] ?></div>
	<div class="bx_filter_block">
		<div class="bx_filter_parameters_box_container">
			<div style="float: left; padding:0 10px;">От:</div>
			<div class="bx_filter_input_container" style="width: 100px; float: left;">

			<input
				class="min-price"
				type="text"
				name="<?echo $item["VALUES"]["MIN"]["CONTROL_NAME"]?>"
				id="<?echo $item["VALUES"]["MIN"]["CONTROL_ID"]?>"
				value="<?echo $item["VALUES"]["MIN"]["HTML_VALUE"]?>"
				size="5"

				onkeyup="smartFilter.keyup(this)"
				/>
			</div>
			<div style="float: left; padding:0 10px;">До:</div>
			<div class="bx_filter_input_container" style="width: 100px; float: left;">
			<input
				class="max-price"
				type="text"
				name="<?echo $item["VALUES"]["MAX"]["CONTROL_NAME"]?>"
				id="<?echo $item["VALUES"]["MAX"]["CONTROL_ID"]?>"
				value="<?echo $item["VALUES"]["MAX"]["HTML_VALUE"]?>"
				size="5"
				onkeyup="smartFilter.keyup(this)"
				/>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</div>

<?

break;
		case "COAST": 

?>

<div class="bx_filter_parameters_box">
	<div class="bx_filter_parameters_box_title"><? echo $item['NAME'] ?></div>
	<div class="bx_filter_block">
		<div class="bx_filter_parameters_box_container">
			<div style="float: left; padding:0 10px;">От:</div>
			<div class="bx_filter_input_container" style="width: 100px; float: left;">

			<input
				class="min-price"
				type="text"
				name="<?echo $item["VALUES"]["MIN"]["CONTROL_NAME"]?>"
				id="<?echo $item["VALUES"]["MIN"]["CONTROL_ID"]?>"
				value="<?echo $item["VALUES"]["MIN"]["HTML_VALUE"]?>"
				size="5"

				onkeyup="smartFilter.keyup(this)"
				/>
			</div>
			<div style="float: left; padding:0 10px;">До:</div>
			<div class="bx_filter_input_container" style="width: 100px; float: left;">
			<input
				class="max-price"
				type="text"
				name="<?echo $item["VALUES"]["MAX"]["CONTROL_NAME"]?>"
				id="<?echo $item["VALUES"]["MAX"]["CONTROL_ID"]?>"
				value="<?echo $item["VALUES"]["MAX"]["HTML_VALUE"]?>"
				size="5"
				onkeyup="smartFilter.keyup(this)"
				/>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</div>



<?

break;
		default: ; break;
	}
}

?>



<div class="filter_boxes first inline">
	<div class="MRHolder inline">
	</div>
</div>

<!--first end-->

<div class="filter_boxes inline">
</div>

<!--second end-->

<div class="filter_boxes third inline">
		<? require_once('column3.php'); ?>
</div>

</form>
</div>
</div>