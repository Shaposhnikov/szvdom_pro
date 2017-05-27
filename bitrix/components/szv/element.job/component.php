<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

    $arResult["PROPERTIES"]["MULTI_IMAGES_JOB"]["VALUE"]  = $arParams["MULTI_IMAGE_JOB"];
    $arResult["PROPERTIES"]["DESCRIPTION_MULTI_IMAGES_JOB"]["VALUE"] = $arParams["MULTI_IMAGE_DESC_JOB"];
        $imageArray2 = array();
    foreach ($arResult["PROPERTIES"]["MULTI_IMAGES_JOB"]["VALUE"] as $key => $value) {
        $Image2 = CFile::GetFileArray($value);
        $imageArray2[] = array("SRC" => $Image2["SRC"], "DESCRIPTION" => (!empty($Image2["DESCRIPTION"]))?$Image2["DESCRIPTION"]:$arResult["PROPERTIES"]["DESCRIPTION_MULTI_IMAGES_JOB"]["VALUE"][$key]);
    } ?>
    <ul class="fotoList">
        <? foreach ($imageArray2 as $value) {
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