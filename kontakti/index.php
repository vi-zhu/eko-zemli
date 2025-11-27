<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
$APPLICATION->SetPageProperty("top_background", "/imgs/uchastki_dlya_dachi.webp");

$UID = (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"])));
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<div class="row">
					<div class="col-12 col-sm-6">
						<h2>Центральный офис</h2>
						<h2><?$APPLICATION->IncludeFile(SITE_DIR."include/phone.php", array(), array("MODE" => "html"));?></h2>
						<p>На любой вопрос Вы получите исчерпывающий ответ <?$APPLICATION->IncludeFile(SITE_DIR."include/work.php", array(), array("MODE" => "html"));?></p>
						<p><b><?$APPLICATION->IncludeFile(SITE_DIR."include/address.php", array(), array("MODE" => "html"));?></b></p>
						<h2>Наши реквизиты</h2>
						<p><?$APPLICATION->IncludeFile(SITE_DIR."include/ip.php", array(), array("MODE" => "html"));?></p>
					</div>
					<div class="col-12 col-sm-6"><?$APPLICATION->IncludeFile(SITE_DIR."include/map.php", array(), array("MODE" => "html"));?></div>
				</div>

				<div class="frame mt-5"><?print_lot_search_form(0)?></div>
				<div class="frame banner mt-5 mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<div id="map_location" style="height: 500px; width: 100%;"></div>
<script type="text/javascript" src="https://<?=$_SERVER["HTTP_HOST"]?>/js/map/?type=map&mode=poselki<?if($UID != ""){ echo "&uid=".$UID; }?>"></script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>