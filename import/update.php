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

set_time_limit(3600);
ini_set("default_socket_timeout", 300);
@ignore_user_abort(true);

global $url;

$unit_IBLOCK_ID = 6;
$SITE_IBLOCK_ID = 5;

$myPOSELOK_ID = 0;

CModule::IncludeModule('iblock');
CModule::IncludeModule("catalog");


function statusToCode($status) {
	$code = 0;
	if($status == "в продаже") {
		$code = 1;
	} else if($status == "забронирован") {
		$code = 2;
	} else if($status == "продан") {
		$code = 3;
	}
	return $code;
}

global $poselok_obj;
global $poselok_info;

$poselok_obj = null;
$poselok_info = null;

$rsUnits = CIBlockElement::GetList(
	Array("PROPERTY_POSELOK" => "ASC"), 
		array(
			"IBLOCK_ID" => $unit_IBLOCK_ID
		), false, false, 
		Array(
			'ID', 'PROPERTY_NUM', 'PROPERTY_STATUS', 'PROPERTY_POSELOK', 'PROPERTY_AREA', 'PROPERTY_ROAD', 'PROPERTY_MKAD', 'PROPERTY_MMKAD',
			'PROPERTY_SQUARE', 'PROPERTY_PRICE', 'PROPERTY_NODES', 'PROPERTY_CENTER', 'PROPERTY_USE_FOR', 'PROPERTY_KADASTR_PRICE',
			'PROPERTY_ADDRESS', 'PROPERTY_IZS', 'PROPERTY_DESCR', 'PROPERTY_SSQUARE', 'PROPERTY_SPRICE'
		)
);

while($OurUnits = $rsUnits->GetNextElement()){
	global $poselok_obj;
	global $poselok_info;

	if($OurUnits) {
		$Our_ID = $OurUnits->fields['ID'];
		$Our_square = $OurUnits->fields['PROPERTY_SQUARE_VALUE'];
		$Our_ssquare = $OurUnits->fields['PROPERTY_SSQUARE_VALUE'];
		$Our_price = $OurUnits->fields['PROPERTY_PRICE_VALUE'];
		$Our_sprice = $OurUnits->fields['PROPERTY_SPRICE_VALUE'];
		$Our_poselok = $OurUnits->fields['PROPERTY_POSELOK_VALUE'];
		$Our_num = $OurUnits->fields['PROPERTY_NUM_VALUE'];
	
		if(($Our_ssquare > 0) && ($Our_price > 0)) {
			$Our_sprice = $Our_ssquare * $Our_price;
		} else {
			$Our_sprice = $OurUnits->fields['PROPERTY_SPRICE_VALUE'];
		}

		//if(($Our_poselok == 976) && ($Our_num >= 569) && ($Our_num <= 1014)) {
			//$Our_poselok = 4854;
			if($Our_poselok != $myPOSELOK_ID) {
				$poselok_obj = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => $SITE_IBLOCK_ID, "ID" => $Our_poselok), false, false, Array('IBLOCK_ID ', 'ID', 'NAME', 'PROPERTY_AREA', 'PROPERTY_ROAD', 'PROPERTY_MKAD', 'PROPERTY_MMKAD', 'PROPERTY_IZS'));
				$poselok_info = $poselok_obj->GetNext();
				$myPOSELOK_ID = $Our_poselok;
			} 

			//print("Our_ID: ".$Our_ID);
			//print("Our_square: ".$Our_square);
			//print("Our_ssquare: ".$Our_ssquare);
			//print("Our_area: ".$Our_area);
			//print("STATUS: ".$OurUnits->fields['PROPERTY_STATUS_VALUE']);
		
			$unit_upd = new CIBlockElement;
		
			$PROPs = array();
			$PROPs[44] = $OurUnits->fields['PROPERTY_NUM_VALUE'];
			$PROPs[52] = statusToCode($OurUnits->fields['PROPERTY_STATUS_VALUE']);
			$PROPs[42] = $Our_poselok;
			$PROPs[45] = $OurUnits->fields['PROPERTY_SQUARE_VALUE'];
			$PROPs[46] = $OurUnits->fields['PROPERTY_PRICE_VALUE'];
			$PROPs[47] = $OurUnits->fields['PROPERTY_NODES_VALUE'];
			$PROPs[48] = $OurUnits->fields['PROPERTY_CENTER_VALUE'];
			$PROPs[49] = htmlspecialchars_decode($OurUnits->fields['PROPERTY_USE_FOR_VALUE']);
			$PROPs[50] = $OurUnits->fields['PROPERTY_KADASTR_PRICE_VALUE'];
			$PROPs[51] = htmlspecialchars_decode($OurUnits->fields['PROPERTY_ADDRESS_VALUE']);
			$PROPs[58] = $OurUnits->fields['PROPERTY_DESCR_VALUE'];
			$PROPs[59] = $OurUnits->fields['PROPERTY_SSQUARE_VALUE'];
			$PROPs[61] = $Our_sprice;
	
			if($poselok_info && $myPOSELOK_ID == $Our_poselok) {
				$PROPs[60] = $poselok_info["PROPERTY_AREA_VALUE"];
				$PROPs[71] = $poselok_info["PROPERTY_ROAD_VALUE"];
				$PROPs[72] = $poselok_info["PROPERTY_MKAD_VALUE"];
				$PROPs[73] = $poselok_info["PROPERTY_MMKAD_VALUE"];
				$PROPs[79] = ($poselok_info["PROPERTY_IZS_VALUE"] == "Да")?5:"";
			} else {
				$PROPs[60] = $OurUnits->fields["PROPERTY_AREA_VALUE"];
				$PROPs[71] = $OurUnits->fields["PROPERTY_ROAD_VALUE"];
				$PROPs[72] = $OurUnits->fields["PROPERTY_MKAD_VALUE"];
				$PROPs[73] = $OurUnits->fields["PROPERTY_MMKAD_VALUE"];
				$PROPs[79] = $OurUnits->fields["PROPERTY_IZS_VALUE"];
			}
	
			//echo "<pre>"; print_r($myPOSELOK_ID); echo "</pre>";
			//exit;
		
			$arUpdateProductArray = Array(
				"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
				"PROPERTY_VALUES"=> $PROPs,
			);
			//echo "<pre>"; print_r($arUpdateProductArray); echo "</pre>";
	
			if($unit_upd->Update($Our_ID, $arUpdateProductArray)) {
				echo "Участок ".$Our_ID." - <font color='green'>обновлено</font><br>";
			} else {
				echo "Участок ".$Our_ID." - <font color='red'><b>ОШИБКА 1</b>: ".$unit_upd->LAST_ERROR."</font><br>";
				$iError++;
			}
		//}
	}
	//$OurUnits = $rsUnits->GetNextElement();
}



echo '<br><div><br>Скрипт завершен</div><br><br> ';

CMain::FinalActions();
?>