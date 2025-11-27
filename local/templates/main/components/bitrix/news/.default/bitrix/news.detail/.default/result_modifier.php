<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;

$cp = $this->__component;
if (is_object($cp))
{
	if(is_array($cp->arResult["DETAIL_PICTURE"])) {
		$cp->arResult['DETAIL_PICTURE_SRC'] = $cp->arResult["DETAIL_PICTURE"]["SRC"];
	}
	$cp->SetResultCacheKeys(array('DETAIL_PICTURE_SRC'));
}
?>