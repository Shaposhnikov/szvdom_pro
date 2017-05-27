<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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



?>


<div class="gotovie_podborki popUpSelect" style="position:fixed;left: 50%;top: 50%;transform: translate(-50%, -50%);z-index: 1000;display:none;">
    <div class="popUpSelectInner">
        <div class="closeElementPopUp" onclick="$(this).parent('.popUpSelectInner').parent('.popUpSelect').fadeOut(500);$('.popUpWindowOverlay').fadeOut(500);$('.gotovie_podborki').fadeOut(500);"></div>
        <?

        $values = array();
        foreach ($arResult["ITEMS"] as $value) {
            foreach ($value["PROPERTIES"]["SELECT_GROUPS"]["VALUE"] as $subValue) {
                $values[] = $subValue;
            }
        }        
        $arResult["VALUES"] = array_unique($values); //array of filter type


        ?>


		<? switch( $arParams["SECTION_ID"] )
		{
			case 79://vtorichnaja 
			$sect_name = 'Готовые подборки вторичной';
			?>
			
			<div class="leftColumnPopUp" style="display: none;"><ul></ul></div>
            
			<div id="rightColumnPopUp">
				<p class="selectCategoryListTitle"><?=$sect_name;?></p>
                <div data-rel="vtorichnaja" class="searchBlockPopUp">
                    <? foreach ($arResult["ITEMS"] as $subKey => $subValue) { echo "<a href='".$subValue["DETAIL_PAGE_URL"]."'>".$subValue["NAME"]."</a>"; } ?>
                </div>
			</div>	
            <style>
                .popUpSelectInner {
                    background-color: white;
                }
            </style>

	
			
		<?	break;
			
			case 80://novostroiki 
			$sect_name = 'Готовые подборки Новостроек';
			?>
			
			<div class="leftColumnPopUp">
				<ul>
					<? foreach ($arResult["VALUES"] as $value) { ?>
						<li data-rel="<?= $value; ?>" class="changeIt"> &mdash;<?= $value; ?></li>
					<? } ?>
				</ul>
			</div>
	
			<div id="rightColumnPopUp">
				<p class="selectCategoryListTitle"><?=$sect_name;?></p>
				<? foreach ($arResult["VALUES"] as $key => $value) { ?>
					<div data-rel="<?= $value; ?>" class="searchBlockPopUp">
						<? foreach ($arResult["ITEMS"] as $subKey => $subValue) 
						{
							if (in_array($value, $subValue["PROPERTIES"]["SELECT_GROUPS"]["VALUE"])) 
							{
								echo "<a href='".$subValue["DETAIL_PAGE_URL"]."'>".$subValue["NAME"]."</a>";
							}
						}
						?>
						<br/>
					</div>
				<? } ?>
			</div>
			
		<?	break;
   		case 81: //w\o
        
        break;      



		}
		?>
		

    </div>
</div>

<div class="selectCategoryListForPopUp">
    <p><? echo $sect_name ?>
    <? switch( $arParams["SECTION_ID"] )

    {
        case 79: //vtorichnaja
        
            if (count($arResult["ITEMS"]) > 9) { ?>
            
                <a data-who="popUpSelect" data-type="vtorichnaja" class="greyLink showIt" style="margin-left: 10px;"> Смотреть все подборки</a></p>
            
            <? } ?>
            
            <ul>
                <? $i = 0;
                   
                   foreach ($arResult["ITEMS"]  as $subKey => $subValue) {
                        
                        $i++;
                        
                        if ($i < 10 ) { ?>
                        
                        <li data-who="popUpSelect">
                            <a href="<?=$subValue["DETAIL_PAGE_URL"];?>"><?=$subValue["NAME"];?></a>
                        </li>

                        <? }
                } ?>
            </ul>
    <?
        break;
        
        case 80: //novostroiki
        ?>
        
            <a data-who="popUpSelect" data-type="<?=$arResult["VALUES"][0];?>" class="greyLink showIt" style="margin-left: 10px;"> Смотреть все подборки</a></p>
            
            <ul>
                <? foreach ($arResult["VALUES"] as $key => $value) { ?>
                    <li data-who="popUpSelect" class="showIt" data-type="<?=$value;?>">
                        <span style="border-bottom: none"></span>
                        <span><?= $value; ?></span>
                    </li>
                <? } ?>
            </ul>
        
        <?            

        break;      


   		case 81: //w\o
        
        break;      

    }

    ?>
</div>


<?//echo'<pre>';print_r( $arResult] );echo'</pre>';	?>
<?//echo'<pre>';print_r( $arParams );echo'</pre>';	?>


