<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

$this->addExternalCss(SITE_TEMPLATE_PATH."/components/bitrix/catalog.element/poselki/style.css");

$this->addExternalCss(SITE_TEMPLATE_PATH."/fancybox.css");
$this->addExternalJs(SITE_TEMPLATE_PATH."/fancybox.umd.js");


$this->addExternalCss("/calc/style.css");
$this->addExternalJs("/calc/jquery-ui.min.js");
$this->addExternalJs("/calc/jquery.ui.touch-punch.min.js");
$this->addExternalJs("/calc/script.js");

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
global $kadastr;

$poselokID = $arResult['DISPLAY_PROPERTIES']['poselok']['VALUE'];
if(!$poselokID) {
	$poselokID = 0;
}

$poselok_name = "";
$poselok_img = "";
$poselok_pay = "";
$poselok_trigger = "";
$poselok_url = "";
$poselok_facility_slogan = "";
$poselok_facility_icons = "";
$poselok_infra_slogan = "";
$poselok_infra_items = "";
$poselok_placement_slogan = "";
$poselok_placement_items = "";
$poselok_nature_slogan = "";
$poselok_nature_items = "";
$poselok_infra_name_p = "";
$poselok_name_p = "";
$poselok_code = "";
$poselok_description = "";

$poselok_obj = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "ID" => $poselokID), false, false, Array('IBLOCK_ID ', 'ID', 'NAME', 'PROPERTY_MORE_PHOTO', 'DETAIL_PICTURE', 'DETAIL_TEXT', 'PREVIEW_PICTURE', 'PROPERTY_PHOTONUM', 'PROPERTY_PHOTONUM_K', 'PROPERTY_PHOTONUM_P', 'PROPERTY_PHOTONUM_R', 'PROPERTY_PAYS', 'PROPERTY_TRIGGER','PROPERTY_FACILITY_SLOGAN', 'PROPERTY_FACILITY_ICONS', 'PROPERTY_FACILITY_ITEMS', 'PROPERTY_INFRA_SLOGAN', 'PROPERTY_INFRA_ITEMS', 'PROPERTY_PLACEMENT_SLOGAN', 'PROPERTY_PLACEMENT_ITEMS', 'PROPERTY_NATURE_SLOGAN', 'PROPERTY_NATURE_ITEMS', 'DETAIL_PAGE_URL', 'PROPERTY_NAME_P', 'PROPERTY_SEO_ANCHOR_FOR_SIMILAR_VILLAGES'));
$poselok_info = $poselok_obj->GetNext();

$arPhotos = array();
$arPhotosDescr = array();
$property_num = -1;
$photonum_p = -1;
$photonum_k = -1;
$photonum_r = -1;

$_ssquare = $actualItem['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE'];
if($_ssquare > 0) {
	$_ssquare = round($_ssquare, 2);
}

if($poselok_info) {
	//echo "<pre>"; print_r($poselok_info); echo "</pre>"; 
	$property_num = $poselok_info['PROPERTY_PHOTONUM_VALUE'];
	$poselok_name = str_replace(" ", "&nbsp;", $poselok_info["NAME"]);
	$poselok_pay = $poselok_info["PROPERTY_PAYS_VALUE"];
    $poselok_trigger = $poselok_info["PROPERTY_TRIGGER_VALUE"];
	$poselok_url = $poselok_info["DETAIL_PAGE_URL"];
	$poselok_facility_slogan = $poselok_info["PROPERTY_FACILITY_SLOGAN_VALUE"];
	$poselok_facility_icons = $poselok_info["PROPERTY_FACILITY_ICONS_VALUE"];
	$poselok_facility_items = $poselok_info["PROPERTY_FACILITY_ITEMS_VALUE"];
	$poselok_infra_slogan = $poselok_info["PROPERTY_INFRA_SLOGAN_VALUE"];
	$poselok_infra_items = $poselok_info["PROPERTY_INFRA_ITEMS_VALUE"];
	$poselok_placement_slogan = $poselok_info["PROPERTY_PLACEMENT_SLOGAN_VALUE"];
	$poselok_placement_items = $poselok_info["PROPERTY_PLACEMENT_ITEMS_VALUE"];
	$poselok_nature_slogan = $poselok_info["PROPERTY_NATURE_SLOGAN_VALUE"];
	$poselok_nature_items = $poselok_info["PROPERTY_NATURE_ITEMS_VALUE"];
	$poselok_seo_anchor = $poselok_info["PROPERTY_SEO_ANCHOR_FOR_SIMILAR_VILLAGES_VALUE"];
	$photonum_p = $poselok_info['PROPERTY_PHOTONUM_P_VALUE'];
	$photonum_k = $poselok_info['PROPERTY_PHOTONUM_K_VALUE'];
	$photonum_r = $poselok_info['PROPERTY_PHOTONUM_R_VALUE'];
	$poselok_infra_name_p = $poselok_info['PROPERTY_NAME_P_VALUE'];
	$poselok_name_p = $poselok_infra_name_p;
	$poselok_code = $poselok_info['CODE'];
	$poselok_description = $poselok_info['DETAIL_TEXT'];

	if($poselok_info["DETAIL_PICTURE"] > 0) {
		$poselok_img = CFile::GetPath($poselok_info["DETAIL_PICTURE"]);
	}
	if(is_array($poselok_info["PROPERTY_MORE_PHOTO_VALUE"])) {
		foreach($poselok_info["PROPERTY_MORE_PHOTO_VALUE"] as $key => $val) {
			if($val > 0) {
				$arPhotos[] = CFile::GetPath($val);
				$arPhotosDescr[] = $poselok_info["PROPERTY_MORE_PHOTO_DESCRIPTION"][$key];
			}
		}
	}
}

