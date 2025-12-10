<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;

if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateFolder.'/themes/'.$templateData['TEMPLATE_THEME'].'/style.css');
	$APPLICATION->SetAdditionalCSS('/bitrix/css/main/themes/'.$templateData['TEMPLATE_THEME'].'/style.css', true);
}

if (!empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
	{
		$loadCurrency = \Bitrix\Main\Loader::includeModule('currency');
	}

	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);

	if ($loadCurrency)
	{
		?>
		<script>
			BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
		</script>
		<?
	}
}

//	lazy load and big data json answers
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($request->isAjaxRequest() && ($request->get('action') === 'showMore' || $request->get('action') === 'deferredLoad'))
{
	$content = ob_get_contents();
	ob_end_clean();

	[, $itemsContainer] = explode('<!-- items-container -->', $content);
	$paginationContainer = '';
	if ($templateData['USE_PAGINATION_CONTAINER'])
	{
		[, $paginationContainer] = explode('<!-- pagination-container -->', $content);
	}
	[, $epilogue] = explode('<!-- component-end -->', $content);

	if (isset($arParams['AJAX_MODE']) && $arParams['AJAX_MODE'] === 'Y')
	{
		$component->prepareLinks($paginationContainer);
	}

	$component::sendJsonAnswer(array(
		'items' => $itemsContainer,
		'pagination' => $paginationContainer,
		'epilogue' => $epilogue,
	));
}

$PAGEN = "";
if(array_key_exists("PAGEN_1", $_GET)) {
	$PAGEN = " — страница&nbsp;".$_GET["PAGEN_1"];
}
if(($arResult["NAME"] != "") && (is_array($arResult["IPROPERTY_VALUES"])) && $arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != "") {
	$arResult["META_TAGS"]["TITLE"] = "Земельные участки ".$arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"].$PAGEN;
	$arResult["META_TAGS"]["META_DESCRIPTION"] = $arResult["UF_SUBTITLE"] ?: "земельные участки ".$arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"];
} else {
	$arResult["META_TAGS"]["TITLE"] = "Земельные участки в Московской области".$PAGEN;
	$arResult["META_TAGS"]["META_DESCRIPTION"] = "земельные участки в Московской области";
}

$arResult["META_TAGS"]["META_DESCRIPTION"] = "Купить ".$arResult["META_TAGS"]["META_DESCRIPTION"].". Продажа земельных участков в Подмосковье, ИЖС, без членских взносов от разных застройщиков недорого. Местоположение на карте, описания, цены и фото.";

$APPLICATION->SetTitle($arResult["META_TAGS"]["TITLE"]);
$APPLICATION->SetPageProperty("description", $arResult["META_TAGS"]["META_DESCRIPTION"]);

$APPLICATION->SetDirProperty("h1", $arResult["UF_H1"] ?: $arResult["META_TAGS"]["TITLE"]);
$APPLICATION->SetDirProperty("subtitle", $arResult["UF_SUBTITLE"] ?: $arResult["META_TAGS"]["META_DESCRIPTION"]);
