<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
$APPLICATION->SetPageProperty("top_background", "/imgs/luchshie_uchastki.webp");

$UID = (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"])));
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
<?

$APPLICATION->IncludeComponent(
	"vsoft:wishlist",
	"",
	array(
		"IBLOCK_TYPE" => "lots",
		"IBLOCK_ID" => "6",
 		"UID" => $UID,
	),
	$component
);

?>
</div></div></div></div>
<div class="canvas">
	<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
		<?$APPLICATION->IncludeFile(SITE_DIR."include/buy.php", array(), array("MODE" => "html"));?>
		<div class="calc mt-4 mt-md-3 mt-lg-2 mt-xl-1 mb-5"><a class="button" href="/o-nas/calc/<?if($UID != ""){ echo "?uid=".$UID; }?>">Калькулятор ипотеки и рассрочки<i class="mso mi_rarr right"></i></a></div>
		<a id="nature"></a>
	</div></div></div></div>
</div>
<div class="content mt-4 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
				<div class="frame banner mt-3"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>