<?
//exit;

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

$start_from_ID = 12623;

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

$rsUnits = CIBlockElement::GetList(
	Array("ID" => "ASC"), 
		array(
			"IBLOCK_ID" => $unit_IBLOCK_ID, ">=ID" => $start_from_ID
		), false, false, 
		Array(
			'ID', 'NAME', 'PROPERTY_NUM', 'PROPERTY_STATUS', 'PROPERTY_POSELOK', 'PROPERTY_AREA', 'PROPERTY_ROAD', 'PROPERTY_MKAD', 'PROPERTY_MMKAD',
			'PROPERTY_SQUARE', 'PROPERTY_PRICE', 'PROPERTY_NODES', 'PROPERTY_CENTER', 'PROPERTY_USE_FOR', 'PROPERTY_KADASTR_PRICE',
			'PROPERTY_ADDRESS', 'PROPERTY_IZS', 'PROPERTY_DESCR', 'PROPERTY_SSQUARE', 'PROPERTY_SPRICE'
		)
);

$step = 0;
$laststep = $_GET["laststep"];
if("".$laststep == "") {
	$laststep = 0;
}
$packsize = 100;

while($OurUnits = $rsUnits->GetNextElement()){
	//echo "<pre>"; print_r($OurUnits); echo "</pre>";
	$step++;
	if($step > $laststep + $packsize) {
		echo "<br><div><br>Скрипт частично завершен...</div><br><br><script>setTimeout(function(){location.href='update_all.php?laststep=".($step-1)."';}, 2000);</script>";
		break;
	} else if($step > $laststep) {
		$Our_ID = $OurUnits->fields['ID'];
		$Our_square = $OurUnits->fields['PROPERTY_SQUARE_VALUE'];
		$Our_ssquare = $OurUnits->fields['PROPERTY_SSQUARE_VALUE'];
		$Our_price = $OurUnits->fields['PROPERTY_PRICE_VALUE'];
		$Our_sprice = $OurUnits->fields['PROPERTY_SPRICE_VALUE'];
		$Our_poselok = $OurUnits->fields['PROPERTY_POSELOK_VALUE'];
		$Our_num = $OurUnits->fields['PROPERTY_NUM_VALUE'];
		$Our_sprice = $OurUnits->fields['PROPERTY_SPRICE_VALUE'];

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

		$PROPs[60] = $OurUnits->fields["PROPERTY_AREA_VALUE"];
		$PROPs[71] = $OurUnits->fields["PROPERTY_ROAD_VALUE"];
		$PROPs[72] = $OurUnits->fields["PROPERTY_MKAD_VALUE"];
		$PROPs[73] = $OurUnits->fields["PROPERTY_MMKAD_VALUE"];
		$PROPs[79] = $OurUnits->fields["PROPERTY_IZS_VALUE"];

		$arFields = [];
		$arFields['IBLOCK_SECTION'] = [];
		$sectionRes = CIBlockElement::GetElementGroups($Our_ID, true, ["ID"]);
		while ($sectionData = $sectionRes->Fetch()) {
			$arFields['IBLOCK_SECTION'][] = $sectionData["ID"];
		}

		//echo "".$step.". Участок ".$Our_ID.", ".$OurUnits->fields['NAME']."<br>";
		//continue;


		foreach ($PROPs[71] as $VALUE) { 
			if($VALUE == 'm2') {
				$_section_id = 30;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			} else if($VALUE == 'm4') {
				$_section_id = 31;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			} else if($VALUE == 'm9') {
				$_section_id = 32;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			} else if($VALUE == 'a0') {
				$_section_id = 33;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			} else if($VALUE == 'a130') {
				$_section_id = 34;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			}
		}

		if($PROPs[60] == 'stupino') {
			$_section_id = 35;
			if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
		} else if($PROPs[60] == 'serpuhov') {
			$_section_id = 36;
			if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
		} else if($PROPs[60] == 'krasnogorsk') {
			$_section_id = 37;
			if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
		} else if($PROPs[60] == 'istra') {
			$_section_id = 38;
			if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
		} else if($PROPs[60] == 'domodedovo') {
			$_section_id = 39;
			if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
		} else if($PROPs[60] == 'podolsk') {
			$_section_id = 40;
			if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
		}

		foreach ([41, 42, 43, 44, 45, 46, 47, 48, 49, 50] as $element) {
			if (($key = array_search($element, $arFields['IBLOCK_SECTION'])) !== false) {
				unset($arFields['IBLOCK_SECTION'][$key]);
			}
		}

		if($PROPs[59] > 0) {
			if($PROPs[59] <= 6) {
				$_section_id = 41;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			}
			if(($PROPs[59] >= 6) && ($PROPs[59] <= 8)) {
				$_section_id = 42;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			} 
			if(($PROPs[59] >= 8) && ($PROPs[59] <= 10)) {
				$_section_id = 43;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			}
			if(($PROPs[59] >= 10) && ($PROPs[59] <= 15)) {
				$_section_id = 44;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			}
			if($PROPs[59] >= 15) {
				$_section_id = 45;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			} 
		}

		if($PROPs[61] > 0) {
			if($PROPs[61] <= 500000) {
				$_section_id = 46;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			}
			if(($PROPs[61] >= 500000) && ($PROPs[61] <= 1000000)) {
				$_section_id = 47;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			} 
			if(($PROPs[61] >= 1000000) && ($PROPs[61] <= 2000000)) {
				$_section_id = 48;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			}
			if(($PROPs[61] >= 2000000) && ($PROPs[61] <= 3000000)) {
				$_section_id = 49;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			}
			if($PROPs[61] >=3000000) {
				$_section_id = 50;
				if(!in_array($_section_id, $arFields['IBLOCK_SECTION'])) { $arFields['IBLOCK_SECTION'][] = $_section_id; }
			} 
		}



		$arUpdateProductArray = Array(
			"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
			"PROPERTY_VALUES"=> $PROPs,
			"IBLOCK_SECTION" => $arFields['IBLOCK_SECTION'],
		);

		if($unit_upd->Update($Our_ID, $arUpdateProductArray)) {
			echo "".$step.". Участок ".$Our_ID." - <font color='green'>обновлено</font><br>";
		} else {
			echo "".$step.". Участок ".$Our_ID." - <font color='red'><b>ОШИБКА 1</b>: ".$unit_upd->LAST_ERROR."</font><br>";
			$iError++;
		}
	}
	//exit;
}



echo '<br><div><br>Скрипт завершен</div><br><br> ';

CMain::FinalActions();
?>