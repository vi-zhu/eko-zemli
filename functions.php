<?
function get_hl_table($id, $limit) {
	if (($id > 0) && (CModule::IncludeModule('highloadblock'))) {
		$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById($id)->fetch();
		$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
	
		$rsData = $strEntityDataClass::getList(array(
			'select' => array('UF_XML_ID', 'UF_NAME', 'UF_DESCRIPTION', 'UF_FULL_DESCRIPTION', 'UF_LINK'),
			'order' => array('UF_SORT' => 'ASC'),
			'limit' => $limit,
		));
		while ($arItem = $rsData->Fetch()) {
			$arItems[] = $arItem;
		}
		return $arItems;
	} else {
		return [];
	}
}

function get_site_name() {
	$rsSite = CSite::GetList($by="sort", $order="desc", Array("ID" => SITE_ID));
	if ($arSite = $rsSite->Fetch())
	{
		//echo "<pre>"; print_r($arSite['SITE_NAME']); echo "</pre>";
		return " — ".$arSite["SITE_NAME"];
	} else {
		return "";
	}
}

function getLotsEnd($num, $upper=false) {
	$_num1 = $num % 10;
	$_num11 = $num % 100;

	if($_num11 >= 10 && $_num11 <= 20) {
		if($upper) {
			return "Участков";
		}
		else {
			return "участков";
		}
	} else if($_num1 == 1) {
		if($upper) {
			return "Участок";
		}
		else {
			return "участок";
		}
	} else if(($_num1 > 1) && ($_num1 <= 4)) {
		if($upper) {
			return "Участка";
		}
		else {
			return "участка";
		}
	} else {
		if($upper) {
			return "Участков";
		}
		else {
			return "участков";
		}
	}
}

function getPoselkovPostroeno($num) {
	$_num1 = $num % 10;
	$_num11 = $num % 100;

	if($_num11 >= 10 && $_num11 <= 20) {
		return "поселков<br>построено";
	} else if($_num1 == 1) {
		return "поселок<br>построен";
	} else if(($_num1 > 1) && ($_num1 <= 4)) {
		return "поселка<br>построено";
	} else {
		return "поселков<br>построено";
	}
}

function rayonov($num) {
	$_num1 = $num % 10;
	$_num11 = $num % 100;

	if($_num11 >= 10 && $_num11 <= 20) {
		return "районов";
	} else if($_num1 == 1) {
		return "район";
	} else if(($_num1 > 1) && ($_num1 <= 4)) {
		return "района";
	} else {
		return "районов";
	}
}


function print_parr($val, $suffix = "") {
	if(is_array($val)) {
		foreach($val as $key => $item) {
			if($key > 0) {
				echo ", ";
			}
			echo $item.$suffix;
		}
	} else {
		echo $val.$suffix;
	}
}

function print_shosse($item) {
	if(is_array($item['DISPLAY_PROPERTIES']['road']['DISPLAY_VALUE'])) {
		foreach($item['DISPLAY_PROPERTIES']['road']['DISPLAY_VALUE'] as $key => $val) {
			if($key > 0) {
				echo ", ";
			}
			echo strtoupper($item['PROPERTIES']['road']['VALUE'][$key])."&nbsp;".$val."&nbsp;шоссе";
		}
	} else {
		echo strtoupper($item['PROPERTIES']['road']['VALUE'][0])."&nbsp;".$item['DISPLAY_PROPERTIES']['road']['DISPLAY_VALUE']."&nbsp;шоссе";
	}
}

function print_one_shosse($item) {
	if(is_array($item['DISPLAY_PROPERTIES']['road']['DISPLAY_VALUE'])) {
		foreach($item['DISPLAY_PROPERTIES']['road']['DISPLAY_VALUE'] as $key => $val) {
			if($key > 0) {
				echo ", ";
			}
			echo strtoupper($item['PROPERTIES']['road']['VALUE'][$key])."&nbsp;".$val."&nbsp;шоссе";
			break;
		}
	} else {
		echo strtoupper($item['PROPERTIES']['road']['VALUE'][0])."&nbsp;".$item['DISPLAY_PROPERTIES']['road']['DISPLAY_VALUE']."&nbsp;шоссе";
	}
}

function decode_icn($icn) {
	if($icn == "electricity") {
		return "Свет";
	} else if($icn == "roads") {
		return "Дороги";
	} else if($icn == "gas") {
		return "Газ";
	} else if($icn == "wifi") {
		return "Интернет";
	} else {
		return $icn;
	}
}

function sotok($square) {
	$val = $square;
	$floor_val = floor($val);
	if($val != $floor_val) {
		return "сотки";
	} 
	if($square >= 10 && $square <= 20) {
		return "соток";
	}
	$val = $val % 10;
	if ($val == 1) {
		return "сотка";
	} else if($val > 1 && $val <= 4) {
		return "сотки";
	}
	return "соток";
}