function printPhoto($src, $descr) {
	?><a href="<?=$src?>" data-fancybox="gallery" data-caption="<?=$descr?>" title="<?=$descr?>"><div class="thumbnail" style="background-image:url('<?=$src?>')"></div></a><?
}

//print("<pre>"); print_r($arResult['DISPLAY_PROPERTIES']); print("</pre>"); 

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
	form.setProperty("object_name", "<?=$actualItem['NAME'].', '.$kadastr ?>");
	});
</script>
<div class="content mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok" id="<?=$actualItem['ID']?>" itemscope itemtype="http://schema.org/Product">
		<div class="row align-items-center">
			<div class="col-12 col-md-6 textcard">
				<div class="label">
                    <?if($poselok_pay != ""){?><div class="bk"><?=$poselok_pay?></div><?}?>
                    <?if($poselok_trigger != ""){?><div class="bk"><?=$poselok_trigger?></div><?}?>
                    <?if($actualItem['DISPLAY_PROPERTIES']['IZS']['DISPLAY_VALUE'] != "!Да"){?><div class="izs">ИЖС</div><?}?>
                </div>
				<div class="title_lot align-items-center">
					<div class="h1"><?=$actualItem["NAME"]?></div>
					<div class="izbrn"><?
$APPLICATION->IncludeComponent(
	"vsoft:wishlist.add",
	"",
	Array(
		"PARAM2" => $actualItem["IBLOCK_ID"],
		"PARAM3" => $actualItem["ID"],
		"DELAYED" => "Y"
	),
	$component
);
					?></div>
				</div>
				<div class="hr"></div>
				<div class="address">Московская область<?if($actualItem['DISPLAY_PROPERTIES']['area']['DISPLAY_VALUE'] != ""){?>, <?=$actualItem['DISPLAY_PROPERTIES']['area']['DISPLAY_VALUE']?><?}?></div>
				<div class="placement"><?if($actualItem['DISPLAY_PROPERTIES']['road']['DISPLAY_VALUE'] != "") { print_shosse($actualItem); }?></div>
				<div class="opts">
					<?if($actualItem['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE'] > 0){?><div class="opt"><div class="big"><span><?=$_ssquare?></span></div><div><?=sotok($_ssquare)?></div></div><?}?>
					<div class="opt hr"></div>
					<?if($actualItem['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'] > 0){?><div class="opt"><div class="big"><span><?=formatNum($actualItem['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'])?></span> ₽</div><div><?if($actualItem['DISPLAY_PROPERTIES']['price']['DISPLAY_VALUE'] > 0){?><?=formatNum($actualItem['DISPLAY_PROPERTIES']['price']['DISPLAY_VALUE'])?> ₽ за сотку<?}?></div></div><?}?>
					<div class="opt hr"></div>
					<?if($actualItem['DISPLAY_PROPERTIES']['mkad']['DISPLAY_VALUE'] > 0){?><div class="opt"><div class="big"><span><?=$actualItem['DISPLAY_PROPERTIES']['mkad']['DISPLAY_VALUE']?></span> км</div><div>от МКАД</div></div><?}?>
				</div>
				<div class="infra d-flex flex-wrap mt-4"><?
$icons = Array();
$titles = Array();

if(is_array($poselok_facility_icons)) {
	foreach($poselok_facility_icons as $key=>$val) {
		if($val == "roads") {
			array_unshift($icons, $val);
			array_unshift($titles, $poselok_facility_items[$key]);
		} else {
			$icons[] = $val;
			$titles[] = $poselok_facility_items[$key];
		}
	}
} else if($poselok_facility_icons != "" && $poselok_facility_items != "") {
	$icons[0] = $poselok_facility_icons;
	$titles[0] = $poselok_facility_items;
} 

