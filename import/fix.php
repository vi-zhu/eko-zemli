<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    
    COption::SetOptionString("main","server_name","cm99421.tw1.ru");
	COption::SetOptionString("main","site_name","cm99421.tw1.ru");

	exit;
        // Убираем из Настройки - Сайты - Список сайтов (в активный сайт )
	$obSite = new CSite();
$t = $obSite->Update("s1", array(
		'ACTIVE' => "Y",
		"SERVER_NAME"  => "",
		"DOMAINS" => ""
	));
?>