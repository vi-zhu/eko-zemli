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

$site = 'npetri.ru';

$units = [];

$_xml = file_get_contents($url.$site);
$xml = json_decode($_xml, true);
if($xml['success'] == 1) {
	//echo "<pre>"; print_r($xml); echo "</pre>"; exit;
	if(!is_null($xml['data']) && is_array($xml['data'])) {
		//echo "<pre>"; print_r($xml['data']); echo "</pre>"; exit;
		foreach ($xml['data'] as $unit) {
			$cadastralNumber = $unit['cadastralNumber'];
			$number = $unit['number'];
			$units[$number] = $cadastralNumber;
		}
	}
} 

ksort($units);

//echo "<pre>"; print_r($units); echo "</pre>";

foreach ($units as $key => $val) {
    echo "$val<br>";
}


echo '<br><div><br>Скрипт завершен</div><br><br> ';

CMain::FinalActions();
?>