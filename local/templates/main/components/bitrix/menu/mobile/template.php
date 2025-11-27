<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) { die(); }

if (!empty($arResult)) {
	?><ul><?
	$previousLevel = 0;
	foreach($arResult as $arItem) {
		if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) {
			?><?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?><?
		}

		if ($arItem["IS_PARENT"]) {
			if ($arItem["DEPTH_LEVEL"] >= 1) {
				?><li><a href="javascript:void(0);" class="mroot-item <?if ($arItem["SELECTED"] || (strpos($_SERVER["REQUEST_URI"], $arItem["LINK"]) !== false)):?>root-item-selected<?endif?>"><?=$arItem["TEXT"]?><i class="mso mi mi_down"></i></a><ul class="msub1"><?
			}
		} else {
			?><li><a href="<?=$arItem["LINK"]?><?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>" class="<?if ($arItem["SELECTED"] || ((strpos($_SERVER["REQUEST_URI"], $arItem["LINK"]) !== false) && $arItem["DEPTH_LEVEL"] == 1)):?>root-item-selected<?endif?>"><?=$arItem["TEXT"]?></a></li><?
		}

		$previousLevel = $arItem["DEPTH_LEVEL"];

	}
	if ($previousLevel > 1) {
		?><?=str_repeat("</ul></li>", ($previousLevel-1) );?><?
	}
?></ul><?
}
?>