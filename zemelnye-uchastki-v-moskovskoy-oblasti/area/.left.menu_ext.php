<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksExt = Array();

if(CModule::IncludeModule("iblock"))
{
	$areas = get_hl_table(2, 100);
	foreach($areas as $area) {
		$aMenuLinksExt[] = Array(
                $area['UF_FULL_DESCRIPTION'],
                "/zemelnye-uchastki-v-moskovskoy-oblasti/".$area['UF_XML_ID']."/",
                Array(),
                Array(),
                ""
        );
	}

}   

$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
?>