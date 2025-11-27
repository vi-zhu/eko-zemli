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
$poselok_name = "";
$poselok_img = "";
$poselok_pay = "";
$poselok_url = "";
$poselok_facility_icons = "";
$poselok_facility_items = "";

$poselok_obj = CIBlockElement::GetByID($item['PROPERTIES']['poselok']['VALUE']);
$poselok_obj = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "ID" => $item['PROPERTIES']['poselok']['VALUE']), false, false, Array('IBLOCK_ID ', 'ID', 'NAME', 'PREVIEW_PICTURE', 'DETAIL_PAGE_URL', 'PROPERTY_pays', 'PROPERTY_FACILITY_ICONS', 'PROPERTY_FACILITY_ITEMS'));
$poselok_info = $poselok_obj->GetNext();
//echo "<pre>"; print_r($poselok_info); echo "</pre>";

if($poselok_info) {
	$poselok_name = str_replace(" ", "&nbsp;", $poselok_info["NAME"]);
	$poselok_img = CFile::GetPath($poselok_info["PREVIEW_PICTURE"]);
	$poselok_pay = $poselok_info["PROPERTY_PAYS_VALUE"];
	$poselok_url = $poselok_info["DETAIL_PAGE_URL"];
	$poselok_facility_icons = $poselok_info["PROPERTY_FACILITY_ICONS_VALUE"];
	$poselok_facility_items = $poselok_info["PROPERTY_FACILITY_ITEMS_VALUE"];
}

$title = "";

if($item['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE'] > 0) {
	$title .= $item['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE']." ".sotok($item['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE']);
} else if($item['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE'] != "") {
	$title .= "№ ".$item['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE'];
} 
if($item['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'] > 0) {
	$title .= " за ".formatNum($item['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'])."&nbsp;₽";
} 
$_title = $title;
if($poselok_name != "") {
	$title = "Участок " . $title . " в ".$poselok_name;
}

if(($item['DISPLAY_PROPERTIES']['status']['DISPLAY_VALUE'] != "в продаже") || !($item['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'] > 0)) {
	$_title = "Участок ".$item['DISPLAY_PROPERTIES']['status']['DISPLAY_VALUE'];
}

if($_title == "") {
	$title = "Участок";
}

?>
<div class="poselok-card small-card" id="itemrow<?=$item["ID"]?>">
	<div class="w-100">
		<div class="poselok-image w100" id="<?=$itemIds['PICT']?>" style="background-image: url('<?=$poselok_img?>')"><div class="izbrn"><?
$APPLICATION->IncludeComponent(
	"vsoft:wishlist.add",
	"",
	Array(
		"PARAM2" => $item["IBLOCK_ID"],
		"PARAM3" => $item["ID"],
		"DELAYED" => "Y"
	),
	$component
);
		?></div>
		<? if ($itemHasDetailUrl): ?><a class="product-item-image-wrapper" href="<?=$item['DETAIL_PAGE_URL']?><?if($arParams["UID"] != ""){ echo "?uid=".$arParams["UID"]; }?>" title="<?=$title?>" data-entity="image-wrapper"><? else: ?><span class="product-item-image-wrapper" data-entity="image-wrapper"><? endif; ?>
			<div style="width: 100%; height: 100%;"><div class="label"><?if($poselok_pay != ""){?><div class="bk"><?=$poselok_pay?></div><?}?><?if($item['DISPLAY_PROPERTIES']['IZS']['DISPLAY_VALUE'] != "!Да"){?><div class="izs">ИЖС</div><?}?></div></div>

		<? if ($itemHasDetailUrl): ?></a><? else: ?></span><? endif; ?>
		</div>
	</div>
	<div class="w-100 textcard">
		<div class="h3"><?=$_title?></div>
		<div class="hr"></div>
		<div class="placement">
			<div class="address">Московская область<?if($item['DISPLAY_PROPERTIES']['area']['DISPLAY_VALUE'] != ""){?>, <?=$item['DISPLAY_PROPERTIES']['area']['DISPLAY_VALUE']?><?}?></div>
			<?if($item['DISPLAY_PROPERTIES']['road']['DISPLAY_VALUE'] != ""){?><div><?print_one_shosse($item)?></div><?}?>
			<div class="distance">
				<?if($item['DISPLAY_PROPERTIES']['mkad']['DISPLAY_VALUE'] != ""){?><?=$item['DISPLAY_PROPERTIES']['mkad']['DISPLAY_VALUE']?> км от МКАД<?}?>
				<?if($item['DISPLAY_PROPERTIES']['mkad']['DISPLAY_VALUE'] != "" || $item['DISPLAY_PROPERTIES']['mmkad']['DISPLAY_VALUE'] != ""){?>/<?}?>
				<?if($item['DISPLAY_PROPERTIES']['mmkad']['DISPLAY_VALUE'] != ""){?><?=$item['DISPLAY_PROPERTIES']['mmkad']['DISPLAY_VALUE']?> <?=minut($item['DISPLAY_PROPERTIES']['mmkad']['DISPLAY_VALUE'])?> в пути<?}?>
			</div>
		</div>
		<?if ($item['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE'] > 0 && $poselok_name != ""){
		?><div class="poselok_link">Участок № <span class="lot_num"><?=$item['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE']?></span>
			в&nbsp;<span class="lot_pos"><?=$item['DISPLAY_PROPERTIES']['poselok']['DISPLAY_VALUE']?></span>
		</div><?}?>
		<div class="buttons">
			<a class="button" onclick="show_bron('Хочу купить участок № <?=$item['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE']?> в поселке «<?=$poselok_name?>», (площадь: <?=$item['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE']?> сот., цена за сотку: <?=formatNum($item['DISPLAY_PROPERTIES']['price']['DISPLAY_VALUE'])?> ₽, цена участка: <?=formatNum($item['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'])?> ₽, кадастровый номер: <?=$item['NAME']?>')">Оставить заявку</a><? if ($itemHasDetailUrl): ?><a href="<?=$item['DETAIL_PAGE_URL']?><?if($arParams["UID"] != ""){ echo "?uid=".$arParams["UID"]; }?>" class="button frbtn">Подробнее<i class="mso mi_rarr right"></i></a><? endif; ?>
		</div>
	</div>
</div>