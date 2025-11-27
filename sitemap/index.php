<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Карта сайта");
$APPLICATION->SetPageProperty("top_background", "/imgs/pokupka_zemli.webp");
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<div class="h1">Все разделы сайта</div>
				<div class="hr"></div>
<?
$APPLICATION->IncludeComponent("bitrix:main.map", ".default", Array(
	"LEVEL"	=>	"3",
	"COL_NUM"	=>	"2",
	"SHOW_DESCRIPTION"	=>	"N",
	"SET_TITLE"	=>	"N",
	"CACHE_TYPE" => "N",
	"CACHE_TIME"	=>	"36000000"
	)
);

?>
<div class="frame banner mt-4 mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>