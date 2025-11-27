<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

$poselokID = $arResult["PROPERTIES"]["POSELOK"]["VALUE"];
if(!$poselokID) {
	$poselokID = 0;
}

$poselok_name = "";
$poselok_url = "";

$poselok_obj = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "ID" => $poselokID), false, false, Array('IBLOCK_ID ', 'ID', 'NAME', 'DETAIL_PAGE_URL'));
$poselok_info = $poselok_obj->GetNext();

if($poselok_info) {
	$poselok_name = str_replace(" ", "&nbsp;", $poselok_info["NAME"]);
	$poselok_url = $poselok_info["DETAIL_PAGE_URL"];
}
//echo "<pre>"; print_r($arResult); echo "</pre>";
?>
<div class="news_detail">
	<div class="h1"><?echo $arResult["DISPLAY_PROPERTIES"]["DT"]["DISPLAY_VALUE"]?></div>
	<div class="hr"></div>
	<div class="news_preview"><?echo str_replace(" - ", " — ", $arResult["PREVIEW_TEXT"]);?></div>
	<?=str_replace(" - ", " — ", $arResult["DETAIL_TEXT"])?>
</div>