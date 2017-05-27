<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if (!empty($arResult["ITEMS"])){
?>
<div class="summChar">
    <p class="elementTitleInner">Квартиры и цены</p>
</div>
<table class="summCharTable">
	<tbody>
		<tr class="boldText titleTable">
            <th width="38"></th>
			<th width="170">Кол-во комнат</th>
			<th width="170">Площадь</th>
			<?/*<th width="230">Цена за метр квадратный</th>
			<th width="160">Базовая цена, руб.</th>*/?>
			<th width="180">Со скидкой, руб.</th>
			<th width="145">Квартиры</th>
			<th width="145">Планировка</th>
			<th width="170">В продаже, шт.</th>
            <th width="38"></th>
		</tr>
		<?foreach ($arResult["ITEMS"] as $key => $value) {?>
			<tr <?/*onclick="location.href = '<?=$arParams["REDIRECT_URL"];?>tseny-na-kvartiry/<?=$value["QUERY_STRING"];?>'"*/?>>
                <td></td>
				<td><?=$value["LABEL_TYPE"];?></td>
				<td> от <?=min($value["SQUARE"]);?></td>
				<?/*<td > от <?=number_format( min($value["PRICE_PER_METER"]), 0, ',', ' ');?></td>
				<td> от <?=number_format(min($value["PRICE_BASIC"]), 0, ',', ' ');?></td>*/?>
				<td><?/* от <?=number_format(min($value["PRICE_DISCOUNT"]), 0, ',', ' ') ;?>*/?><a href="javascript: void(0);" data-who="price_feedback" class="showIt">Узнать цену</a></td>
				<td><a href="<?=$arParams["REDIRECT_URL"];?>tseny-na-kvartiry/<?=$value["QUERY_STRING"];?>">Посмотреть</a></td>
				<td><a href="<?=$arParams["REDIRECT_URL"];?>planirovki/<?=$value["QUERY_STRING"];?>">Посмотреть</a></td>
				<td><?=$value["COUNT"];?></td>
                <td></td>
			</tr>
		<?}?>
	</tbody>
</table>
<div class="summChar">
    <a class="pseudoButton" href="<?=$arParams["REDIRECT_URL"];?>tseny-na-kvartiry/">Посмотреть все квартиры</a>
</div>
<?}?>