<?$imageArray = array();
foreach ($arResult["PROPERTIES"]["MULTI_IMAGES"]["VALUE"] as $key => $value) {
$Image = CFile::GetFileArray($value);
$imageArray[] = array("SRC" => $Image["SRC"], "DESCRIPTION" => $arResult["PROPERTIES"]["DESCRIPTION_MULTI_IMAGES"]["VALUE"][$key]);
}
print_pre($arResult["PROPERTIES"]["MULTI_IMAGES"]["VALUE"]);
?>
<ul class="fotoList">
    <? foreach ($imageArray as $value) {
        ?>
        <li>
            <img class='popupImage2' data-src='<?= $value["SRC"]; ?>' data-alt='<?= $value["DESCRIPTION"]; ?>' src="/thumb/238x155xcut<?= $value["SRC"]; ?>" alt="<?= $value["DESCRIPTION"]; ?>" title="<?= $value["DESCRIPTION"]; ?>" width="238" height="155"/>

            <p><?= $value["DESCRIPTION"]; ?></p>
        </li>
    <?
    } ?>
</ul>
<div class="popupFullScreen2">
    <div class="popupFullScreenImage2">
        <div class="closeElementPopUp2" onclick="$('.popupFullScreen2').fadeOut();$('.popUpWindowOverlayImage').fadeOut();"></div>
        <div class="innerPopup"></div>
        <div class="innerLabel"></div>
    </div>
</div>
