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

//echo "<pre>"; print_r($item); echo "</pre>";
?>
<div class="lot-card" id="itemcard<?=$item["ID"]?>">
	<div class="text-center mb-3"><a class="gotoplan" onclick="openLotOnMap(<?=$item['ID']?>)" title="Показать на Генплане"><span class="h4"<?if(is_array($arParams['COLORS_ARRAY']) && (count($arParams['COLORS_ARRAY']) > 0)){ echo ' style="background-color:'.$arParams['COLORS_ARRAY'][$item['DISPLAY_PROPERTIES']['price']['DISPLAY_VALUE']].'"'; }?>>№&nbsp;<?=$item['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE']?></span></a></div>
	<div class="h3 text-center"><?=$item['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE']?>&nbsp;<?=sotok($item['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE'])?></div>
	<div class="price text-center">
		<span class="price_a"><span class="h3"><?=formatNum($item['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'])?></span>&nbsp;₽</span>
		<span class="price_ps"><?=formatNum($item['DISPLAY_PROPERTIES']['price']['DISPLAY_VALUE'])?>&nbsp;₽ за&nbsp;сотку</span>
	</div>
	<div class="buttons text-center">
		<a class="button mr-1" title="Оформить заявку" onclick="show_bron('Хочу купить участок № <?=$item['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE']?> в поселке «<?=$item['DISPLAY_PROPERTIES']['poselok']['LINK_ELEMENT_VALUE'][$item['DISPLAY_PROPERTIES']['poselok']['VALUE']]['NAME']?>», (площадь: <?=$item['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE']?> сот., цена за сотку: <?=formatNum($item['DISPLAY_PROPERTIES']['price']['DISPLAY_VALUE'])?> ₽, цена участка: <?=formatNum($item['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'])?> ₽, кадастровый номер: <?=$item['NAME']?>)')"><i class="mso mi_email"></i></a><? if ($itemHasDetailUrl): ?><a href="<?=$item['DETAIL_PAGE_URL']?><?if($arParams["UID"] != ""){ echo "?uid=".$arParams["UID"]; }?>" title="Подробнее об участке № <?=$item['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE']?>" class="button frbtn"><i class="mso mi_about"></i></a><? endif; ?>
	</div>
</div>