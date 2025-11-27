<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

if($arResult["DETAIL_PICTURE_SRC"] != "") {
	$APPLICATION->SetPageProperty("top_background", $arResult["DETAIL_PICTURE_SRC"]);
}

$APPLICATION->SetTitle($arResult["META_TAGS"]["TITLE"]);
$APPLICATION->SetPageProperty("description", $arResult["META_TAGS"]["META_DESCRIPTION"]);