function minut($minut) {
	if($minut >= 10 && $minut <= 20) {
		return "минут";
	}
	$minut = $minut % 10;
	if ($minut == 1) {
		return "минута";
	} else if($minut > 1 && $minut <= 4) {
		return "минуты";
	}
	return "минут";
}

function formatNum($num, $digits = 0) {
	return number_format($num, $digits, '.', '&nbsp;');;
}

function makeDiapazone($a, $b, $digits = 0, $space = ' ') {
	if ($a == $b) {
		return ''.formatNum($a, $digits);
	} else {
		return formatNum($a, $digits).$space.'–'.$space.formatNum($b, $digits);
	}
}

function print_lot_search_form($istop) {
	if($istop == 1) {
		$stage1 = "sm";
	} else {
		$stage1 = "md";
	}
?><form id="mainfilter" class="main_filter" method="post" action=""><?if($_GET["uid"] != ""){ echo "<input type='hidden' id='fm_uid' name='uid' value='".$_GET["uid"]."'>"; }?>
	<div class="row">
        <div class="col-12 col-<?=$stage1?>-4 col-lg-3">
            <select class="form-control form-control-lg form-select bg-white mb-10" id="fm_area">
                <option value="" disabled selected>Район Подмосковья</option>
				<option value="">Любой район</option><?
$areas = get_hl_table(2, 100);
foreach($areas as $area) {
	echo '<option value="'.$area['UF_XML_ID'].'">'.$area['UF_FULL_DESCRIPTION'].'</option>';
}
?></select>
        </div>
        <div class="col-12 col-<?=$stage1?>-3 col-lg-3">
            <select class="form-control form-control-lg form-select bg-white mb-10" id="fm_square">
				<option value="" disabled selected>Площадь</option>
				<option value="">Любая</option>
				<option value="0_6">до 6 соток</option>
				<option value="6_8">6 — 8 соток</option>
				<option value="8_10">8 — 10 соток</option>
                <option value="10_15">10 — 15 соток</option>
                <option value="15_1000">от 15 соток</option>
            </select>
        </div>
        <div class="col-12 col-<?=$stage1?>-3 col-lg-3">
            <select class="form-control form-control-lg form-select bg-white mb-10" id="fm_price">
				<option value="" disabled selected>Цена участка</option>
				<option value="">Любая</option>
                <option value="0_500">до 0.5 млн</option>
                <option value="500_1000">0.5 — 1 млн</option>
                <option value="1000_2000">1 — 2 млн</option>
				<option value="2000_3000">2 — 3 млн</option>
                <option value="3000_0">от 3 млн</option>
            </select>
        </div>
        <div class="col-12 col-<?=$stage1?>-2 col-lg-3">
            <button type="submit" class="btn w-100">Найти</button>
        </div>
	</div>
</form><?
	return count($areas);
}

function checkPrice($price) {
	return (((''.$price != '0 ₽') && (''.$price != '<i>0</i> ₽'))? $price : 'по запросу');
}

function hsl2hex($hsl) {
    $rgb = hsl2rgb($hsl);
    return rgb2hex($rgb);
}

function rgb2hex($rgb) {
    list($r,$g,$b) = $rgb;
    $r = round(255 * $r);
    $g = round(255 * $g);
    $b = round(255 * $b);
    return "#".sprintf("%02X",$r).sprintf("%02X",$g).sprintf("%02X",$b);
}

function hsl2rgb($hsl) {
    // Fill variables $h, $s, $l by array given.
    list($h, $s, $l) = $hsl;
    
    // If saturation is 0, the given color is grey and only
    // lightness is relevant.
    if ($s == 0 ) {
        $rgb = array($l, $l, $l);
    }
    
    // Else calculate r, g, b according to hue.
    // Check http://en.wikipedia.org/wiki/HSL_and_HSV#From_HSL for details
    else
    {
        $chroma = (1 - abs(2*$l - 1)) * $s;
        $h_     = $h * 6;
        $x         = $chroma * (1 - abs((fmod($h_,2)) - 1)); // Note: fmod because % (modulo) returns int value!!
        $m = $l - round($chroma/2, 10); // Bugfix for strange float behaviour (e.g. $l=0.17 and $s=1)
        
             if($h_ >= 0 && $h_ < 1) $rgb = array(($chroma + $m), ($x + $m), $m);
        else if($h_ >= 1 && $h_ < 2) $rgb = array(($x + $m), ($chroma + $m), $m);
        else if($h_ >= 2 && $h_ < 3) $rgb = array($m, ($chroma + $m), ($x + $m));
        else if($h_ >= 3 && $h_ < 4) $rgb = array($m, ($x + $m), ($chroma + $m));
        else if($h_ >= 4 && $h_ < 5) $rgb = array(($x + $m), $m, ($chroma + $m));
        else if($h_ >= 5 && $h_ < 6) $rgb = array(($chroma + $m), $m, ($x + $m)); 
    }
    
    return $rgb;
}

