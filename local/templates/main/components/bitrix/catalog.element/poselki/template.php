<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;


use Bitrix\Main\Loader;

$this->addExternalCss(SITE_TEMPLATE_PATH."/fancybox.css");
$this->addExternalJs(SITE_TEMPLATE_PATH."/fancybox.umd.js");

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$actualItem = $arResult;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);

$productType = $arResult['PRODUCT']['TYPE'];

global $arPhotos;

$arPhotos = $arResult['MORE_PHOTO'];

function printPhoto($src, $descr) {
	?><a href="<?=$src?>" data-fancybox="gallery" data-caption="<?=$descr?>" title="<?=$descr?>"><div class="thumbnail" style="background-image:url('<?=$src?>')"></div></a><?
}

//print("<pre>"); print_r($arResult['DISPLAY_PROPERTIES']); print("</pre>"); 

$lots = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 6, "ACTIVE" => "Y", "PROPERTY_poselok" => $actualItem["ID"]), false, false, Array('PROPERTY_status', 'PROPERTY_ssquare', 'PROPERTY_price', 'PROPERTY_sprice'));

$MAX_VAL = 1000000000;

$lots_count = 0;
$lots_for_sale = 0;
$minSquare = $MAX_VAL;
$maxSquare = 0;
$minPrice = $MAX_VAL;
$maxPrice = 0; 
$minSPrice = $MAX_VAL;

while($lot = $lots->GetNext())
{
	if(($lot['PROPERTY_STATUS_VALUE'] != "продан") && ($lot['PROPERTY_PRICE_VALUE'] > 0)) {
		$lots_for_sale++;
		if ($lot['PROPERTY_PRICE_VALUE'] > $maxPrice) {
			$maxPrice = $lot['PROPERTY_PRICE_VALUE'];
		} 
		if ($lot['PROPERTY_PRICE_VALUE'] < $minPrice && $lot['PROPERTY_PRICE_VALUE'] > 0) {
			$minPrice = $lot['PROPERTY_PRICE_VALUE'];
		}
		if ($lot['PROPERTY_SPRICE_VALUE'] < $minSPrice && $lot['PROPERTY_SPRICE_VALUE'] > 0) {
			$minSPrice = $lot['PROPERTY_SPRICE_VALUE'];
		}
	}
	$currSquare = round($lot['PROPERTY_SSQUARE_VALUE']);
	if ($currSquare > $maxSquare) {
		$maxSquare = $currSquare;
	} 
	if ($currSquare < $minSquare) {
		$minSquare = $currSquare;
	}
	$lots_count++;
}

$_lots_count = $lots_count % 10;
$_lots_for_sale = $lots_for_sale % 10;

function print_rows($vals) {
	if(is_array($vals)) {
		$text = "";
		foreach($vals as $i => $val) {
			if($i < 5) {
				?><div class="rdata"><?=$val?></div><?
			} else {
				$text .= $val.". ";
			}
		}
		if ($text != "") {
			?><div class="rdataall"><?=$text?></div><?
		}
	} else {
		?><div class="rdata"><?=$vals?></div><?
	}
}

?>
<script>
	window.addEventListener('b24:form:init', (event) => {
	let form = event.detail.object;
	form.setProperty("object_name", "<?=$actualItem['NAME']?>");
	});
