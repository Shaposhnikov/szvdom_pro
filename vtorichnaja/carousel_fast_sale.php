<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle(""); ?>
<?

CModule::IncludeModule("iblock");
$iblockId = 3;
$sectionId = 16;
$arFilter = Array('IBLOCK_ID' => $iblockId, 'GLOBAL_ACTIVE'=>'Y', 'ID' => $sectionId);
$arSelect = array(
    "ID",
    "IBLOCK_ID",
    "NAME",
    "PICTURE",
    "DESCRIPTION",
    "CODE",
    "DETAIL_PICTURE",
    "UF_DESCRIPTION"
);
?>
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
    background-color:#005ea4;
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
    width:auto;
    clear:both;
height: 26px;
overflow: hidden;
}

.fast-content .adress-and-metro .col
{
    float:left;/*fix for  buggy browsers*/
    display:table-column;       

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

.fast_sale_carousel
{
display:none;
}
    
.fast-carousel-block
{
    width: 980px;
    overflow: hidden;
    padding: 0px 42px;
}

.fast-carousel-block h2
{
    color: #383838; 
    text-transform: uppercase; 
    margin-top: 12px; 
    margin-bottom: 18px;
    font-size: 22px; 
    
}

.fast-carousel-block .showAllFastSalesLink
{
    display:block;
    float:right;
    clear:'both';
    margin-bottom: 23px;
}
</style>

<? if (CModule::IncludeModule("iblock")) : ?>
<?
	$iblock_id = 8;

	$my_elements = CIBlockElement::GetList (
	  Array("ID" => "ASC"),
	  Array("IBLOCK_ID" => $iblock_id),
	  false,false,
	  Array("ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_FAST_SALE","PROPERTY_COAST","PROPERTY_ADDRESS","PROPERTY_SUBWAYS","PROPERTY_RED_LABEL_MARK")
	);
?>

<div class="fast-carousel-block">
    
    <h2>Срочная продажа</h2>
    
    <div class="fast_sale_carousel">
    

    <?	while($arFields = $my_elements->GetNext()) {
        
        if ($arFields['PROPERTY_FAST_SALE_ENUM_ID'] == 709) 
        { 
            $db_props = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields['ID'], "sort", "asc", Array("CODE"=>"MORE_PHOTO"));
            $img_path = "";
        
            while($ob = $db_props->Fetch()) 
            {
                if ($ob["VALUE"]) $img_path = CFile::GetPath($ob["VALUE"]);
            } 
    ?>
    <div>
        <div class="fast-content">

            <a href="<?=$arFields['DETAIL_PAGE_URL'];?>">
            <div class="pic" style="background: url('<? echo $img_path; ?>') no-repeat; background-size: cover;"></div>
             
            <? if ($arFields['PROPERTY_RED_LABEL_MARK_VALUE']) : ?> 
                <div class="redlabel"><?=$arFields['PROPERTY_RED_LABEL_MARK_VALUE'];?></div>
            <? endif; ?>
            <div class="coast">
                <?
                    echo "<b>".number_format($arFields['PROPERTY_COAST_VALUE'], 0, '.', ' ')."</b> руб.";
                ?>
            </div>
            <div class="adress-and-metro">
                <div class="row">
                    <div class="col" style="padding-right: 10px;"><b>Адрес:</b></div>
                    <div class="col"><?=$arFields['PROPERTY_ADDRESS_VALUE'];?></div>
                </div>
                <div class="row">
                    <div class="col" style="padding-right: 10px;"><b>Метро:</b></div>
                    <div class="col"><?=$arFields['PROPERTY_SUBWAYS_VALUE'];?></div>
                </div>
            </div></a>
        </div>
    </div>

				<? } //if = 709 

		} //while
?>

</div>
<div class="showAllFastSalesLink"><a href="/fastsales/">Смотреть все срочные продажи</a></div>
</div>

<div style="font-size: 15px; background-color: #F1FAFF;padding-left: 40px; padding-right: 40px;text-align:center;"> Эти квартиры в срочной продаже, поэтому возможен торг!</div>

<? endif; ?>



<script type="text/javascript">
    $(document).ready(function(){

var func = $('.fast_sale_carousel').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
            prevArrow: '<div class="slick-prev"><img src="/vtorichnaja/images/arr_lt.png" alt=""/></div>',
            nextArrow: '<div class="slick-next"><img src="/vtorichnaja/images/arr_rt.png" alt=""/></div>',
        });

$.when(func).done(function () {
$('.fast_sale_carousel').css('display','block');
});

    });
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>