foreach($icons as $key=>$icon) {
	echo "<div class='icn'><div class='icn_i'><i class='mso mi mi_".$icon."' title='".$titles[$key]."'></i></div><div class='icn_t'>".decode_icn($icon)."</div></div>";
}
				?></div>
				<div class="descr">
					<p>Продается земельный участок № <?=$actualItem['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE']?> площадью <?=$actualItem['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE'] ?> <?=sotok($actualItem['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE'])?> в коттеджном поселке <strong><a href="<?=$poselok_url?><?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>"><?=$poselok_name?></a></strong>.
					<?if($actualItem['DISPLAY_PROPERTIES']['use_for']['DISPLAY_VALUE'] != "") {?>Разрешенное использование земли: <strong class="wrap"><?=$actualItem['DISPLAY_PROPERTIES']['use_for']['DISPLAY_VALUE']?></strong>.<?}?>
					<?if($actualItem['DISPLAY_PROPERTIES']['kadastr_price']['DISPLAY_VALUE'] > 0) {?>Земельный налог: <?=formatNum($actualItem['DISPLAY_PROPERTIES']['kadastr_price']['DISPLAY_VALUE']*0.003)?> ₽ в год.<?}?>
					</p><?if($kadastr != "") {?><p>Кадастровый номер участка: <strong><?=$kadastr?></strong>.</p><?}?>
				</div>
				<div class="buttons">
					<a class="button" onclick="show_bron('Хочу купить <?=$actualItem["NAME"]?>, (площадь: <?=$_ssquare?> сот., цена за сотку: <?=formatNum($actualItem['DISPLAY_PROPERTIES']['price']['DISPLAY_VALUE'])?> ₽, цена участка: <?=formatNum($actualItem['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'])?> ₽, кадастровый номер: <?=$kadastr?>)')">Оставить заявку</a><?if($poselok_url != "") {?><a href="<?=$poselok_url?><?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>" class="button">О поселке<i class="mso mi_rarr right"></i></a><?}?><a href="#ipoteka" class="button frbtn">Ипотека</a>
				</div>
			</div>
			<div class="col-12 col-md-6"><?
if(is_array($arPhotos) || $poselok_img != "") {
	$PhotoCount = count($arPhotos);
	?>
				<div class="mainpicture_cont w-100"><a id="mainpicture_a" href="javascript:;" data-fancybox-trigger="gallery" data-fancybox-index="0"><div id="mainpicture" style="background-image: url(<?=($poselok_img != "")?$poselok_img:$arPhotos[0]?>)" class="w-100"></div></a></div>
				<div class="slider row align-items-center">
					<div class="left_arr col-2 col-sm-1 col-md-2 col-lg-1"><a id="gal_left"><i class="mso mi mi_larr"></i></a></div>
					<div class="photos_slider col-8 col-sm-10 col-md-8 col-lg-10"><div class="row"><?
		$start_from = 0;
		if($poselok_img != "") {
						?><div class="col-4 col-sm-3 col-md-4 col-lg-3 col-xl-2 col_prv" id="col_prv0"><a id="thumbnail0" class="thumbnail sel" data-fancybox-index="0" href="<?=$poselok_img?>" data-fancybox="gallery" data-caption="" title=""><div class="thumbnail" style="background-image:url('<?=$poselok_img?>')"></div></a></div><?
			$start_from++;
		}
		for($i = 0; $i < $PhotoCount; $i++) {
						?><div class="col-4 col-sm-3 col-md-4 col-lg-3 col-xl-2 col_prv" id="col_prv<?=($i+$start_from)?>"><a id="thumbnail<?=($i+$start_from)?>" class="thumbnail<?($start_from == 0)?" sel":""?>" data-fancybox-index="<?=($i+$start_from)?>" href="<?=$arPhotos[$i]?>" data-fancybox="gallery" data-caption="<?=$arPhotosDescr[$i]?>" title="<?=$arPhotosDescr[$i]?>"><div class="thumbnail" style="background-image:url('<?=$arPhotos[$i]?>')"></div></a></div><?
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
		</div>
		<div class="h2 mb-0">Участок на Генплане</div>
	</div>
</div></div></div></div>
<div class="canvas">
	<div id="map_lands" style="height: 500px; width: 100%;"></div>
	<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
		<div class="elem-poselok">
			<div class="container lands_legend">
				<div class="lands_title">Стоимость земли:</div>
				<div class="row_colors"><?
			        $units = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 6, "ACTIVE" => "Y", "PROPERTY_poselok" => $poselokID), false, false, Array('ID', 'PROPERTY_price', 'PROPERTY_old_price', 'PROPERTY_text_sale', 'PROPERTY_status'));
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
					?>
                    <div class="ll_item position-relative col-6 col-md-4 col-lg-3 col-xl-2">
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