</script>
<div class="content mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok" id="<?=$actualItem['ID']?>" itemscope itemtype="http://schema.org/Product">
		<div class="row align-items-center">
			<div class="col-12 col-md-6 textcard">
				<div class="label">
                    <?if($actualItem['DISPLAY_PROPERTIES']['pays']['DISPLAY_VALUE'] != ""){?>
                        <div class="bk"><?=$actualItem['DISPLAY_PROPERTIES']['pays']['DISPLAY_VALUE']?></div>
                    <?}?>
                    <?if($actualItem['DISPLAY_PROPERTIES']['trigger']['DISPLAY_VALUE'] != ""){?>
                        <div class="bk"><?=$actualItem['DISPLAY_PROPERTIES']['trigger']['DISPLAY_VALUE']?></div>
                    <?}?>
                    <?if($actualItem['DISPLAY_PROPERTIES']['IZS']['DISPLAY_VALUE'] != "!Да"){?>
                        <div class="izs">ИЖС</div>
                    <?}?>
                </div>
				<div class="h1"><?=$actualItem["NAME"]?></div>
				<div class="hr"></div>
				<div class="address">Московская область<?if($actualItem['DISPLAY_PROPERTIES']['area']['DISPLAY_VALUE'] != ""){?>, <?=$actualItem['DISPLAY_PROPERTIES']['area']['DISPLAY_VALUE']?><?}?></div>
				<div class="placement"><?if($actualItem['DISPLAY_PROPERTIES']['road']['DISPLAY_VALUE'] != "") { print_shosse($actualItem); }?></div>
				<div class="opts">
					<?if($actualItem['DISPLAY_PROPERTIES']['mkad']['DISPLAY_VALUE'] > 0){?><div class="opt"><div class="big"><span><?=$actualItem['DISPLAY_PROPERTIES']['mkad']['DISPLAY_VALUE']?></span> км</div><div>Расстояние<br>от МКАД</div></div><?}?>
					<?if($actualItem['DISPLAY_PROPERTIES']['mmkad']['DISPLAY_VALUE'] > 0){?><div class="opt"><div class="big"><span><?=$actualItem['DISPLAY_PROPERTIES']['mmkad']['DISPLAY_VALUE']?></span> <?=minut($actualItem['DISPLAY_PROPERTIES']['mmkad']['DISPLAY_VALUE'])?></div><div>Время в<br>пути</div></div><?}?>
					<div class="opt hr"></div>
					<?if($lots_count > 0){?><div class="opt"><div class="big"><span><?=$lots_count?></span></div><div><?=getLotsEnd($lots_count, true)?> в<br>поселке</div></div><?}?>
					<?if($maxSquare > 0){?><div class="opt"><div class="big"><span><?=makeDiapazone($minSquare, $maxSquare)?></span> соток</div><div>Участки</div></div><?}?>
				</div>
				<div class="price">
					<?if($minSPrice > 0 && $minSPrice != $MAX_VAL){?><span class="price_ot">участки от <span><?=formatNum($minSPrice)?></span> ₽</span><?} else {?><span class="sold_out">Все участки проданы</span><?}?>
					<?if(($minPrice > 0 && $minPrice != $MAX_VAL) || $maxPrice > 0){?><span class="price_ps"><?=makeDiapazone($minPrice, $maxPrice)?> ₽ за сотку</span><?}?>
				</div>
				<div class="infra d-flex flex-wrap"><?
$icons = Array();
$titles = Array();

if(is_array($actualItem['PROPERTIES']['facility_icons']['VALUE'])) {
	foreach($actualItem['PROPERTIES']['facility_icons']['VALUE'] as $key=>$val) {
		if($val == "roads") {
			array_unshift($icons, $val);
			array_unshift($titles, $actualItem['PROPERTIES']['facility_items']['VALUE'][$key]);
		} else {
			$icons[] = $val;
			$titles[] = $actualItem['PROPERTIES']['facility_items']['VALUE'][$key];
		}
	}
} else {
	$icons[0] = $actualItem['PROPERTIES']['facility_icons']['VALUE'];
	$titles[0] = $actualItem['PROPERTIES']['facility_items']['VALUE'];
} 

foreach($icons as $key=>$icon) {
	echo "<div class='icn'><div class='icn_i'><i class='mso mi mi_".$icon."' title='".$titles[$key]."'></i></div><div class='icn_t'>".decode_icn($icon)."</div></div>";
}
				?></div>
				<div class="buttons">
					<a class="button" onclick="show_bron('Хочу купить участок в поселке «<?=$actualItem["NAME"]?>»')">Оставить заявку</a><a href="#lots" class="button frbtn">Участки</a><a href="#kommun" class="button frbtn">Коммуникации</a><a href="#infra" class="button frbtn">Инфраструктура</a><a href="#place" class="button frbtn">Расположение</a>
				</div>
			</div>
			<div class="col-12 col-md-6"><?