function print_points($points) {
	$result = "[";
	foreach($points as $i => $point) {
		if($i > 0) {
			$result .= ", ";
		}
		$result .= "[".$point."]";
	}
	$result .= "]";

	return $result;
}

function get_nearest_filter($id, $latlngStr) {
	$filter = Array();

	$arrNearFilter['ACTIVE'] = "Y";

	$nearestIDs = Array();

	if($latlngStr && $latlngStr != "") {
		$latlng0 = explode(",", $latlngStr);
		if(count($latlng0) == 2) {

			$nearest_obj = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "!ID" => $id), false, false, Array('IBLOCK_ID ', 'ID', 'NAME', 'PROPERTY_LATLNG'));

			while($nearest_info = $nearest_obj->GetNext())
			{
				if($nearest_info["PROPERTY_LATLNG_VALUE"] && $nearest_info["PROPERTY_LATLNG_VALUE"] != "") {
					$latlng = explode(",", $nearest_info["PROPERTY_LATLNG_VALUE"]);
					if(count($latlng) == 2) {
		
						$earthRadius = 6372.795477598;
					
						$latFrom = deg2rad($latlng0[0]);
						$lonFrom = deg2rad($latlng0[1]);
						$latTo = deg2rad($latlng[0]);
						$lonTo = deg2rad($latlng[1]);
					
						$latDelta = $latTo - $latFrom;
						$lonDelta = $lonTo - $lonFrom;
					
						$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
						$distance = $angle * $earthRadius;
						if($distance <= 30) {
							$nearestIDs[] = $nearest_info["ID"];
						}
					}
				}
			}
		}
	}

	$filter['ID'] = $nearestIDs;

	return $filter;
}

function print_to_li_text($str) {
	$array = preg_split("/\r\n|\n|\r/", $str);
	if(count($array)) { echo "<ul>"; }
	foreach($array as $item) {
		$_item = trim($item);
		if(strlen($_item) > 2) {
			echo "<li>".str_replace(" - ", " — ", $_item)."</li>";
		}
	}
	if(count($array)) { echo "</ul>"; }
}

global $arrPriceColors;
$arrPriceColors[0] = Array("from" => 0, "to" => 10, "pfrom" => 0, "pto" => 0);
$arrPriceColors[1] = Array("from" => 10, "to" => 30, "pfrom" => 0, "pto" => 0);
$arrPriceColors[2] = Array("from" => 30, "to" => 40, "pfrom" => 0, "pto" => 0);
$arrPriceColors[3] = Array("from" => 40, "to" => 50, "pfrom" => 0, "pto" => 0);
$arrPriceColors[4] = Array("from" => 50, "to" => 60, "pfrom" => 0, "pto" => 0);
$arrPriceColors[5] = Array("from" => 60, "to" => 90, "pfrom" => 0, "pto" => 0);
$arrPriceColors[6] = Array("from" => 90, "to" => 120, "pfrom" => 0, "pto" => 0);
$arrPriceColors[7] = Array("from" => 120, "to" => 150, "pfrom" => 0, "pto" => 0);
$arrPriceColors[8] = Array("from" => 150, "to" => 180, "pfrom" => 0, "pto" => 0);
$arrPriceColors[9] = Array("from" => 180, "to" => 210, "pfrom" => 0, "pto" => 0);
$arrPriceColors[10] = Array("from" => 210, "to" => 240, "pfrom" => 0, "pto" => 0);
$arrPriceColors[11] = Array("from" => 240, "to" => 270, "pfrom" => 0, "pto" => 0);
$arrPriceColors[12] = Array("from" => 270, "to" => 300, "pfrom" => 0, "pto" => 0);
$arrPriceColors[13] = Array("from" => 300, "to" => 310, "pfrom" => 0, "pto" => 0);


function get_reper_price($price0, $_lotpricedot, $_i) {
	return round(($price0 + $_lotpricedot*($_i * 2 + 1)) / 5000) * 5000;
}

