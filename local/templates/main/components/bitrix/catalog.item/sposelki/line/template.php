<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array|null $price
 * @var float|int|null $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var string $discountPositionClass
 * @var string $labelPositionClass
 * @var CatalogSectionComponent $component
 */


$showDisplayProps = !empty($item['DISPLAY_PROPERTIES']);
$showProductProps = $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !empty($item['PRODUCT_PROPERTIES']);
$showPropsBlock = $showDisplayProps || $showProductProps;
$showSkuBlock = false;

$evenRow = $arResult["ROW_NUM"] % 2;

$lots = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 6, "ACTIVE" => "Y", "PROPERTY_poselok" => $item["ID"]), false, false, Array('PROPERTY_status', 'PROPERTY_ssquare', 'PROPERTY_price', 'PROPERTY_sprice'));

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

//$minPrice = $MAX_VAL;
//$maxPrice = 0; 
//$minSPrice = $MAX_VAL;

$_lots_count = $lots_count % 10;
$_lots_for_sale = $lots_for_sale % 10;
?>
<div class="poselok-card small-card" id="itemrow<?=$item["ID"]?>">
	<div class="w-100">
		<div class="poselok-image w100" id="<?=$itemIds['PICT']?>" style="background-image: url('<?=$item['DETAIL_PICTURE']['SRC']?>')">
		<? if ($itemHasDetailUrl): ?><a class="product-item-image-wrapper" href="<?=$item['DETAIL_PAGE_URL']?><?if($arParams["UID"] != ""){ echo "?uid=".$arParams["UID"]; }?>" title="<?=$imgTitle?>" data-entity="image-wrapper"><? else: ?><span class="product-item-image-wrapper" data-entity="image-wrapper"><? endif; ?>
			<div style="width: 100%; height: 100%;"><div class="label"><?if($item['DISPLAY_PROPERTIES']['pays']['DISPLAY_VALUE'] != ""){?><div class="bk"><?=$item['DISPLAY_PROPERTIES']['pays']['DISPLAY_VALUE']?></div><?}?><?if($item['DISPLAY_PROPERTIES']['IZS']['DISPLAY_VALUE'] != "!Да"){?><div class="izs">ИЖС</div><?}?></div></div>
		<? if ($itemHasDetailUrl): ?></a><? else: ?></span><? endif; ?>
		</div>
	</div>
	<div class="w-100 textcard">
		<div class="h3"><?=$item["NAME"]?></div>
		<div class="hr"></div>
		<div class="price">
			<?if($minSPrice > 0 && $minSPrice != $MAX_VAL){?><span class="price_ot">от <span><?=formatNum($minSPrice)?></span> ₽</span><?} else {?><span class="sold_out">Все участки проданы</span><?}?>
			<span class="price_ps">
				<?if($minSquare > 0) {?>Участки&nbsp;по&nbsp;<?=makeDiapazone($minSquare, $maxSquare)?>&nbsp;соток<br><?}?>
				<?if(($minPrice > 0 && $minPrice != $MAX_VAL) || $maxPrice > 0){?><?=makeDiapazone($minPrice, $maxPrice)?>&nbsp;₽&nbsp;за&nbsp;сотку<?}?>
			</span>
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
			<a class="button" onclick="show_bron('Хочу купить участок в поселке «<?=$item["NAME"]?>»')">Оставить заявку</a><? if ($itemHasDetailUrl): ?><a href="<?=$item['DETAIL_PAGE_URL']?><?if($arParams["UID"] != ""){ echo "?uid=".$arParams["UID"]; }?>" class="button frbtn">Подробнее<i class="mso mi_rarr right"></i></a><? endif; ?>
		</div>
	</div>
</div>