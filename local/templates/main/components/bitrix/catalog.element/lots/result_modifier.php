<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

global $kadastr;

$title = "";
$kadastr = "".$arResult["NAME"];

$_ssquare = $arResult['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE'];
if($_ssquare > 0) {
	$_ssquare = round($_ssquare, 2);
}

if($arResult['DISPLAY_PROPERTIES']['ssquare']['DISPLAY_VALUE'] > 0 && 1<>1) {
	$title .= $_ssquare." ".sotok($_ssquare);
} else if($arResult['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE'] != "") {
	$title .= "№ ".$arResult['DISPLAY_PROPERTIES']['num']['DISPLAY_VALUE'];
} 
//if($arResult['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'] > 0) {
//	$title .= " за ".formatNum($arResult['DISPLAY_PROPERTIES']['sprice']['DISPLAY_VALUE'])."&nbsp;₽";
//} 

$poselokID = $arResult['DISPLAY_PROPERTIES']['poselok']['VALUE'];
if(!$poselokID) {
	$poselokID = -1;
}

$poselok_obj = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "ID" => $poselokID), false, false, Array('IBLOCK_ID ', 'ID', 'NAME', 'PROPERTY_NAME_P'));
$poselok_info = $poselok_obj->GetNext();

$poselok_name = "";
$poselok_name_p = ""; 

if($poselok_info) {
	$poselok_name = str_replace(" ", "&nbsp;", $poselok_info["NAME"]);
	$poselok_name_p = $poselok_info['PROPERTY_NAME_P_VALUE'];
	if($poselok_name == "") {
		$poselok_name = $$arResult["SECTION"]["NAME"];
	}
	if($poselok_name_p == "") {
		$poselok_name_p = $poselok_name;
	}
}

$_title = $title;
if($arResult["SECTION"]["NAME"] != "") {
	$title = "Участок " . $title . " в ".str_replace(" ", "&nbsp;", $poselok_name_p);
}
if($_title == "") {
	$title = "Участок";
} 

$arResult["NAME"] = $title;
$arResult["META_TAGS"]["ELEMENT_CHAIN"] = "Участок № ".$arResult["PROPERTIES"]["num"]["VALUE"];
$arResult["META_TAGS"]["BROWSER_TITLE"] = "Купить земельный участок № ".$arResult["PROPERTIES"]["num"]["VALUE"]." в ".$poselok_name_p." площадью ".$_ssquare." ".sotok($_ssquare)." | Продажа земельных участков";
$arResult["META_TAGS"]["META_DESCRIPTION"] = "Купить земельный участок № ".$arResult["PROPERTIES"]["num"]["VALUE"]." в ".$poselok_name_p." площадью ".$_ssquare." ".sotok($_ssquare)." | Продажа земельных участков в Подмосковье, ИЖС, без членских взносов от разных застройщиков недорого. Местоположение на карте, описания, цены и фото.";
$arResult["META_TAGS"]["TITLE"] = "Земельный участок № ".$arResult["PROPERTIES"]["num"]["VALUE"]." в ".$poselok_name_p." площадью&nbsp;".$_ssquare."&nbsp;".sotok($_ssquare);
//echo "<pre>"; print_r($arResult); echo "</pre>";

if (is_object($component))
{

	$poselokID = $component->arResult['DISPLAY_PROPERTIES']['poselok']['VALUE'];
	if(!$poselokID) {
		$poselokID = 0;
	}

	$poselok_obj = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "ID" => $poselokID), false, false, Array('IBLOCK_ID ', 'ID', 'NAME', 'PROPERTY_MORE_PHOTO', 'PROPERTY_PHOTONUM'));
	$poselok_info = $poselok_obj->GetNext();

	$arPhotos = array();
	$property_num = -1;

	if($poselok_info) {
		$property_num = $poselok_info['PROPERTY_PHOTONUM_VALUE'];
		if(is_array($poselok_info["PROPERTY_MORE_PHOTO_VALUE"])) {
			foreach($poselok_info["PROPERTY_MORE_PHOTO_VALUE"] as $key => $val) {
				if($val > 0) {
					$arPhotos[] = CFile::GetPath($val);
				}
			}
		}
	}

	$bg_ph_num_i = $property_num;

	$photo = "";
	if($bg_ph_num_i > 0) {
		$bg_ph_num_i = $bg_ph_num_i - 1;
		if(is_array($arPhotos)) {
			if(count($arPhotos) > $bg_ph_num_i) {
				$photo = $arPhotos[$bg_ph_num_i];
			} else {
				$photo = $arPhotos[0];
			}
		}
	}

	$component->arResult['DETAIL_PICTURE_SRC'] = $photo;
	$component->SetResultCacheKeys(array('DETAIL_PICTURE_SRC'));
}
