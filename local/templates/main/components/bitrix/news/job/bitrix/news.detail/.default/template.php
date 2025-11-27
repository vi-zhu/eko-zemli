<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="job_detail">
	<div class="row">
		<div class="col-12 col-md-6 order-0">
			<div class="h2">Условия</div>
			<div class="hr"></div>
			<div class="job_preview"><?if($arResult["PREVIEW_TEXT_TYPE"] == "text") { print_to_li_text($arResult["PREVIEW_TEXT"]); } else { echo $arResult["PREVIEW_TEXT"]; }?></div>
		</div>
		<div class="col-12 col-md-5 offset-0 offset-md-1 order-3 order-md-2">
			<p class="d-md-none">&nbsp;</p>
			<div class="frame vacancy"><?$APPLICATION->IncludeFile(SITE_DIR."include/hr.php", array(), array("MODE" => "html"));?></div>
		</div>
		<div class="col-12 order-md-1 order-2 order-md-3">
			<?=str_replace(" - ", " — ", str_replace("<p>", "<div class='h2 mt-5'>", str_replace("</p>", "</div><div class='hr'></div>", $arResult["DETAIL_TEXT"])))?>
		</div>
	</div>
</div>