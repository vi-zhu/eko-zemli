<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) { die(); }

//echo "<pre>"; print_r($arResult); echo "</pre>";

$colswrap = [2, 4];
$colswrapindex = 0;
$inComplex = 0;

if (!empty($arResult)) {
	?><div class="menu_root"><?
	$previousLevel = 0;
	foreach($arResult as $arItem) {
		if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) {
			?><?=str_repeat("</div></div>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?><?
		}

		if ($arItem["IS_PARENT"]) {
			if ($arItem["DEPTH_LEVEL"] == 1 && "0" != $arItem["PARAMS"]["footer"]) {
				if($inComplex == 1) {
					?></div><?
					$inComplex = 0;
				}
?><div class="parent1"><div class="menu-item"><a href="<?=$arItem["LINK"]?><?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>" class="<?if ($arItem["SELECTED"] || ((strpos($_SERVER["REQUEST_URI"], $arItem["LINK"]) !== false) && $arItem["DEPTH_LEVEL"] == 1)):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?><i class="mso mi mi_down"></i></a></div><div class="sub<?=$arItem["DEPTH_LEVEL"]?><?if("" != $arItem["PARAMS"]["cols"]){?> subcols<?=$arItem["PARAMS"]["cols"]?><?}?>"><?
			} else if ($arItem["DEPTH_LEVEL"] == 1 && "0" == $arItem["PARAMS"]["footer"]) {
				?><div class="parent1"><div class="menu-item"><a href="<?=$arItem["LINK"]?><?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>" class="<?if ($arItem["SELECTED"] || ((strpos($_SERVER["REQUEST_URI"], $arItem["LINK"]) !== false) && $arItem["DEPTH_LEVEL"] == 1)):?>root-item-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?><i class="mso mi mi_down"></i></a></div><div class="multi sub<?=$arItem["DEPTH_LEVEL"]?>"><div class="fcol"><?
				$inComplex = 1;
			} else if ($arItem["DEPTH_LEVEL"] == 2) {
				if($inComplex == 1 && in_array($colswrapindex, $colswrap)) {
					?></div><div class="fcol"><?
				}
				$colswrapindex++;
				?><div class="parent2"><div class="menu-group"><?=$arItem["TEXT"]?></div><div class="sub<?=$arItem["DEPTH_LEVEL"]?><?if("" != $arItem["PARAMS"]["cols"]){?> subcols<?=$arItem["PARAMS"]["cols"]?><?}?>"><?
			}
		} else {
			if ($arItem["DEPTH_LEVEL"] == 1) {
				if($inComplex == 1) {
					?></div><?
					$inComplex = 0;
				}
				?><div class="parent0"><div class="menu-item"><a class="<?if ($arItem["SELECTED"] || ((strpos($_SERVER["REQUEST_URI"], $arItem["LINK"]) !== false) && $arItem["DEPTH_LEVEL"] == 1)):?>root-item-selected<?else:?>root-item<?endif?>" href="<?=$arItem["LINK"]?><?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>"><?=$arItem["TEXT"]?></a></div></div><?
			} else {
				?><div class="menu-item"><a href="<?=$arItem["LINK"]?><?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>" class="<?if ($arItem["SELECTED"] || ((strpos($_SERVER["REQUEST_URI"], $arItem["LINK"]) !== false) && $arItem["DEPTH_LEVEL"] == 1)):?>root-item-selected<?endif?>"><?=$arItem["TEXT"]?></a></div><?
			}
		}

		$previousLevel = $arItem["DEPTH_LEVEL"];

	}
	if ($previousLevel > 1) {
		?><?=str_repeat("</div></div>", ($previousLevel-1) );?><?
	}
?></div><?
}
?>