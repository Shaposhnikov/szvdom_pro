<? if (CModule::IncludeModule("iblock")) : ?>

    <? $likeObjects = CIBlockElement::GetList (Array("ID" => "ASC"),
        Array("IBLOCK_ID" => 8),
        false,false,
        Array("ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_FAST_SALE","PROPERTY_COAST","PROPERTY_ADDRESS","PROPERTY_SUBWAYS",)
    );
    
    $likeObjectsCount = 0;
     ?>

<div id="likeObjects">
    <h2>Похожие объекты</h2>
    
    <div class="fast_sale_carousel">
        <?	while($f = $likeObjects->GetNext()) {
            
            //echo $f['PROPERTY_SUBWAYS_VALUE']."=".$arResult['PROPERTIES']['SUBWAYS']['VALUE_ENUM_ID'];
            $coast = $arResult['PROPERTIES']['COAST']['VALUE'];
            $likeCoast = $f['PROPERTY_COAST_VALUE'];
            $step = $coast * 0.30;
            $coast_min = $coast - $step;
            $coast_max = $coast + $step;          

            if (($f['PROPERTY_SUBWAYS_ENUM_ID'] == $arResult['PROPERTIES']['SUBWAYS']['VALUE_ENUM_ID']) &&
                ($likeCoast >= $coast_min) && ($likeCoast <= $coast_max) && ($arResult['ID'] !== $f['ID']))
            {
                $likeObjectsCount = $likeObjectsCount + 1;
                
                $db_props = CIBlockElement::GetProperty($f["IBLOCK_ID"], $f['ID'], "sort", "asc", Array("CODE"=>"MORE_PHOTO"));
                $img_path = "";

                while($ob = $db_props->Fetch()) 
                {
                    if ($ob["VALUE"]) $img_path = CFile::GetPath($ob["VALUE"]);
                } 
        ?>
        
        <div>
        <div class="fast-content">
            <a href="<?=$f['DETAIL_PAGE_URL'];?>">
            <div class="pic" style="background: url('<? echo $img_path; ?>') no-repeat; background-size: cover;"></div>
            <div class="coast">
                <?
                    echo "<b>".number_format($f['PROPERTY_COAST_VALUE'], 0, '.', ' ')."</b> руб.";
                ?>
            </div>
            <div class="adress-and-metro">
                <div class="row">
                    <div class="col" style="padding-right:10px;"><b>Адрес:</b></div>
                    <div class="col"><?=$f['PROPERTY_ADDRESS_VALUE'];?></div>
                </div>
                <div class="row">
                    <div class="col" style="padding-right:10px;"><b>Метро:</b></div>
                    <div class="col"><?=$f['PROPERTY_SUBWAYS_VALUE'];?></div>
                </div>
            </div></a>
        </div>
    </div>


        <? } //if PROPERTY_SUBWAYS_VALUE ?> 
        <?
        } //while

if ($likeObjectsCount == 0) { ?>
<script type="text/javascript">
    $("#likeObjects").remove();
</script>

<? }
        
        ?>
    </div>

</div>

<? endif; ?>


<?


$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/slick.js");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick.css");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick-theme.css");
?>

<style>

.slick-slider
{
    margin-top: 20px;
}

.slick-prev, .slick-next
{
    height: 100px;
}

.fast-content
{
        border:1px solid #005ea8;
        width: 220px; 
        height: 233px;
        margin:0 auto;
        font-family: 'Bold',sans-serif;
        background-color: white;
}


.fast-content .pic
{
    width: 220px;
    box-sizing: border-box;
    display: block;
    position: absolute;
    height: 147px;
    top: 1px; /*border*/
    bottom: 87px;
    
}

.fast-content .coast
{
    font-family: 'Reg',sans-serif; 
    width: 220px;
    box-sizing: border-box;
    display: block;
    color: white;
    background-color:#005ea8;
    text-align:center;
    position: absolute;
    height: 25px;
    line-height: 25px;
    bottom: 62px;
    font-size: 15px;
    
}

.fast-content .adress-and-metro {
    
font-family: 'Reg',sans-serif;
    position: absolute;
    height: 62px;
    max-height: 62px;
    overflow: hidden;
    bottom: 0px;
    padding: 5px 0 0 15px;
    width: 220px;
    box-sizing: border-box;
    font-size: 13px;
          
}

.fast-content .adress-and-metro .row {
    display: inline-flex;
    width: auto;
    clear: both;
    height: 26px;
    overflow: hidden;
}

.fast-content .adress-and-metro .col
{
    float: left;
    display: table-column;     
}

.fast-content .redlabel
{
    background-color:#ee3c32;
    color: white;
    height: 28px;
    text-transform: uppercase;
    font-size: 12px;
    display: block;
    position: absolute;
    line-height: 28px;
    top: 26px;
    padding-left: 10px;
    padding-right: 10px;
}

.fast-content a
	{
		color: black;
	}
    
#likeObjects
{
    width: 980px;
    overflow: hidden;
    padding: 0px 42px;
    background-color: #f2fafd;
}
#likeObjects h2
{
    color: #383838; 
    text-transform: uppercase; 
    margin-top: 12px; 
    margin-bottom: 18px;
    font-size: 22px; 
    
}
</style>

<script type="text/javascript">
jQuery(document).ready(function(){
  jQuery('.fast_sale_carousel').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: true,
	  prevArrow: '<div class="slick-prev"><img src="/vtorichnaja/images/arr_lt.png" alt=""/></div>',
	  nextArrow: '<div class="slick-next"><img src="/vtorichnaja/images/arr_rt.png" alt=""/></div>',
  });
});
</script>