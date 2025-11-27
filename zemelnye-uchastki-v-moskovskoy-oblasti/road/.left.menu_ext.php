<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksExt = Array();

if(CModule::IncludeModule("iblock"))
{
	$roads = get_hl_table(3, 100);
	foreach($roads as $road) {
		$aMenuLinksExt[] = Array(
                $road['UF_NAME'],
                "/zemelnye-uchastki-v-moskovskoy-oblasti/".$road['UF_LINK']."/",
                Array(),
                Array(),
                ""
        );
	}

}   

$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
?>