<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Варианты и условия покупки земельных участков");
$APPLICATION->SetPageProperty("top_background", "/imgs/pokupka_zemli.webp");
$APPLICATION->SetAdditionalCss("/calc/style.css");
$APPLICATION->AddHeadScript("/calc/jquery-ui.min.js");
$APPLICATION->AddHeadScript("/calc/jquery.ui.touch-punch.min.js");
$APPLICATION->AddHeadScript("/calc/script.js");
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<?$APPLICATION->IncludeFile(SITE_DIR."include/kak_kupit.php", array(), array("MODE" => "html"));?>
				<?$APPLICATION->IncludeFile(SITE_DIR."include/buy.php", array(), array("MODE" => "html"));?>
				<div class="frame mt-5"><?$APPLICATION->IncludeFile(SITE_DIR."calc/calc.php", array(), array("MODE" => "html"));?></div>
				<div class="frame mt-5"><?print_lot_search_form(0)?></div>
				<div class="frame banner mt-5 mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>