if(is_array($actualItem['MORE_PHOTO']) || $actualItem['DETAIL_PICTURE']['SRC'] != "") {
	$PhotoCount = count($actualItem['MORE_PHOTO']);
	?>
				<div class="mainpicture_cont w-100"><a id="mainpicture_a" href="javascript:;" data-fancybox-trigger="gallery" data-fancybox-index="0"><div id="mainpicture" style="background-image: url(<?=($actualItem['DETAIL_PICTURE']['SRC'] != "")?$actualItem['DETAIL_PICTURE']['SRC']:$actualItem['MORE_PHOTO'][0]['SRC']?>)" class="w-100"></div></a></div>
				<div class="slider row align-items-center">
					<div class="left_arr col-2 col-sm-1 col-md-2 col-lg-1"><a id="gal_left"><i class="mso mi mi_larr"></i></a></div>
					<div class="photos_slider col-8 col-sm-10 col-md-8 col-lg-10"><div class="row"><?
		$start_from = 0;
		if($actualItem['DETAIL_PICTURE']['SRC'] != "") {
						?><div class="col-4 col-sm-3 col-md-4 col-lg-3 col-xl-2 col_prv" id="col_prv0"><a id="thumbnail0" class="thumbnail sel" data-fancybox-index="0" href="<?=$actualItem['DETAIL_PICTURE']['SRC']?>" data-fancybox="gallery" data-caption="" title=""><div class="thumbnail" style="background-image:url('<?=$actualItem['DETAIL_PICTURE']['SRC']?>')"></div></a></div><?
			$start_from++;
		}
		for($i = 0; $i < $PhotoCount; $i++) {
						?><div class="col-4 col-sm-3 col-md-4 col-lg-3 col-xl-2 col_prv" id="col_prv<?=($i+$start_from)?>"><a id="thumbnail<?=($i+$start_from)?>" class="thumbnail<?($start_from == 0)?" sel":""?>" data-fancybox-index="<?=($i+$start_from)?>" href="<?=$actualItem['MORE_PHOTO'][$i]['SRC']?>" data-fancybox="gallery" data-caption="<?=$actualItem['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$i]?>" title="<?=$actualItem['PROPERTIES']['MORE_PHOTO']['DESCRIPTION'][$i]?>"><div class="thumbnail" style="background-image:url('<?=$actualItem['MORE_PHOTO'][$i]['SRC']?>')"></div></a></div><?
		}
?><script type="text/javascript">
Fancybox.bind('[data-fancybox="gallery"]', {
	Images: {
	initialSize: "fit",
	protected: true,
	},
});
</script><?
}
					?></div></div>
					<div class="right_arr col-2 col-sm-1 col-md-2 col-lg-1"><a id="gal_right"><i class="mso mi mi_rarr"></i></a></div>
				</div><a id="plan"></a>
			</div>
		</div><?
if($actualItem['PROPERTIES']['video']['VALUE'] != "") {
		?><div class="mt-5 mb-5"><iframe width="100%" height="500" src="<?=$actualItem['PROPERTIES']['video']['VALUE']?>" frameBorder="0" allow="clipboard-write; autoplay" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div><?
}
		?><div class="h2 mb-0">Генплан</div>
	</div>