<?if($poselok_description):?>
    <div class="content mt-0 mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-xl-10 offset-xl-1">
                    <div class="elem-poselok">
                        <a id="opisanie"></a>
                        <div class="h2 mb-0 mt-4 mt-md-1">Описание поселка</div>
                        <div class="mb-4 mt-4">
                            <?=$poselok_description;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?endif;?>

<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok">
		<div class="h2 mb-0 mt-4 mt-md-1">Другие участки в <?=$poselok_infra_name_p?></div>
	</div>
</div></div></div></div>
<div class="canvas">
	<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
<?
global $arrPreFilter;
$arrPreFilter['ACTIVE'] = "Y";
$arrPreFilter['!ID'] = $actualItem["ID"];
$arrPreFilter['>PROPERTY_SQUARE'] = 0;
$arrPreFilter['>PROPERTY_PRICE'] = 0;
$arrPreFilter['=PROPERTY_STATUS_VALUE'] = "в продаже";
$arrPreFilter['=PROPERTY_POSELOK'] = $poselokID;

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
						"MESS_BTN_SUBSCRIBE" => "".$poselok_url."?#plan",
						"MESS_BTN_COMPARE" => "".$poselok_code,
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
<div id="map_location" style="height: 500px; width: 100%;"></div>
<div class="canvas">
	<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
		<div class="calc mt-4 mt-md-3 mt-lg-2 mt-xl-1 mb-5"><a class="button" href="#ipoteka">Калькулятор ипотеки и рассрочки</a></div>
	</div></div></div></div>
</div>
<div class="content mt-1 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok">

		<a id="ipoteka"></a>
		<div class="h2 mb-4 mt-2">Ипотека и рассрочка</div>

		<div class="frame mb-4 mt-4"><?$APPLICATION->IncludeFile(SITE_DIR."calc/calc.php", array("SUM" => $actualItem['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE']), array("MODE" => "html"));?></div>

		<meta itemprop="name" content="<?=$name?>" />

        <div class="content mt-0 mb-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-xl-10 offset-xl-1">
                        <div class="elem-poselok">
                            <div class="row align-items-center cards pb-0">
                                <div class="col-12 col-md-12">
                                    <div class="frame blue_form"><script data-b24-form="inline/4/club07" data-skip-moving="true">
                                            (function(w,d,u){
                                                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
                                                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
                                            })(window,document,'https://cdn-ru.bitrix24.ru/b29466034/crm/form/loader_4.js');
                                        </script></div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

<?
global $arrNearFilter;
$arrNearFilter = get_nearest_filter($poselokID, $actualItem["PROPERTIES"]["center"]["VALUE"]); 

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
                    <?if($poselok_seo_anchor):?>
                        <div class="seo_anchor_similar_villages">
                            <p><?=$poselok_seo_anchor;?></p>
                        </div>
                    <?endif;?>
	</div></div></div></div>
</div>

<div class="content mt-5 mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-xl-10 offset-xl-1">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-7">
                        <div class="h1">Почему выбирают ЭКО Земли</div>
                        <div class="hr mb-5"></div>
                    </div>
                </div>
                <div class="row buy">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="align-items-center rtitle">
                            <div class="icon"><i class="mso mi mi_age"></i></div><div class="title">10 лет на рынке</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="align-items-center rtitle">
                            <div class="icon"><i class="mso mi mi_village"></i></div><div class="title">Более 1500 проданных участков</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="align-items-center rtitle">
                            <div class="icon"><i class="mso mi mi_security"></i></div><div class="title">Юридическое сопровождение сделки</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="align-items-center rtitle">
                            <div class="icon"><i class="mso mi mi_target"></i></div><div class="title">Работаем без посредников</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="align-items-center rtitle">
                            <div class="icon"><i class="mso mi mi_about"></i></div><div class="title">Все документы на землю готовы</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content mt-5 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
	<div class="elem-poselok">
<?} else {
?><div class="mt-4"></div><?
}?>

		<div class="frame banner"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
	</div>
</div></div></div></div>
<script type="text/javascript" src="https://<?=$_SERVER["HTTP_HOST"]?>/js/map/?type=map&mode=poselki_lots&id=<?=$poselokID?>&sel=<?=$actualItem["ID"]?><?if($_GET["uid"] != ""){ echo "&uid=".$_GET["uid"]; }?>"></script>
