<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Калькулятор ипотеки и рассрочки");
$APPLICATION->SetPageProperty("top_background", "/imgs/uchaskti_v_ipoteku.webp");

$APPLICATION->SetAdditionalCss("/calc/style.css");
$APPLICATION->AddHeadScript("/calc/jquery-ui.min.js");
$APPLICATION->AddHeadScript("/calc/jquery.ui.touch-punch.min.js");
$APPLICATION->AddHeadScript("/calc/script.js");
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<div class="frame mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."calc/calc.php", array(), array("MODE" => "html"));?></div>
				<div class="frame mt-5"><?print_lot_search_form(0)?></div>
				<div class="frame banner mt-5 mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>