</div></div></div></div>
<div class="canvas">
    <div id="map_lands" style="height: 500px; width: 100%;"></div>
    <div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
                    <div class="elem-poselok">
                        <div class="container lands_legend">
                            <div class="lands_title">Стоимость земли:</div>
                            <div class="row_colors"><?
                                $units = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 6, "ACTIVE" => "Y", "PROPERTY_poselok" => $actualItem["ID"]), false, false, Array('ID', 'PROPERTY_price', 'PROPERTY_old_price', 'PROPERTY_text_sale', 'PROPERTY_status'));
                                $prices = [];
                                $oldPrices = [];
                                $saleTexts = [];
                                $colors = [];
                                while($unit = $units->GetNext())
                                {
                                    if($unit['PROPERTY_PRICE_VALUE'] > 0 && !in_array($unit['PROPERTY_PRICE_VALUE'], $prices)) {
                                        if($unit['PROPERTY_STATUS_VALUE'] != 'продан') {
                                            $prices[] = $unit['PROPERTY_PRICE_VALUE'];
                                        }
                                        // Сохраняем старую цену, если есть
                                        if($unit['PROPERTY_OLD_PRICE_VALUE'] > 0) {
                                            $oldPrices[$unit['PROPERTY_PRICE_VALUE']] = $unit['PROPERTY_OLD_PRICE_VALUE'];
                                        }

                                        // Сохраняем текст акции, если есть
                                        if($unit['PROPERTY_TEXT_SALE_VALUE']) {
                                            $saleTexts[$unit['PROPERTY_PRICE_VALUE']] = $unit['PROPERTY_TEXT_SALE_VALUE'];
                                        }
                                    }
                                }

                                sort($prices);
                                $pCount = count($prices);

                                global $arrPriceColors;
                                if($pCount > 0) {
                                    fill_arrPriceColors($prices);
                                }

                                if($pCount > 0 && $pCount <= 6) {
                                    for ($i = 0; $i < $pCount; $i++) {
                                        $currentPrice = $prices[$i];
                                        $hasOldPrice = isset($oldPrices[$currentPrice]);
                                        $hasSaleText = isset($saleTexts[$currentPrice]);

                                        $colors[$prices[$i]] = hsl2hex(array(($i/$pCount) * 0.9, 1, (0.45 + 0.15*($i % 2))));
                                        ?><div class="ll_item position-relative">
                                        <div class="ll_color" style="background: <?=$colors[$currentPrice]?>;"></div>
                                        <div class="ll_label">
                                            <?if($hasOldPrice):?>
                                                <div class="price-with-discount">
                                    <span class="old-price" style="text-decoration: line-through; color: #999; font-size: 0.9em;">
                                        <?=formatNum($oldPrices[$currentPrice])?> ₽/сотка
                                    </span>
                                                    <span class="new-price" style="color: #d60000; font-weight: bold;">
                                        <?=formatNum($currentPrice)?> ₽/сотка
                                    </span>
                                                </div>
                                            <?else:?>
                                                <?=formatNum($currentPrice)?> ₽/сотка
                                            <?endif;?>

                                            <?if($hasSaleText):?>
                                                <div class="sale-text" style="color: #ff0000; margin-top: 2px;">
                                                    <?=$saleTexts[$currentPrice]?>
                                                </div>
                                            <?endif;?>

                                        </div>
                                        </div><?
                                    }
                                } else if ($pCount > 6) {
                                    $lotpricedot = ($prices[$pCount-1] - $prices[0])/14;
                                    $lotpricedelta = $prices[$pCount-1] - $prices[0];
                                    for ($i = 0; $i < $pCount; $i++) {
                                        $colors[$prices[$i]] = hsl2hex(array(getPriceColor($prices[$i]), 1, 0.5));
                                    }
                                    ?>
                                    <div class="gradprice_cont">
                                        <div class="row gradprice_bar"><?for($i = 0; $i < count($arrPriceColors); $i++) {?><div class="col" style="background-image: linear-gradient(90deg, hsl(<?=$arrPriceColors[$i]["from"]?>, 100%, 50%), hsl(<?=$arrPriceColors[$i]["to"]?>, 100%, 50%));"></div><?}?></div>
                                        <div class="row dots"><div class="col"><div class="leftdot"></div></div><?for($i = 1; $i <= 5; $i++) {?><div class="col<?if($i != 3) {echo " d-none d-sm-block";}?>"><div class="centerdot"></div></div><?}?><div class="col"><div class="rightdot"></div></div></div>
                                        <div class="row caption">
                                            <div class="col text-left">
                                                <?=formatNum($prices[0])?><br>
                                                <?if(isset($oldPrices[$prices[0]])):?>
                                                    <span class="old-price">
                                                    <?=formatNum($oldPrices[$prices[0]])?>
                                                </span>
                                                    <br>
                                                <?endif;?>
                                                <span class="pdedizm">₽/сотка</span>
                                                <?if(isset($saleTexts[$prices[0]])):?>
                                                    <div class="sale-text-mini">
                                                        <?=$saleTexts[$prices[0]]?>
                                                    </div>
                                                <?endif;?>
                                            </div>
                                            <?for($i = 1; $i <= 5; $i++) {?>
                                                <?php
                                                $repPrice = get_reper_price($prices[0], $lotpricedot, $i);
                                                ?>
                                                <div class="col text-center<?if($i != 3) {echo " d-none d-sm-block";}?>">
                                                    <?php
                                                    // Находим ближайшую реальную цену для отображения скидки
                                                    $closestPrice = null;
                                                    $closestOldPrice = null;
                                                    $closestSaleText = null;
                                                    foreach($prices as $price) {
                                                        if(abs($price - $repPrice) <= $lotpricedot) {
                                                            $closestPrice = $price;
                                                            if(isset($oldPrices[$price])) {
                                                                $closestOldPrice = $oldPrices[$price];
                                                            }
                                                            if(isset($saleTexts[$price])) {
                                                                $closestSaleText = $saleTexts[$price];
                                                            }
                                                            break;
                                                        }
                                                    }
                                                    ?>

                                                    <?=formatNum($repPrice)?><br>
                                                    <?if($closestOldPrice):?>
                                                        <span class="old-price">
                                                            <?=formatNum($closestOldPrice)?>
                                                        </span><br>
                                                    <?endif;?>
                                                    <span class="pdedizm">₽/сотка</span>

                                                    <?if($closestSaleText):?>
                                                        <div class="sale-text-mini">
                                                            <?=$closestSaleText?>
                                                        </div>
                                                    <?endif;?>
                                                </div>
                                            <?}?>
                                            <div class="col text-right">
                                                <?=formatNum($prices[$pCount-1])?><br>
                                                <?if(isset($oldPrices[$prices[$pCount-1]])):?>
                                                    <span class="old-price">
                                                        <?=formatNum($oldPrices[$prices[$pCount-1]])?>
                                                    </span><br>
                                                <?endif;?>
                                                <span class="pdedizm">₽/сотка</span>
                                                <?if(isset($saleTexts[$prices[$pCount-1]])):?>
                                                    <div class="sale-text-mini">
                                                        <?=$saleTexts[$prices[$pCount-1]]?>
                                                    </div>
                                                <?endif;?>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }
                                ?></div>
                        </div>
                    </div>
                </div></div></div></div>
