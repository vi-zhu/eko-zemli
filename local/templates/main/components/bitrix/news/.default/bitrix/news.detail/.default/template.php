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

$this->addExternalCss(SITE_TEMPLATE_PATH."/fancybox.css");
$this->addExternalJs(SITE_TEMPLATE_PATH."/fancybox.umd.js");

$this->setFrameMode(true);

function printPhoto($src, $descr) {
	?><a href="<?=$src?>" data-fancybox="gallery" data-caption="<?=$descr?>" title="<?=$descr?>"><div class="thumbnail" style="background-image:url('<?=$src?>')"></div></a><?
}

$poselokID = $arResult["PROPERTIES"]["POSELOK"]["VALUE"];
if(!$poselokID) {
	$poselokID = 0;
}

$poselok_name = "";
$poselok_url = "";

$poselok_obj = CIBlockElement::GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "ID" => $poselokID), false, false, Array('IBLOCK_ID ', 'ID', 'NAME', 'DETAIL_PAGE_URL'));
$poselok_info = $poselok_obj->GetNext();

if($poselok_info) {
	$poselok_name = str_replace(" ", "&nbsp;", $poselok_info["NAME"]);
	$poselok_url = $poselok_info["DETAIL_PAGE_URL"];
}

//echo "<pre>"; print_r($arResult); echo "</pre>";
?>
<div class="news_detail">
	<div class="h1"><?echo $arResult["DISPLAY_PROPERTIES"]["DT"]["DISPLAY_VALUE"]?></div>
	<div class="hr"></div>
	<div class="news_preview"><?echo str_replace(" - ", " — ", $arResult["PREVIEW_TEXT"]);?></div>
	<?=str_replace(" - ", " — ", $arResult["DETAIL_TEXT"])?>
	<?if($poselok_url != "") {?><div class="buttons mb-4"><a href="<?=$poselok_url?><?if($arParams["UID"] != ""){ echo "?uid=".$arParams["UID"]; }?>" class="button">Подробнее о поселке<i class="mso mi_rarr right"></i></a></div><?}?>
	<?if(is_array($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"])) {
		$PhotoCount = count($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"]);
		if($PhotoCount > 0) {
		?><div class="photos col-12"><?
			$direction = 1;
			for($i = 0; $i < $PhotoCount; $i++) {
				if($PhotoCount - $i >= 3) {
					?><div class="row rowgal"><?
					if($direction > 0) {
						?><div class="col-12 col-sm-7 pad10"><?
							printPhoto($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$i]['SRC'], $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]['DESCRIPTION'][$i]);
							$i++;
						?></div>
						<div class="col-12 col-sm-5 nowmar">
							<div class="row">
								<div class="col-12 pad10"><?
									printPhoto($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$i]['SRC'], $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]['DESCRIPTION'][$i]);
									$i++;
								?></div>
								<div class="col-12 pad10"><?
									printPhoto($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$i]['SRC'], $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]['DESCRIPTION'][$i]);
								?></div>
							</div>
						</div><?
					} else {
						?><div class="col-12 col-sm-5 nowmar">
							<div class="row">
								<div class="col-12 pad10"><?
									printPhoto($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$i]['SRC'], $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]['DESCRIPTION'][$i]);
									$i++;
								?></div>
								<div class="col-12 pad10"><?
									printPhoto($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$i]['SRC'], $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]['DESCRIPTION'][$i]);
									$i++;
								?></div>
							</div>
						</div><div class="col-12 col-sm-7 pad10"><?
							printPhoto($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$i]['SRC'], $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]['DESCRIPTION'][$i]);
						?></div><?
					}
					echo('</div>');
					$direction = -$direction;
				} else if($PhotoCount - $i == 2) {
					?><div class="row rowgal"><div class="col-12 col-sm-6 pad10"><?
						printPhoto($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$i]['SRC'], $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]['DESCRIPTION'][$i]);
						$i++;
					?></div><div class="col-12 col-sm-6 pad10"><?
						printPhoto($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$i]['SRC'], $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]['DESCRIPTION'][$i]);
					?></div></div><?
				} else if($PhotoCount - $i == 1) {
					?><div class="row rowgal"><div class="col-12 pad10"><?
						printPhoto($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$i]['SRC'], $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]['DESCRIPTION'][$i]);
					?></div></div><?
				}
			}?></div><script type="text/javascript">
			Fancybox.bind("[data-fancybox]", {
				Images: {
					initialSize: "fit",
					protected: true,
				},
			});
			</script><?
		}
	}?>
</div>