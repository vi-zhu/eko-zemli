<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if (is_object($component))
{
	$arPhotos = $component->arResult['MORE_PHOTO'];
	$bg_ph_num_i = $component->arResult['DISPLAY_PROPERTIES']['photonum']['DISPLAY_VALUE'];

	$photo = "";
	if($bg_ph_num_i > 0) {
		$bg_ph_num_i = $bg_ph_num_i - 1;
		if(is_array($arPhotos)) {
			if(count($arPhotos) > $bg_ph_num_i) {
				$photo = $arPhotos[$bg_ph_num_i]['SRC'];
			} else {
				$photo = $arPhotos[0]['SRC'];
			}
		}
	}

	$component->arResult['DETAIL_PICTURE_SRC'] = $photo;
	$component->SetResultCacheKeys(array('DETAIL_PICTURE_SRC'));
}

//$arResult["META_TAGS"]["BROWSER_TITLE"] = "Купить земельные участки в поселке ".$arResult["NAME"]." | Продажа земельных участков в деревне ".$arResult["NAME"];
//$arResult["META_TAGS"]["META_DESCRIPTION"] = "Купить земельные участки в поселке ".$arResult["NAME"].". Продажа земельных участков в деревне ".$arResult["NAME"].", ИЖС, без членских взносов от разных застройщиков недорого. Местоположение на карте, описания, цены и фото.";
//$arResult["META_TAGS"]["TITLE"] = "Земельные участки в поселке ".$arResult["NAME"];
