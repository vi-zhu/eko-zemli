<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;

$cp = $this->__component;
if (is_object($cp))
{
	if(is_array($cp->arResult["DETAIL_PICTURE"])) {
		$cp->arResult['DETAIL_PICTURE_SRC'] = $cp->arResult["DETAIL_PICTURE"]["SRC"];
	}
	if($cp->arResult["DISPLAY_PROPERTIES"]["BREADCRUM"]["DISPLAY_VALUE"] != "") {
		$cp->arResult['BREADCRUM'] = $cp->arResult["DISPLAY_PROPERTIES"]["BREADCRUM"]["DISPLAY_VALUE"];
	} else {
		$cp->arResult['BREADCRUM'] = $cp->arResult["NAME"];
	}
	$cp->SetResultCacheKeys(array('DETAIL_PICTURE_SRC', 'BREADCRUM'));
}
?>