</div>

<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok">
		<div class="row align-items-center cards pb-0">
			<div class="col-12 col-md-6">
				<div class="frame blue_form"><script data-b24-form="inline/4/club07" data-skip-moving="true">
(function(w,d,u){
var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
})(window,document,'https://cdn-ru.bitrix24.ru/b29466034/crm/form/loader_4.js');
				</script></div>
			</div>
			<div class="col-12 col-md-6 text-center"><a id="infra"></a>
				<div class="inner">
					<div class="h2 mt-3 mt-md-0">Инфраструктура</div>
					<div class="slogan"><?=$actualItem['PROPERTIES']['infra_slogan']['VALUE']?></div>
					<?=print_rows($actualItem['PROPERTIES']['infra_items']['VALUE'])?>
					<a id="lots"></a>
				</div>
			</div>
		</div>
		<div class="h2 mb-0 mt-4 mt-md-1">Участки в <?=$actualItem['DISPLAY_PROPERTIES']['name_p']['DISPLAY_VALUE']?></div>
	</div>
</div></div></div></div>
<div class="canvas">
	<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
<?
global $arrPreFilter;
$arrPreFilter['ACTIVE'] = "Y";
$arrPreFilter['>PROPERTY_SQUARE'] = 0;
$arrPreFilter['>PROPERTY_PRICE'] = 0;
$arrPreFilter['=PROPERTY_STATUS_VALUE'] = "в продаже";
$arrPreFilter['=PROPERTY_POSELOK'] = $actualItem["ID"];

$arAvailableSort = array(
	"num" => Array("PROPERTY_NUM", "asc"),
	"pricelow" => Array("PROPERTY_SPRICE", "asc"),
	"pricehigh" => Array("PROPERTY_SPRICE", "desc"),
	"squarelow" => Array("PROPERTY_SSQUARE", "asc"),
	"squarehigh" => Array("PROPERTY_SSQUARE", "desc"),
);
$sort = (array_key_exists("sort", $_REQUEST) && array_key_exists($_REQUEST["sort"], $arAvailableSort)) ? $_REQUEST["sort"] : 'num';

