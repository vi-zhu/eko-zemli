<?
exit;
$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/..');
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS',true);
//define('BX_CRONTAB', true);
define('BX_WITH_ON_AFTER_EPILOG', true);
define('BX_NO_ACCELERATOR_RESET', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

function _translit($str) {
	$result = '';
	$arParams = array("replace_space"=>"_","replace_other"=>"_");
	$result = ''.Cutil::translit($str,"ru",$arParams);
	return $result;
}

function _new_translit($str) {
	$result = '';
	$arParams = array("replace_space"=>"-","replace_other"=>"-");
	$result = ''.Cutil::translit($str,"ru",$arParams);
	return $result;
}

function _make_symbol_link($num, $_poselok, $_square) {
	$result = '';
	$poselok = _new_translit(''.$_poselok);
	$square = _new_translit(''.$_square);
	$result = 'zemelnyy-uchastok-'.$num.'-v-'.$poselok.'-ploschadyu-'.$square.'-sotok';
	return $result;
}

set_time_limit(3600);
ini_set("default_socket_timeout", 300);
@ignore_user_abort(true);

global $url;

$NEW_LINKS = Array();
$OLD_LINKS = Array();

$unit_IBLOCK_ID = 6;
$SITE_IBLOCK_ID = 5;

$myPOSELOK_ID = 0;

CModule::IncludeModule('iblock');
CModule::IncludeModule("catalog");

$rsUnits = CIBlockElement::GetList(
	Array("PROPERTY_POSELOK" => "ASC"), 
		array(
			"IBLOCK_ID" => $unit_IBLOCK_ID
		), false, false, 
		Array(
			'ID', 'NAME', 'CODE', 'PROPERTY_POSELOK', 'PROPERTY_SSQUARE', 'PROPERTY_NUM', 'PROPERTY_PRICE', 'PROPERTY_PRICE', 'PROPERTY_STATUS'
		)
);

while($OurUnits = $rsUnits->GetNextElement()){
	if($OurUnits) {
		$Our_ID = $OurUnits->fields['ID'];
		$Our_Name = $OurUnits->fields['NAME'];
		$new_code = $OurUnits->fields['CODE'];
		$Our_poselok = $OurUnits->fields['PROPERTY_POSELOK_VALUE'];
		$Our_ssquare = $OurUnits->fields['PROPERTY_SSQUARE_VALUE'];
		$Our_num = $OurUnits->fields['PROPERTY_NUM_VALUE'];
		$Our_price = $OurUnits->fields['PROPERTY_PRICE_VALUE'];
		$Our_status = $OurUnits->fields['PROPERTY_STATUS_VALUE'];

		$poselok_obj = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => $SITE_IBLOCK_ID, "ID" => $Our_poselok), false, false, Array('IBLOCK_ID ', 'ID', 'NAME', 'CODE', 'PROPERTY_NAME_P'));
		$poselok_info = $poselok_obj->GetNext();
		//echo "<pre>"; print_r($poselok_info); echo "</pre>";
		
		if($poselok_info) {
			$poselok_name = $poselok_info["NAME"];
			$poselok_code = $poselok_info["CODE"];
			$poselok_name_p = $poselok_info["PROPERTY_NAME_P_VALUE"];
		} else {
			$poselok_name = "";
			$poselok_name_p = "";
		}

		//echo "ccccc".$Our_price." ".$Our_status;
		//break;

		$new_code = _make_symbol_link($Our_num, $poselok_name_p, $Our_ssquare);

		//$el = new CIBlockElement;
		//$arLoadProductArray = Array(
		//		"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
		//		"CODE" => $new_code,
		//);
		//$res = $el->Update($Our_ID, $arLoadProductArray);

		if(($Our_price != "") && ($Our_status != "продан")){
		$OLD_LINKS[] = "/zemelnye-uchastki-v-moskovskoy-oblasti/".$poselok_code."/"._translit($Our_Name)."/";
		$NEW_LINKS[] = "/zemelnye-uchastki-v-moskovskoy-oblasti/".$poselok_code."/".$new_code."/";
		}

		//break;
	}
}

echo "<pre>\$OLD_LINKS = "; var_export($OLD_LINKS); echo "</pre>";

echo "<pre>\$NEW_LINKS = "; var_export($NEW_LINKS); echo "</pre>";
?>