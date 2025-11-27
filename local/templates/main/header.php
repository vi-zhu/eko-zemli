<?
$url = $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];

if ($url != strtolower($url)) {
	$url = strtolower($url);
	if($_SERVER['QUERY_STRING'] != "") {
		$url .= "?".$_SERVER['QUERY_STRING'];
	}
	header('Location: //'.$_SERVER['HTTP_HOST'] . $url, true, 301);
	exit();
}

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions.php";
require_once $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/noindex.php";
require_once $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/nofollow.php";

global $noindex;
global $nofollow;

$UID = (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"])));

$business_founded = 2012;

CModule::IncludeModule('iblock');

use Bitrix\Main\Page\Asset;

$var_main_phone = "8 (495) 492-64-98";
$var_main_email = "info@eko-zemli.ru";

if("" != "".$_GET["uid"]) {
	$UID = intval("".$_GET["uid"]);
	if($UID > 0) {
		$rsManager = CIBlockElement::GetList(Array("SORT" => "ASC"), array("IBLOCK_ID" => 9, "ID" => $UID), false, false, Array('PROPERTY_PHONE', 'PROPERTY_EMAIL'));
		$elManager = $rsManager->GetNextElement();

		if($elManager) {
			$manager_phone = $elManager->fields['PROPERTY_PHONE_VALUE'];
			$manager_email = $elManager->fields['PROPERTY_EMAIL_VALUE'];

			if($manager_phone != "") {
				$var_main_phone = $manager_phone;
			}
			if($manager_email != "") {
				$var_main_email = $manager_email;
			}
		}
	}
}  

$var_main_phone_href = preg_replace('/[^0-9]/', '', $var_main_phone);

CUtil::InitJSCore();
CJSCore::Init(array("jquery"));
$curPage = $APPLICATION->GetCurPage(true);
$_curPage = $APPLICATION->GetCurPage(true);

$filterPos = strpos($_curPage, "/filter/");
if($filterPos > 0) {
	$_curPage = substr($_curPage, 0, $filterPos + 1);
}

$canonical = "https://".$_SERVER['HTTP_HOST'].str_replace('index.php', '', $_curPage);

$_curPagePath = str_replace('index.php', '', $_curPage);

$PAGEN = "";
if(array_key_exists("PAGEN_1", $_GET)) {
	$canonical .= "?PAGEN_1=".$_GET["PAGEN_1"];
	$PAGEN = " — страница ".$_GET["PAGEN_1"];
}

?><!DOCTYPE html>
<html lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	<title><?$APPLICATION->ShowTitle()?><?//=get_site_name()?><?=$PAGEN?></title>
<?//$APPLICATION->ShowMeta("description");?>
<meta name="description" content="<?$APPLICATION->ShowProperty("description")?><?=$PAGEN?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><?
if((array_key_exists("PAGEN_1", $_GET)) || (array_key_exists("sort", $_GET)) || ($filterPos > 0) || (in_array($_curPagePath, $noindex))) {
?><meta name="robots" content="noindex, follow" /><?
} else if(in_array($_curPagePath, $nofollow)) {
?><meta name="robots" content="noindex, nofollow" /><?
}
?><link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:wght@300;400;500&display=swap" rel="stylesheet">
<link media="screen" rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,1,0" />
<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=178fffb0-f4c5-4e93-b1d2-89e3d7dd40db"></script>
<link rel="shortcut icon" type="image/svg+xml" href="<?=SITE_TEMPLATE_PATH?>/svg/logo_icon.svg" /><?
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/styles.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/bootstrap.min.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/animate.min.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/script.js");

echo '<link rel="canonical" href="' . $canonical . '" />';

$APPLICATION->ShowHeadStrings();
$APPLICATION->ShowCSS();
//$APPLICATION->ShowHeadScripts();
//$APPLICATION->ShowHead();

function print_logo(){?>
<div class="pic" id="logo"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" color-interpolation-filters="sRGB" style="margin:auto" viewBox="47 1.9 246 246.19"><rect width="100%" height="100%" fill="none" class="background"/><g fill="#fff" class="icon-text-wrapper icon-svg-group iconsvg"><g transform="translate(47 1.904)" class="iconsvg-imagesvg"><path class="image-rect" fill="none" d="M0 0h246v246.192H0z"/><svg width="246" height="246.192" class="image-svg-svg primary" style="overflow:visible"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0.021 -0.005 158.491 158.614"><path d="M81.23 158.59c-18.77 0-34.12-4.88-47.84-14.65a78.11 78.11 0 0 1-26.33-32.06 79.09 79.09 0 0 1 1.6-68.56 79.58 79.58 0 0 1 11.71-17.07A78.35 78.35 0 0 1 49.25 5.87 76.55 76.55 0 0 1 72.88.25a80.64 80.64 0 0 1 23.65 1.61 16.39 16.39 0 0 1 8.16 27.19 75.34 75.34 0 0 0-13 20.67A73.69 73.69 0 0 0 86 73.43 75.92 75.92 0 0 0 105.19 130a16.46 16.46 0 0 1-9.9 27c-5.29 1-10.57 1.74-14.06 1.59zM26 79.28a44.8 44.8 0 0 1 .9-9.81 52.79 52.79 0 0 1 19.2-32.4C58.52 27 72.78 23.08 88.67 25.33a1.71 1.71 0 0 0 1.7-.52c.58-.69 1.22-1.33 1.74-2.06a5.77 5.77 0 0 0 1.19-4.41c-.56-3.3-2.91-5.29-6.54-5.33-2.81 0-5.61-.21-8.43-.12a63 63 0 0 0-15.81 2.59 65.16 65.16 0 0 0-29.78 18.35A66.39 66.39 0 0 0 22.07 49 65.58 65.58 0 0 0 15 75.32a68.21 68.21 0 0 0 1.17 17.25 64.59 64.59 0 0 0 8.25 21.08 66.32 66.32 0 0 0 63.13 31.88 6.06 6.06 0 0 0 5.42-8.34c-.47-1.26-1.53-2.05-2.27-3.1a2 2 0 0 0-2.25-.85 51.16 51.16 0 0 1-18.3-.43A54.63 54.63 0 0 1 26 79.28zm14.8 1.15a33.73 33.73 0 0 0 2.32 12.77 41.48 41.48 0 0 0 21.86 24 40.53 40.53 0 0 0 15 3.78c1 .06 1.17-.2.68-1.11a78.36 78.36 0 0 1-4.83-10.29 2.09 2.09 0 0 0-1.55-1.42 29.46 29.46 0 0 1-18.16-13.88 29.75 29.75 0 0 1 17.81-43.7 2.63 2.63 0 0 0 2-1.78 77.8 77.8 0 0 1 4.74-10.08c.52-.94.42-1.17-.7-1.08a44.49 44.49 0 0 0-4.88.58 41.12 41.12 0 0 0-24.08 13.7c-6.75 7.82-10.24 16.86-10.21 28.51zm30.1 9.65a85.66 85.66 0 0 1-.71-10.87 102.07 102.07 0 0 1 .66-10.73c-5.43 5.52-5.22 16.36.05 21.6z" fill="#ccf2b5"/><path d="M129.58 30.13A16.11 16.11 0 0 1 125.41 41a58 58 0 0 0-12.61 28.23 61.17 61.17 0 0 0 6.29 38.89 59.41 59.41 0 0 0 7.42 10.95 13.27 13.27 0 0 1 3 8.33c.28 7.58-2.69 13.87-8.19 19a15.65 15.65 0 0 1-6.43 3.52c-.36.1-.82.36-1.06-.09s.27-.6.5-.84c6-6.35 6.3-15.43.57-21.88a73.52 73.52 0 0 1-13.9-22.69 68.7 68.7 0 0 1-4.29-18.69 70.19 70.19 0 0 1 6.81-37.36A73.09 73.09 0 0 1 115 31.44a15.76 15.76 0 0 0 2.49-17.3 16.08 16.08 0 0 0-3.11-4.51c-.25-.26-.77-.51-.48-.93s.73-.11 1.09 0a18.57 18.57 0 0 1 9.38 6.72 24.22 24.22 0 0 1 5.21 14.71z" fill="#8bc8f5"/><path d="M147.21 45.73c.17 3.25-1.15 6.32-2.87 9.33a45.9 45.9 0 0 0-5.8 18.07 50.66 50.66 0 0 0 4.52 28 29.23 29.23 0 0 0 1.76 3.32c2.49 3.89 2.83 8.13 2.07 12.53a24 24 0 0 1-7.56 13.83c-.49.45-1 .85-1.54 1.27-.15.13-.33.25-.52.1s-.13-.35-.07-.54.14-.36.21-.54a15.84 15.84 0 0 0-1.2-14.62c-1.33-2.16-3-4.09-4.4-6.22a55.39 55.39 0 0 1-8.56-23.12 57.12 57.12 0 0 1 5.91-34.35 66.88 66.88 0 0 1 6.35-9.7 15 15 0 0 0 3.05-10.21 15.94 15.94 0 0 0-1.17-5.46c-.12-.28-.38-.62-.07-.86s.65.1.91.3a21.88 21.88 0 0 1 5.52 6.33 23.39 23.39 0 0 1 3.46 12.54zm7.61 57.27c-1.54-5.22-4.26-10-5.21-15.33a46.19 46.19 0 0 1 3.57-27.79c.32-.71.61-1.44.86-2.18s.37-1.42.56-2.17c1.67 1.64 3.82 15.3 3.91 23.67a75.06 75.06 0 0 1-3.69 23.8z" fill="#8bc8f5"/></svg></svg></g></g></svg></div>
<div class="company">ЭКО Земли</div>
<?}
?></head><body><?$APPLICATION->ShowPanel();?><div class="header">
	<div class="top_row top animate__animated animate__fadeInDown">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-xl-10 offset-xl-1 d-flex justify-content-lg-between align-items-center">
					<div class="logo-box me-auto">
						<a href="/<?if($UID != ""){ echo "?uid=".$UID; }?>" title="На главную"><div class="logo align-items-center"><?print_logo($actualItem);?></div></a>
					</div>
					<div class="top_menu d-none d-lg-block"><?$APPLICATION->IncludeComponent("bitrix:menu", "top", Array(
		"ROOT_MENU_TYPE" => "top", 
		"MAX_LEVEL" => "4",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A", 
		"MENU_CACHE_TIME" => "36000000", 
		"UID" => "".$_GET["uid"],
		"MENU_CACHE_USE_GROUPS" => "Y", 
		"MENU_CACHE_GET_VARS" => ""
	),
	false);?></div>
					<div class="callme b">
						<div class="phone"><?$APPLICATION->IncludeFile(SITE_DIR."include/phone.php", array(), array("MODE" => "html"));?></div>
						<script data-b24-form="click/8/3ww503" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://cdn-ru.bitrix24.ru/b29466034/crm/form/loader_8.js');</script>
						<div class="callbtn"><span><a id="callreq">Позвоните мне</a></span></div>
					</div>
					<div class="like"><?

$APPLICATION->IncludeComponent(
	"vsoft:wishlist.link", 
	"", 
	array(
		"PARAM2" => 6,
		"PATH_TO_WISHLIST" => "/izbrannoe/",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600"
	),
	$component
);

					?></div>
					<div class="burger d-block d-lg-none">
						<div class="menu_btn">
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="menu_top_mobile d-lg-none">
		<div class="container">
			<div class="row">
				<div class="col-12"><?$APPLICATION->IncludeComponent("bitrix:menu", "mobile", Array(
		"ROOT_MENU_TYPE" => "top", 
		"MAX_LEVEL" => "4",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A", 
		"MENU_CACHE_TIME" => "36000000", 
		"MENU_CACHE_USE_GROUPS" => "Y", 
		"MENU_CACHE_GET_VARS" => "",
		"UID" => "".$_GET["uid"],
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false);?></div>
			</div>
		</div>
	</div>
	<div class="top animate__animated animate__fadeIn" style="background-image: linear-gradient(to bottom, rgba(0, 136, 255, 0.15), rgba(0, 0, 0, 0.7)), url('<?=$APPLICATION->ShowProperty("top_background");?>');">
		<div class="header_content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-xl-10 offset-xl-1"><?if ($curPage != SITE_DIR."index.php") {?>
<div class="breadcrumb"><?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "", array(
			"START_FROM" => "0",
			"PATH" => "",
			"SITE_ID" => "m1"
		)
);?></div>
<h1><?$APPLICATION->ShowTitle(false);?></h1>
						<div class="hr"></div><div class="rassr">Рассрочка 0% без банков до 6 месяцев</div><?
						} else {
?><h1>Земельные участки в Московской области</h1><?

$areas_count = print_lot_search_form(1);

$resElemCnt = CIBlockElement::GetList(
	false, // сортировка
	array('IBLOCK_ID' => 6, "ACTIVE" => "Y", "PROPERTY_52_VALUE" => "в продаже", ">PROPERTY_46" => 0), // фильтрация
	false, // параметры группировки полей
	false, // параметры навигации
	array("ID") // поля для выборки
);
$lots_count = $resElemCnt -> SelectedRowsCount();

$resElemCnt = CIBlockElement::GetList(
	false, // сортировка
	array('IBLOCK_ID' => 5), // фильтрация
	false, // параметры группировки полей
	false, // параметры навигации
	array("ID") // поля для выборки
);
$villages_count = $resElemCnt -> SelectedRowsCount();
?><div class="row align-items-center minfo">
	<div class="col-12 col-md-6 col-lg-7 col-xl-8 text-center">
		<div class="advantage"><span class="big"><?=(date('Y') - $business_founded)?><span class="small"> лет</span></span>на рынке</div><div class="advantage"><span class="big"><?=$lots_count?></span><?=getLotsEnd($lots_count)?><br>в продаже</div><div class="advantage"><span class="big"><?=$villages_count?></span><?=getPoselkovPostroeno($villages_count)?></div><div class="advantage"><span class="big">0%</span>рассрочка<br>без банков</div>
	</div>
	<div class="col-12 col-md-6 col-lg-5 col-xl-4 offset-xl-0 slogan"><?$APPLICATION->IncludeFile(SITE_DIR."include/slogan.php", array(), array("MODE" => "text"));?></div>
	<div class="col-12 text-center top_btn_col"><button id="showbron1" class="btn btn_order mt-5" onclick="show_bron('')">Оставить заявку на подбор участка</button></div>
</div>

						<?}?></div>
				</div>
			</div>
		</div>
	</div>
</div>
