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

if("".$_GET["uid"] != "" && "".$arParams["UID"] == "") {
	$arParams["UID"] = "".intval("".$_GET["uid"]);
}

$this->setFrameMode(true);
?>
<div class="news_list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
<?if(count($arResult["ITEMS"])) {?>
	<div class="row">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<div class="col-12 col-md-6 col-lg-4 mb_30"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?><?if($arParams["UID"] != ""){ echo "?uid=".$arParams["UID"]; }?>"><div class="news_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="<?if(is_array($arItem["PREVIEW_PICTURE"])){?>background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>');<?}?>">
			<div class="news_date"><?echo $arItem["DISPLAY_PROPERTIES"]["DT"]["DISPLAY_VALUE"]?></div>
			<div class="hr"></div>
			<div class="news_content">
				<div class="news_title"><?echo $arItem["NAME"]?><i class="mso mi_bc"></i></div>
				<div class="news_preview"><?echo str_replace(" - ", " — ", $arItem["PREVIEW_TEXT"]);?></div>
			</div>
		</div></a></div>
	<?endforeach;?>
	</div>
<?} else {?>
	<p>Здесь пока ничего нет. Но мы уже пишем очень интересные и полезные статьи. Пожалуйста, зайдите в этот раздел через пару дней.</p>
<?}?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
