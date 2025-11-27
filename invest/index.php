<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Инвестиции в земельные участки в Московской области");
$APPLICATION->SetPageProperty("top_background", "/imgs/investicii_v_zemlyu.webp");
$APPLICATION->SetAdditionalCss("/calc/style.css");
$APPLICATION->AddHeadScript("/calc/jquery-ui.min.js");
$APPLICATION->AddHeadScript("/calc/jquery.ui.touch-punch.min.js");
$APPLICATION->AddHeadScript("/calc/script_invest.js");

$UID = (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"])));
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<?$APPLICATION->IncludeFile(SITE_DIR."include/invest.php", array(), array("MODE" => "html"));?>
				<h2>Расчет доходности</h2>
				<div class="frame mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."calc/calc_invest.php", array(), array("MODE" => "html"));?></div>
				<div class="frame mt-5"><?print_lot_search_form(0)?></div>
				<div class="frame banner mt-5 mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<div id="map_location" style="height: 500px; width: 100%;"></div>
<script type="text/javascript" src="https://<?=$_SERVER["HTTP_HOST"]?>/js/map/?type=map&mode=poselki<?if($UID != ""){ echo "&uid=".$UID; }?>"></script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>