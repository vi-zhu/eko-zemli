<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';
$BreadcrumbListPosition = 0;

$itemSize = count($arResult);

$arrow = '<i class="bc-arrow mso mi mi_bc"></i>';

if ($itemSize > 0) {
	$strReturn .= '<div class="bc-item"><a href="/'.(($_GET['uid'] != '')?'?uid='.$_GET['uid']:'').'" title="На главную"><i class="mso mi mi_home"></i></a>'.$arrow.'</div>';
}
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	if ("XXX" == $title || "" == $title || $arResult[$index]["LINK"] == "/") {continue;}

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<div class="bc-item"'.(($arResult[$index]["LINK"] != "/")?' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Breadcrumb"':'').'>
<a href="'.$arResult[$index]["LINK"].(($_GET['uid'] != '')?'?uid='.$_GET['uid']:'').'" title="'.$title.'"'.(($arResult[$index]["LINK"] != "/")?' itemscope itemtype="http://schema.org/Thing" itemprop="item" rel="v:url" property="v:title"':'style="margin-right: 0px;"').'>
'.(($arResult[$index]["LINK"] != "/")?'<span itemprop="name">'.$title.'</span>':'').'
				</a>'.(($arResult[$index]["LINK"] != "/")?'<meta itemprop="position" content="'.$BreadcrumbListPosition.'" />':'').'
				'.$arrow.'
			</div>';
	}
	else
	{
		$strReturn .= '<div class="bc-item"><span class="bc-sel">'.str_replace(array('«','»'), '"', $title).'</span></div>';
	}
	$BreadcrumbListPosition++;
}

$strReturn .= '<div style="clear:both"></div>';

return $strReturn;