?><div class="sort_ord">
	<?if($sort != "pricelow"){?><a href="<?=$APPLICATION->GetCurPageParam('sort=pricelow',	array('sort'))?>#lots"><?} else {?><span><?}?>Сначала дешевле<?if($sort != "pricelow"){?></a><?} else {?></span><?}?>
	<?if($sort != "pricehigh"){?><a href="<?=$APPLICATION->GetCurPageParam('sort=pricehigh',	array('sort'))?>#lots"><?} else {?><span><?}?>Сначала дороже<?if($sort != "pricehigh"){?></a><?} else {?></span><?}?>
	<?if($sort != "squarelow"){?><a href="<?=$APPLICATION->GetCurPageParam('sort=squarelow',	array('sort'))?>#lots"><?} else {?><span><?}?>Сначала маленькие<?if($sort != "squarelow"){?></a><?} else {?></span><?}?>
	<?if($sort != "squarehigh"){?><a href="<?=$APPLICATION->GetCurPageParam('sort=squarehigh',	array('sort'))?>#lots"><?} else {?><span><?}?>Сначала большие<?if($sort != "squarehigh"){?></a><?} else {?></span><?}?>
</div><?

				$intSectionID = $APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					"slots",
					array(
						"IBLOCK_TYPE" => "lots",
						"IBLOCK_ID" => 6,
						"COLORS_ARRAY" => $colors,
						"MESS_BTN_SUBSCRIBE" => "#plan",
						"MESS_BTN_COMPARE" => "".$actualItem["CODE"],
						"ELEMENT_SORT_FIELD" => "SORT",
						"ELEMENT_SORT_ORDER" => "asc",
						"ELEMENT_SORT_FIELD2" => $arAvailableSort[$sort][0],
						"ELEMENT_SORT_ORDER2" => $arAvailableSort[$sort][1],
						"PROPERTY_CODE" => Array(),
						"PROPERTY_CODE_MOBILE" => Array(),
						"META_KEYWORDS" => '-',
						"META_DESCRIPTION" => '-',
						"BROWSER_TITLE" => '-',
						"SET_LAST_MODIFIED" => "",
						"INCLUDE_SUBSECTIONS" => "Y",
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
						"FILTER_NAME" => "arrPreFilter",
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_FILTER" => $arParams["CACHE_FILTER"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"SET_TITLE" => "N",
						"MESSAGE_404" => $arParams["~MESSAGE_404"],
						"SET_STATUS_404" => $arParams["SET_STATUS_404"],
						"SHOW_404" => $arParams["SHOW_404"],
						"FILE_404" => $arParams["FILE_404"],
						"DISPLAY_COMPARE" => "",
						"PAGE_ELEMENT_COUNT" => 12,
						"LINE_ELEMENT_COUNT" => 6,
						"PRICE_CODE" => $arParams["~PRICE_CODE"],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"PAGER_TITLE" => $arParams["PAGER_TITLE"],
						"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
						"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
						"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
						"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
						"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
						"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
						"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
						"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
						"LAZY_LOAD" => "Y",
						"MESS_BTN_LAZY_LOAD" => "Показать ещё",
						"LOAD_ON_SCROLL" => "N",

						"OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
						"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						"OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

						"SECTION_ID" => 0,
						"SECTION_CODE" => "",
						"SECTION_URL" => "/zemelnye-uchastki-v-moskovskoy-oblasti/#SECTION_CODE_PATH#/",
						"DETAIL_URL" => "/zemelnye-uchastki-v-moskovskoy-oblasti/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
						"USE_MAIN_ELEMENT_SECTION" => 1,
						'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						'HIDE_NOT_AVAILABLE' => "N",
						'HIDE_NOT_AVAILABLE_OFFERS' => "N",

						'LABEL_PROP' => $arParams['LABEL_PROP'],
						'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
						'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
						'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
						'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
						'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
						'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
						'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
						'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
						'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
						'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
						'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

						'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
						'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
						'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
						'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
						'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
						'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
						'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
						'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
						'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
						'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
						'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
						'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
						'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
						'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
						'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'] ?? '',
						'MESS_NOT_AVAILABLE_SERVICE' => $arParams['~MESS_NOT_AVAILABLE_SERVICE'] ?? '',

						'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
						'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
						'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

						'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
						"ADD_SECTIONS_CHAIN" => "N",
						'ADD_TO_BASKET_ACTION' => "ADD",
						'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
						'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
						'COMPARE_NAME' => $arParams['COMPARE_NAME'],
						'USE_COMPARE_LIST' => 'N',
						'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
						'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
						'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),

						'UID' => $arParams['UID']
					),
					$component
				);


