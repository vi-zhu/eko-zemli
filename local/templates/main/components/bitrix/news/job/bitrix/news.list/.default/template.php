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
<div class="job_list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
	<div class="row">
<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="col-12 mb-5">
			<div class="h1"><?echo $arItem["NAME"]?></div>
			<div class="hr"></div>
			<div class="job_content"><?if($arItem["PREVIEW_TEXT_TYPE"] == "text") { print_to_li_text($arItem["PREVIEW_TEXT"]); } else { echo $arItem["PREVIEW_TEXT"]; }?></div>
			<div class="buttons"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?><?if($arParams["UID"] != ""){ echo "?uid=".$arParams["UID"]; }?>" class="button">Подробнее<i class="mso mi_rarr right"></i></a></div>
		</div>
<?endforeach;?>
	</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
