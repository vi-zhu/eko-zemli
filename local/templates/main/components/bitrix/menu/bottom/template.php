<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) { die(); }

if (!empty($arResult)) {
	?><div class="row mb-3 mb-sm-0"><div class="col-12 col-md-4"><ul class="footer_menu subcols0"><?
	$is_visible = true;
	$children_is_visible = true;
	$is_cols = false;
	$cols_html = "";
	$previousLevel = 0;
	$previous_children_is_visible = false;
	$previous_children_is_cols = false;
	foreach($arResult as $arItem) {
		if($arItem["DEPTH_LEVEL"] == 1) {
			if(count($arItem["PARAMS"]) > 0) {
				if($arItem["PARAMS"]["footer"] == "-") {
					$is_visible = false;
					$children_is_visible = false;
				} else if($arItem["PARAMS"]["footer"] == "0") {
					$is_visible = true;
					$children_is_visible = false;
				} else {
					$is_visible = true;
					$children_is_visible = true;
				}

				if($arItem["PARAMS"]["cols"] != "") {
					$is_cols = true;
				} else {
					$is_cols = false;
				}
			} else {
				$is_visible = true;
				$is_cols = false;
			}
		}
		if($is_visible) {
			if($is_cols) {
				if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel && $previous_children_is_visible) {
					$cols_html .= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
				}
				if ($arItem["IS_PARENT"] && $children_is_visible) {
					if ($arItem["DEPTH_LEVEL"] == 1) {
						$cols_html .= '<li class="li'.$arItem["DEPTH_LEVEL"].'"><a href="'.$arItem["LINK"].(($_GET['uid'] != '')?'?uid='.$_GET['uid']:'').'">'.$arItem["TEXT"].'<i class="mso mi mi_down"></i></a><ul class="fsub'.$arItem["DEPTH_LEVEL"].' subcols'.$arItem["PARAMS"]["cols"].'">';
					}
				} else if ($children_is_visible || $arItem["DEPTH_LEVEL"] == 1) {
					$cols_html .= '<li class="li'.$arItem["DEPTH_LEVEL"].'"><a href="'.$arItem["LINK"].(($_GET['uid'] != '')?'?uid='.$_GET['uid']:'').'">'.$arItem["TEXT"].'</a></li>';
				}
			} else {
				if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel && $previous_children_is_visible && !$previous_children_is_cols) {
					?><?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?><?
				}
				if ($arItem["IS_PARENT"] && $children_is_visible) {
					if ($arItem["DEPTH_LEVEL"] == 1) {
						?><li class="li<?=$arItem["DEPTH_LEVEL"]?>"><a href="<?=$arItem["LINK"]?><?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>"><?=$arItem["TEXT"]?><i class="mso mi mi_down"></i></a><ul class="fsub<?=$arItem["DEPTH_LEVEL"]?>"><?
					}
				} else if ($children_is_visible || $arItem["DEPTH_LEVEL"] == 1) {
					?><li class="li<?=$arItem["DEPTH_LEVEL"]?>"><a href="<?=$arItem["LINK"]?><?if($_GET["uid"] != ""){ echo "?uid=".$_GET["uid"]; }?>"><?=$arItem["TEXT"]?></a></li><?
				}
			}

			$previousLevel = $arItem["DEPTH_LEVEL"];
			$previous_children_is_visible = $children_is_visible;
			$previous_children_is_cols = $is_cols;
		}

	}
	if($cols_html != "") {
		echo '</ul></div><div class="col-12 col-md-8"><ul class="footer_menu">'.$cols_html.'</ul></li>';
	}
	if ($previousLevel > 1) {
		?><?=str_repeat("</ul></li>", ($previousLevel-1) );?><?
	}
?></ul></div></div><?
}
?>