function fill_arrPriceColors($prices) {
	global $arrPriceColors;
	$pCount = count($prices);
	if($pCount > 0) {
		$minPrice = $prices[0];
		$maxPrice = $prices[$pCount - 1];
		$tmp_delta = $minPrice;
		$lotpricedot = ($prices[$pCount-1] - $prices[0])/14;
		if(($pCount == 1) || ($minPrice == $maxPrice)) {
			$arrPriceColor[0]["pfrom"] = $minPrice;
			$arrPriceColor[0]["pto"] = $maxPrice;
		} else {
			$tmp_delta = get_reper_price($minPrice, $lotpricedot, 1) - $tmp_delta;
			//echo "tmp_delta: ".$tmp_delta."<br>";
			$arrPriceColors[0]["pfrom"] = $minPrice;
			$arrPriceColors[0]["pto"] = $arrPriceColors[0]["pfrom"] + $tmp_delta / 3;

			$arrPriceColors[1]["pfrom"] = $arrPriceColors[0]["pto"];
			$arrPriceColors[1]["pto"] = $arrPriceColors[1]["pfrom"] + $tmp_delta / 3;

			$arrPriceColors[2]["pfrom"] = $arrPriceColors[1]["pto"];
			$arrPriceColors[2]["pto"] = $arrPriceColors[2]["pfrom"] + $tmp_delta / 3;

			$tmp_delta = get_reper_price($minPrice, $lotpricedot, 2) - $arrPriceColors[2]["pto"];
			//echo "tmp_delta: ".$tmp_delta."<br>";
			$arrPriceColors[3]["pfrom"] = $arrPriceColors[2]["pto"];
			$arrPriceColors[3]["pto"] = $arrPriceColors[3]["pfrom"] + $tmp_delta / 2;

			$arrPriceColors[4]["pfrom"] = $arrPriceColors[3]["pto"];
			$arrPriceColors[4]["pto"] = $arrPriceColors[4]["pfrom"] + $tmp_delta / 2;

			$tmp_delta = get_reper_price($minPrice, $lotpricedot, 3) - $arrPriceColors[4]["pto"];
			//echo "tmp_delta: ".$tmp_delta."<br>";
			$arrPriceColors[5]["pfrom"] = $arrPriceColors[4]["pto"];
			$arrPriceColors[5]["pto"] = $arrPriceColors[5]["pfrom"] + $tmp_delta / 2;

			$arrPriceColors[6]["pfrom"] = $arrPriceColors[5]["pto"];
			$arrPriceColors[6]["pto"] = $arrPriceColors[6]["pfrom"] + $tmp_delta / 2;

			$tmp_delta = get_reper_price($minPrice, $lotpricedot, 4) - $arrPriceColors[6]["pto"] ;
			//echo "tmp_delta: ".$tmp_delta."<br>";
			$arrPriceColors[7]["pfrom"] = $arrPriceColors[6]["pto"];
			$arrPriceColors[7]["pto"] = $arrPriceColors[7]["pfrom"] + $tmp_delta / 2;

			$arrPriceColors[8]["pfrom"] = $arrPriceColors[7]["pto"];
			$arrPriceColors[8]["pto"] = $arrPriceColors[8]["pfrom"] + $tmp_delta / 2;

			$tmp_delta = get_reper_price($minPrice, $lotpricedot, 5) - $arrPriceColors[8]["pto"];
			//echo "tmp_delta: ".$tmp_delta."<br>";
			$arrPriceColors[9]["pfrom"] = $arrPriceColors[8]["pto"];
			$arrPriceColors[9]["pto"] = $arrPriceColors[9]["pfrom"] + $tmp_delta / 2;

			$arrPriceColors[10]["pfrom"] = $arrPriceColors[9]["pto"];
			$arrPriceColors[10]["pto"] = $arrPriceColors[10]["pfrom"] + $tmp_delta / 2;

			$tmp_delta = $maxPrice - $arrPriceColors[10]["pto"];
			//echo "tmp_delta: ".$tmp_delta."<br>";
			$arrPriceColors[11]["pfrom"] = $arrPriceColors[10]["pto"];
			$arrPriceColors[11]["pto"] = $arrPriceColors[11]["pfrom"] + $tmp_delta / 3;

			$arrPriceColors[12]["pfrom"] = $arrPriceColors[11]["pto"];
			$arrPriceColors[12]["pto"] = $arrPriceColors[12]["pfrom"] + $tmp_delta / 3;

			$arrPriceColors[13]["pfrom"] = $arrPriceColors[12]["pto"];
			$arrPriceColors[13]["pto"] = $arrPriceColors[13]["pfrom"] + $tmp_delta / 3 + 1.0;
		}
	}
}

function getPriceColor($price) {
	global $arrPriceColors;
	$color = 0;
	for($i=0; $i < count($arrPriceColors); $i++) {
		if($price >= $arrPriceColors[$i]["pfrom"] && $price <= $arrPriceColors[$i]["pto"]) {
			$color = ($arrPriceColors[$i]["from"] + (($arrPriceColors[$i]["to"] - $arrPriceColors[$i]["from"])*($price - $arrPriceColors[$i]["pfrom"])/($arrPriceColors[$i]["pto"] - $arrPriceColors[$i]["pfrom"])));
			$color = $color / 360.0;
			break;
		}
	}

	return $color;
}
?>