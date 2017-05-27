<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();  
    if (empty($arParams["SEO"]["PROPERTIES"]["LOGO_DEVELOPER"]["VALUE"])){
        $wdthFull = " style='width: 980px;'";
    }else{
        $wdthFull = "";
    }
    if (!empty($arParams["SEO"]["PROPERTIES"]["ZAG_FOR_MAIN"]["VALUE"])) {
        $zagM = $arParams["SEO"]["PROPERTIES"]["ZAG_FOR_MAIN"]["VALUE"];
    } else {
        $zagM = $arParams["SEO"]["NAME"];
    }
    if ($arParams["PAGE"] == "OBJ") {
        if (!empty($arParams["SEO"]["PROPERTIES"]["TITLE_OBJECT"]["VALUE"])) {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["PROPERTIES"]["TITLE_OBJECT"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["NAME"] . " похожие объекты");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["DESCRIPTION_OBJECT"]["VALUE"])) {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["PROPERTIES"]["DESCRIPTION_OBJECT"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["NAME"] . " похожие объекты");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["KEYWORD_OBJECT"]["VALUE"])) {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["PROPERTIES"]["KEYWORD_OBJECT"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["NAME"] . " похожие объекты");
        }
        ?><? if (!empty($arParams["SEO"]["PROPERTIES"]["ZAG_FOR_OBJECT"]["VALUE"])) {
                echo $arParams["SEO"]["PROPERTIES"]["ZAG_FOR_OBJECT"]["VALUE"];
            } else {
                echo $zagM."<span>: похожие объекты</span>";
            } ?><? } elseif ($arParams["PAGE"] == "JOB") {
        if (!empty($arParams["SEO"]["PROPERTIES"]["TITLE_WORK"]["VALUE"])) {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["PROPERTIES"]["TITLE_WORK"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["NAME"] . " ход строительства");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["DESCRIPTION_WORK"]["VALUE"])) {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["PROPERTIES"]["DESCRIPTION_WORK"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["NAME"] . " ход строительства");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["KEYWORD_WORK"]["VALUE"])) {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["PROPERTIES"]["KEYWORD_WORK"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["NAME"] . " ход строительства");
        }
        ?><? if (!empty($arParams["SEO"]["PROPERTIES"]["ZAG_FOR_WORK"]["VALUE"])) {
                echo $arParams["SEO"]["PROPERTIES"]["ZAG_FOR_WORK"]["VALUE"];
            } else {
                echo $zagM. "<span>: ход строительства</span>";
            } ?><? } elseif ($arParams["PAGE"] == "FOTO") {
        if (!empty($arParams["SEO"]["PROPERTIES"]["TITLE_PHOTO"]["VALUE"])) {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["PROPERTIES"]["TITLE_PHOTO"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["NAME"] . " фото");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["DESCRIPTION_PHOTO"]["VALUE"])) {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["PROPERTIES"]["DESCRIPTION_PHOTO"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["NAME"] . " фото");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["KEYWORD_PHOTO"]["VALUE"])) {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["PROPERTIES"]["KEYWORD_PHOTO"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["NAME"] . " фото");
        }
        ?><? if (!empty($arParams["SEO"]["PROPERTIES"]["ZAG_FOR_PHOTO"]["VALUE"])) {
                echo $arParams["SEO"]["PROPERTIES"]["ZAG_FOR_PHOTO"]["VALUE"];
            } else {
                echo $zagM. "<span>: фото</span>";
            } ?><? } elseif ($arParams["PAGE"] == "SLAVE") {
        if (!empty($arParams["SEO"]["PROPERTIES"]["TITLE_IPOTEKY"]["VALUE"])) {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["PROPERTIES"]["TITLE_IPOTEKY"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["NAME"] . " ипотека");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["DESCRIPTION_IPOTEKY"]["VALUE"])) {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["PROPERTIES"]["DESCRIPTION_IPOTEKY"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["NAME"] . " ипотека");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["KEYWORD_IPOTEKY"]["VALUE"])) {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["PROPERTIES"]["KEYWORD_IPOTEKY"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["NAME"] . " ипотека");
        }
        ?><? if (!empty($arParams["SEO"]["PROPERTIES"]["ZAG_FOR_IPOTEKY"]["VALUE"])) {
                echo $arParams["SEO"]["PROPERTIES"]["ZAG_FOR_IPOTEKY"]["VALUE"];
            } else {
                echo $zagM. "<span>: квартиры в ипотеку</span>";
            } ?><? } elseif ($arParams["PAGE"] == "CALC") {
        if (!empty($arParams["SEO"]["PROPERTIES"]["TITLE_ZACHET"]["VALUE"])) {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["PROPERTIES"]["TITLE_ZACHET"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["NAME"] . " зачет жилья");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["DESCRIPTION_ZACHET"]["VALUE"])) {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["PROPERTIES"]["DESCRIPTION_ZACHET"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["NAME"] . " зачет жилья");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["KEYWORD_ZACHET"]["VALUE"])) {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["PROPERTIES"]["KEYWORD_ZACHET"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["NAME"] . " зачет жилья");
        }
        ?><? if (!empty($arParams["SEO"]["PROPERTIES"]["ZAG_FOR_ZACHET"]["VALUE"])) {
                echo $arParams["SEO"]["PROPERTIES"]["ZAG_FOR_ZACHET"]["VALUE"];
            } else {
                echo 'Покупка квартиры в ' .$zagM. "<span>: система зачета жилья</span>";
            } ?><? } elseif ($arParams["PAGE"] == "PRC") {
        if (!empty($arParams["SEO"]["PROPERTIES"]["TITLE_PRICE"]["VALUE"])) {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["PROPERTIES"]["TITLE_PRICE"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["NAME"] . " цены на квартиры");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["DESCRIPTION_PRICE"]["VALUE"])) {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["PROPERTIES"]["DESCRIPTION_PRICE"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["NAME"] . " цены на квартиры");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["KEYWORD_PRICE"]["VALUE"])) {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["PROPERTIES"]["KEYWORD_PRICE"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["NAME"] . " цены на квартиры");
        }
        ?><? if (!empty($arParams["SEO"]["PROPERTIES"]["ZAG_FOR_PRICE"]["VALUE"])) {
                echo $arParams["SEO"]["PROPERTIES"]["ZAG_FOR_PRICE"]["VALUE"];
            } else {
                echo $zagM. "<span>: цены на квартиры</span>";
            } ?><? } elseif ($arParams["PAGE"] == "PLAN") {
        if (!empty($arParams["SEO"]["PROPERTIES"]["TITLE_PLAN"]["VALUE"])) {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["PROPERTIES"]["TITLE_PLAN"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["NAME"] . " планировки");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["DESCRIPTION_PLAN"]["VALUE"])) {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["PROPERTIES"]["DESCRIPTION_PLAN"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["NAME"] . " планировки");
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["KEYWORD_PLAN"]["VALUE"])) {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["PROPERTIES"]["KEYWORD_PLAN"]["VALUE"]);
        } else {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["NAME"] . " планировки");
        }
        ?><? if (!empty($arParams["SEO"]["PROPERTIES"]["ZAG_FOR_PLAN"]["VALUE"])) {
                echo $arParams["SEO"]["PROPERTIES"]["ZAG_FOR_PLAN"]["VALUE"];
            } else {
                echo $zagM. "<span>: планировки квартир</span>";
            } ?><? } elseif ($arParams["PAGE"] == "MAIN") {
        if (!empty($arParams["SEO"]["PROPERTIES"]["TITLE_MAIN"]["VALUE"])) {
            $APPLICATION->SetPageProperty('title', $arParams["SEO"]["PROPERTIES"]["TITLE_MAIN"]["VALUE"]);
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["DESCRIPTION_MAIN"]["VALUE"])) {
            $APPLICATION->SetPageProperty('description', $arParams["SEO"]["PROPERTIES"]["DESCRIPTION_MAIN"]["VALUE"]);
        }
        if (!empty($arParams["SEO"]["PROPERTIES"]["KEYWORD_MAIN"]["VALUE"])) {
            $APPLICATION->SetPageProperty('keywords', $arParams["SEO"]["PROPERTIES"]["KEYWORD_MAIN"]["VALUE"]);
        }
        if (empty($arParams["SEO"]["PROPERTIES"]["ZAG_FOR_MAIN"]["VALUE"])) {
            ?><?= $arParams["SEO"]["NAME"]?><? } else {
            ?><?= $arParams["SEO"]["PROPERTIES"]["ZAG_FOR_MAIN"]["VALUE"]?><?
        }

    } ?>