?>
	</div></div></div></div>
</div>
<div class="content mt-1 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok">

		<div class="row align-items-center cards">
			<div class="col-12 col-md-6 text-center">
				<div class="inner">
					<div class="h2">Расположение</div>
					<div class="slogan"><?=$actualItem['PROPERTIES']['placement_slogan']['VALUE']?></div><a id="place"></a>
					<?=print_rows($actualItem['PROPERTIES']['placement_items']['VALUE'])?>
					<div class="yandexbtn buttons"><a target="_blank" href="yandexnavi://build_route_on_map?lat_to=<?=str_replace(', ', '&lon_to=', ''.$actualItem['PROPERTIES']['map_navig']['VALUE'])?>" class="button"><i class="mso mi mi_navig"></i>Маршрут в Яндекс Навигаторе</a></div>
				</div>
			</div>
			<div class="d-none d-md-block col-md-6"><div class="poselok-image w100" style="background-image: url('<?=($actualItem['PROPERTIES']['photonum_r']['VALUE'] > 0)?$actualItem['MORE_PHOTO'][$actualItem['PROPERTIES']['photonum_r']['VALUE'] - 1]['SRC']:$actualItem['MORE_PHOTO'][1]['SRC']?>')"></div></div>
		</div>

	</div>
</div></div></div></div>
<div id="map_location" style="height: 500px; width: 100%;"></div>
<div class="content mt-1 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok">

		<a id="kommun"></a>
		<div class="row align-items-center cards">
			<div class="d-none d-md-block col-md-6"><div class="poselok-image w100" style="background-image: url('<?=($actualItem['PROPERTIES']['photonum_k']['VALUE'] > 0)?$actualItem['MORE_PHOTO'][$actualItem['PROPERTIES']['photonum_k']['VALUE'] - 1]['SRC']:$actualItem['MORE_PHOTO'][2]['SRC']?>')"></div></div>
			<div class="col-12 col-md-6 text-center">
				<div class="inner">
					<div class="h2">Коммуникации</div>
					<div class="slogan"><?=$actualItem['PROPERTIES']['facility_slogan']['VALUE']?></div>
					<?=print_rows($actualItem['PROPERTIES']['facility_items']['VALUE'])?>
					<a id="buy"></a>
				</div>
			</div>
		</div>

		<div class="h2 mb-0 mt-2">Варианты покупки</div>
	</div>
</div></div></div></div>
<div class="canvas">
	<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
		<?$APPLICATION->IncludeFile(SITE_DIR."include/buy.php", array(), array("MODE" => "html"));?>
		<div class="calc mt-4 mt-md-3 mt-lg-2 mt-xl-1 mb-5"><a class="button" href="/o-nas/calc/<?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>">Калькулятор ипотеки и рассрочки<i class="mso mi_rarr right"></i></a></div>
		<a id="nature"></a>
	</div></div></div></div>
</div>
<div class="content mt-1 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok">

		<div class="row align-items-center cards">
			<div class="col-12 col-md-6 order-md-1"><div class="poselok-image w100" style="background-image: url('<?=($actualItem['PROPERTIES']['photonum_p']['VALUE'] > 0)?$actualItem['MORE_PHOTO'][$actualItem['PROPERTIES']['photonum_p']['VALUE'] - 1]['SRC']:$actualItem['MORE_PHOTO'][3]['SRC']?>')"></div></div>
			<div class="col-12 col-md-6 text-center order-md-0">
				<div class="inner">
					<div class="h2 mt-5 mt-md-0">Природа</div>
					<div class="slogan"><?=$actualItem['PROPERTIES']['nature_slogan']['VALUE']?></div>
					<?=print_rows($actualItem['PROPERTIES']['nature_items']['VALUE'])?>
				</div>
			</div>
		</div>

		<meta itemprop="name" content="<?=$name?>" />

		<h2>Земельные участки в Московской области</h2>
		<div class="frame"><?print_lot_search_form(0)?></div>

