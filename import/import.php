<?
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

$url = 'https://api.macroncrm.ru/lovezem/map?website=';

$sites = array('nprosk.ru', 'nbarybino.ru', 'btatatrinovo.ru', 'nmaryno.ru', 'ntolochanovo', 'npetri.ru', 'pmakeevo.ru', 'nnovgor.ru', 'nkishkino.ru', 'selo-yusupovo.ru', 'kuzlife.ru', 'kalyanino-life.ru', 'izpetri.ru');

$sites = array('nprosk.ru', 'btatatrinovo.ru', 'nmaryno.ru', 'ntolochanovo', 'npetri.ru', 'pmakeevo.ru', 'nnovgor.ru', 'nkishkino.ru', 'selo-yusupovo.ru', 'kuzlife.ru', 'izpetri.ru');

$unit_IBLOCK_ID = 6;

CModule::IncludeModule('iblock');
CModule::IncludeModule("catalog");

function addcomment($str1, $str2) {
	$res = "".$str1;
	if($res !== "") {
		$res .= "\n";
	}
	$res .= "Обновлено ".date('d.m.Y H:i:s', time()).": ".$str2;
	return $res;
}

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

foreach ($sites as $site) {
	$_xml = file_get_contents($url.$site);
	$xml = json_decode($_xml, true);
	if($xml['success'] == 1) {
		//echo "<pre>"; print_r($xml); echo "</pre>"; exit;
		if(!is_null($xml['data']) && is_array($xml['data'])) {
			//echo "<pre>"; print_r($xml['data']); echo "</pre>"; exit;
			foreach ($xml['data'] as $unit) {
				$cadastralNumber = $unit['cadastralNumber'];
				$number = $unit['number'];
				$price = $unit['priceCategory']['price'];
				if(!is_null($unit['employmentStatus']) && is_array($unit['employmentStatus']) && count($unit['employmentStatus']) > 0) {
					$status = mb_strtolower($unit['employmentStatus']['name']);
				} else {
					$status = 'в продаже';
				}
				if($status == "по запросу" || $status == "не введен" || $status == "на уточнении" || $status == "скоро в продаже" || $status == "") {
					$status = 'в продаже';
					$price = '';
				}
				if($status == "свободно") {
					$status = 'в продаже';
				}
				if($status == "забронировано" || $status == "бронь по запросу" || $status == "устная бронь") {
					$status = 'забронирован';
				}
				if($status == "продано") {
					$status = 'продан';
				}

				$rsUnits = CIBlockElement::GetList(
					Array("SORT" => "ASC"), 
					array(
						"IBLOCK_ID" => $unit_IBLOCK_ID, 
						"NAME" => $cadastralNumber
					), false, false, 
					Array(
						'ID', 'PROPERTY_NUM', 'PROPERTY_STATUS', 'PROPERTY_POSELOK', 'PROPERTY_ROAD', 'PROPERTY_AREA', 'PROPERTY_MKAD', 'PROPERTY_MMKAD',  
						'PROPERTY_SQUARE', 'PROPERTY_PRICE', 'PROPERTY_NODES', 'PROPERTY_CENTER', 'PROPERTY_USE_FOR', 'PROPERTY_KADASTR_PRICE',
						'PROPERTY_ADDRESS', 'PROPERTY_IZS', 'PROPERTY_DESCR', 'PROPERTY_SSQUARE', 'PROPERTY_SPRICE'
					)
				);
				$OurUnits = $rsUnits->GetNextElement();
		
				if($OurUnits) {
					$Our_ID = $OurUnits->fields['ID'];
					$Our_number = $OurUnits->fields['PROPERTY_NUM_VALUE'];
					$Our_status = $OurUnits->fields['PROPERTY_STATUS_VALUE'];
					$Our_price = $OurUnits->fields['PROPERTY_PRICE_VALUE'];
					$Our_sprice = $OurUnits->fields['PROPERTY_SPRICE_VALUE'];
					$Our_ssquare = $OurUnits->fields['PROPERTY_SSQUARE_VALUE'];
					$Our_descr = $OurUnits->fields['PROPERTY_DESCR_VALUE'];

					$needUpdate = false;

					if(''.$Our_number !== ''.$number && ''.$number != '') {
						$needUpdate = true;
						$Our_descr = addcomment($Our_descr, "Новый номер участка - ".$number.", (было - ".$Our_number.")");
						$Our_number = (int)$number;
					}
					if($Our_status !== $status && $status != '') {
						$needUpdate = true;
						$Our_descr = addcomment($Our_descr, "Новый статус участка - ".$status.", (было - ".$Our_status.")");
						$Our_status = $status;
					}
					if(''.$Our_price !== ''.$price && ''.$price != '') {
						$needUpdate = true;
						$Our_descr = addcomment($Our_descr, "Новая цена - ".$price.", (было - ".$Our_price.")");
						$Our_price = (float)$price;
						$Our_sprice = $Our_price * $Our_ssquare;
					}
					if($price == '' && ''.$Our_price != '') $needUpdate = true;

					if($needUpdate) {
						$unit_upd = new CIBlockElement;

						$PROPs = array();
						$PROPs[44] = $Our_number;
						$PROPs[52] = statusToCode($Our_status);
						$PROPs[42] = $OurUnits->fields['PROPERTY_POSELOK_VALUE'];
						$PROPs[71] = $OurUnits->fields['PROPERTY_ROAD_VALUE'];
						$PROPs[60] = $OurUnits->fields['PROPERTY_AREA_VALUE'];
						$PROPs[72] = $OurUnits->fields['PROPERTY_MKAD_VALUE'];
						$PROPs[73] = $OurUnits->fields['PROPERTY_MMKAD_VALUE'];
						$PROPs[45] = $OurUnits->fields['PROPERTY_SQUARE_VALUE'];
						if($price != '') $PROPs[46] = $Our_price;
						$PROPs[47] = $OurUnits->fields['PROPERTY_NODES_VALUE'];
						$PROPs[48] = $OurUnits->fields['PROPERTY_CENTER_VALUE'];
						$PROPs[49] = htmlspecialchars_decode($OurUnits->fields['PROPERTY_USE_FOR_VALUE']);
						$PROPs[50] = $OurUnits->fields['PROPERTY_KADASTR_PRICE_VALUE'];
						$PROPs[51] = htmlspecialchars_decode($OurUnits->fields['PROPERTY_ADDRESS_VALUE']);
						$PROPs[79] = $OurUnits->fields['PROPERTY_IZS_VALUE'];
						$PROPs[58] = $Our_descr;
						$PROPs[59] = $OurUnits->fields['PROPERTY_SSQUARE_VALUE'];
						if($price != '') $PROPs[61] = $Our_sprice;

						$arUpdateProductArray = Array(
							"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
							"PROPERTY_VALUES"=> $PROPs,
						);

						//echo "<pre>"; print_r($OurUnits); echo "</pre>";
						//echo "<pre>"; print_r($unit); echo "</pre>";
						//echo "<pre>"; print_r($arUpdateProductArray); echo "</pre>"; exit;
		
						if($unit_upd->Update($Our_ID, $arUpdateProductArray)) {
							echo "Участок ".$Our_number." (".$cadastralNumber.") в ".$site." - <font color='green'>обновлено</font><br>";
						} else {
							echo "Участок ".$Our_number." (".$cadastralNumber.") в ".$site." - <font color='red'><b>ОШИБКА 1</b>: ".$unit_upd->LAST_ERROR."</font><br>";
							$iError++;
						}
						//print_r($PROPs);
						//echo "<pre>"; print_r($OurUnits); echo "</pre>";
						//echo "<pre>"; print_r($unit); echo "</pre>"; exit;
					} else {
						//echo "Участок ".$cadastralNumber ." в ".$site." - пропушен, нет обновлений ...<br>";
					}
				} else {
					echo "Участок ".$cadastralNumber ." в ".$site." - <font color='red'>НЕ НАЙДЕН</font><br>";
				}
			}
		}
	} 
}



echo '<br><div><br>Скрипт завершен</div><br><br> ';

CMain::FinalActions();
?>