<?
global $arrNearFilter;
$arrNearFilter = get_nearest_filter($actualItem['ID'], $actualItem["PROPERTIES"]["latlng"]["VALUE"]); 

if(count($arrNearFilter['ID']) > 0) {
?>
		<div class="h2 mb-0 mt-5">Похожие поселки</div>
	</div>
</div></div></div></div>
<div class="canvas">
	<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
<?
				$intSectionID = $APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					"sposelki",
					array(
						"IBLOCK_TYPE" => "sites",
						"IBLOCK_ID" => 5,
						"ELEMENT_SORT_FIELD" => "SORT",
						"ELEMENT_SORT_ORDER" => "asc",
						"ELEMENT_SORT_FIELD2" => "",
						"ELEMENT_SORT_ORDER2" => "",
						"PROPERTY_CODE" => Array(),
						"PROPERTY_CODE_MOBILE" => Array(),
						"META_KEYWORDS" => '-',
						"META_DESCRIPTION" => '-',
						"BROWSER_TITLE" => '-',
						"SET_LAST_MODIFIED" => "",
						"INCLUDE_SUBSECTIONS" => "Y",
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
						"FILTER_NAME" => "arrNearFilter",
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_FILTER" => $arParams["CACHE_FILTER"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"SET_TITLE" => "N",
						"MESSAGE_404" => $arParams["~MESSAGE_404"],
						"SET_STATUS_404" => $arParams["SET_STATUS_404"],
						"SHOW_404" => $arParams["SHOW_404"],
						"FILE_404" => $arParams["FILE_404"],
						"DISPLAY_COMPARE" => "",
						"PAGE_ELEMENT_COUNT" => 6,
						"LINE_ELEMENT_COUNT" => 6,
						"PRICE_CODE" => $arParams["~PRICE_CODE"],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"PAGER_TITLE" => $arParams["PAGER_TITLE"],
						"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
						"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
						"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
						"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
						"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
						"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
						"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
						"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
						"LAZY_LOAD" => "Y",
						"MESS_BTN_LAZY_LOAD" => "Показать ещё",
						"LOAD_ON_SCROLL" => "N",

						"OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
						"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						"OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

						"SECTION_ID" => 0,
						"SECTION_CODE" => "",
						"SECTION_URL" => "/#SECTION_CODE_PATH#/",
						"DETAIL_URL" => "/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
						"USE_MAIN_ELEMENT_SECTION" => 1,
						'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						'HIDE_NOT_AVAILABLE' => "N",
						'HIDE_NOT_AVAILABLE_OFFERS' => "N",

						'LABEL_PROP' => $arParams['LABEL_PROP'],
						'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
						'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
						'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
						'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
						'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
						'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
						'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
						'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
						'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
						'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
						'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

						'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
						'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
						'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
						'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
						'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
						'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
						'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
						'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
						'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
						'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
						'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
						'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
						'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
						'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
						'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'] ?? '',
						'MESS_NOT_AVAILABLE_SERVICE' => $arParams['~MESS_NOT_AVAILABLE_SERVICE'] ?? '',
						'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

						'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
						'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
						'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

						'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
						"ADD_SECTIONS_CHAIN" => "N",
						'ADD_TO_BASKET_ACTION' => "ADD",
						'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
						'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
						'COMPARE_NAME' => $arParams['COMPARE_NAME'],
						'USE_COMPARE_LIST' => 'N',
						'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
						'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
						'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),

						'UID' => $arParams['UID']
					),
					$component
				);
?>
                <?if($actualItem['PROPERTIES']['seo_anchor_for_similar_villages']['VALUE']):?>
                    <div class="seo_anchor_similar_villages">
                        <p><?=$actualItem['PROPERTIES']['seo_anchor_for_similar_villages']['VALUE'];?></p>
                    </div>
                <?endif;?>
	</div></div></div></div>
</div>
<div class="content mt-5 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok">
<?} else {
?><div class="mt-4"></div><?
}?>

		<div class="frame banner"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
	</div>
</div></div></div></div>
<script type="text/javascript" src="https://<?=$_SERVER["HTTP_HOST"]?>/js/map/?type=map&mode=poselki_lots&id=<?=$actualItem["ID"]?><?if($_GET["uid"] != ""){ echo "&uid=".$_GET["uid"]; }?>"></script>
