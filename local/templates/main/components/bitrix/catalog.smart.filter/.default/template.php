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

use Bitrix\Iblock\SectionPropertyTable;

$this->setFrameMode(true);

function get_col_order_3($i) {
	if($i == 71) {
		return 0;
	} else if($i == 60) {
		return 3;
	} else if($i == 72) {
		return 1;
	} else if($i == 73) {
		return 4;
	} else if($i == 59) {
		return 2;
	} else if($i == 61) {
		return 5;
	} else {
		return 100;
	}
}

global $arrFilter;

//echo "<pre>"; print_r($arrFilter); echo "</pre>";

$my_title = "";
$my_descr = "";

$PAGEN = "";
if(array_key_exists("PAGEN_1", $_GET)) {
	$PAGEN = " — страница&nbsp;".$_GET["PAGEN_1"];
}

$show_all_inputs = true;
if($arParams['SECTION_ID'] > 0) { $show_all_inputs = false; }

use Bitrix\Highloadblock\HighloadBlockTable;
\Bitrix\Main\Loader::includeModule("highloadblock");

if($arrFilter["=PROPERTY_71"]) {
	if(is_array($arrFilter["=PROPERTY_71"])) {
		$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
		$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
		$rsData = $strEntityDataClass::getList(array(
			'select' => array('ID', 'UF_DESCRIPTION'),
			'filter' => array('=UF_XML_ID' => $arrFilter["=PROPERTY_71"][0])
		));
		while ($arHLItem = $rsData->Fetch()) {
			$my_title .= " по ".$arHLItem["UF_DESCRIPTION"]." шоссе";
			break;
		}
	}
}

if($arrFilter["=PROPERTY_60"]) {
	if(is_array($arrFilter["=PROPERTY_60"])) {
		$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(2)->fetch();
		$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
		$rsData = $strEntityDataClass::getList(array(
			'select' => array('ID', 'UF_DESCRIPTION'),
			'filter' => array('=UF_XML_ID' => $arrFilter["=PROPERTY_60"][0])
		));
		while ($arHLItem = $rsData->Fetch()) {
			$my_title .= " в ".$arHLItem["UF_DESCRIPTION"];
			break;
		}
	}
}

if($arrFilter["><PROPERTY_72"]) {
	if(is_array($arrFilter["><PROPERTY_72"])) {
		$my_title .= " на расстоянии ".$arrFilter["><PROPERTY_72"][0]." — ".$arrFilter["><PROPERTY_72"][1]."&nbsp;км от МКАД";
	}
} else if($arrFilter["<=PROPERTY_72"]) {
	$my_title .= " на расстоянии не более ".$arrFilter["<=PROPERTY_72"]."&nbsp;км от МКАД";
} else if($arrFilter[">=PROPERTY_72"]) {
	$my_title .= " на расстоянии более ".$arrFilter[">=PROPERTY_72"]."&nbsp;км от МКАД";
}

if($arrFilter["><PROPERTY_73"]) {
	if(is_array($arrFilter["><PROPERTY_73"])) {
		$my_title .= " в ".$arrFilter["><PROPERTY_73"][0]." — ".$arrFilter["><PROPERTY_73"][1]."&nbsp;минутах пути от Москвы";
	}
} else if($arrFilter["<=PROPERTY_73"]) {
	$my_title .= " в не более чем ".$arrFilter["<=PROPERTY_73"]."&nbsp;минутах пути от Москвы";
} else if($arrFilter[">=PROPERTY_73"]) {
	$my_title .= " в более чем ".$arrFilter[">=PROPERTY_73"]."&nbsp;минутах пути от Москвы";
}


if($arrFilter["><PROPERTY_59"]) {
	if(is_array($arrFilter["><PROPERTY_59"])) {
		$my_title .= " площадью ".formatNum($arrFilter["><PROPERTY_59"][0])." — ".formatNum($arrFilter["><PROPERTY_59"][1])."&nbsp;соток";
	}
} else if($arrFilter["<=PROPERTY_59"]) {
	$my_title .= " площадью до ".formatNum($arrFilter["<=PROPERTY_59"])."&nbsp;соток";
} else if($arrFilter[">=PROPERTY_59"]) {
	$my_title .= " площадью от ".formatNum($arrFilter[">=PROPERTY_59"])."&nbsp;соток";
}

if($arrFilter["><PROPERTY_61"]) {
	if(is_array($arrFilter["><PROPERTY_61"])) {
		$my_title .= " стоимостью ".formatNum($arrFilter["><PROPERTY_61"][0])." — ".formatNum($arrFilter["><PROPERTY_61"][1])."&nbsp;₽";
	}
} else if($arrFilter["<=PROPERTY_61"]) {
	$my_title .= " стоимостью до ".formatNum($arrFilter["<=PROPERTY_61"])."&nbsp;₽";
} else if($arrFilter[">=PROPERTY_61"]) {
	$my_title .= " стоимостью от ".formatNum($arrFilter[">=PROPERTY_61"])."&nbsp;₽";
}

if($my_title != "") {
	//$my_title = str_replace("&nbsp;", " ", $my_title);
	$my_descr = "Продажа земельных участков в Московской области".$my_title;
	$my_title = "Земельные участки".$my_title;

	$APPLICATION->SetPageProperty("title", $my_title);
	$APPLICATION->SetTitle($my_title.$PAGEN);
	$APPLICATION->SetPageProperty("description", strip_tags($my_descr));
} else {
	$APPLICATION->SetTitle("Земельные участки в Московской области".$PAGEN);
}

?>
<div class="bx-filter"><form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
	<?foreach($arResult["HIDDEN"] as $arItem):?>
	<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
	<?endforeach;?>
	<div class="row"><?
		$order_cb = 0;
		$order_inpt = 2;
		foreach($arResult["ITEMS"] as $key=>$arItem) {
			if(
				empty($arItem["VALUES"])
				|| isset($arItem["PRICE"]) || $arItem["DISPLAY_TYPE"] == "F"
			)
				continue;

			if (
				$arItem["DISPLAY_TYPE"] === SectionPropertyTable::NUMBERS_WITH_SLIDER
				&& ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
			)
				continue;

			if($show_all_inputs || $key == 59 || $key == 61) {
		?><div class="col-<?=($key == 60 || $key == 71)?6:12?><?if($arItem["CODE"] == "mkad" || $arItem["CODE"] == "mmkad"){?> d-none d-sm-block<?}?> col-sm-6 <?if($show_all_inputs) {?>col-lg-4 order-lg-<?=get_col_order_3($key)?><?}?> bx-filter-parameters-box bx-active">
			<span class="bx-filter-container-modef"></span>
			<div class="bx-filter-parameters-box-title">
				<span class="bx-filter-parameters-box-hint"><?=$arItem["NAME"]?></span>
			</div>

			<div class="bx-filter-block" data-role="bx_filter_block">
				<div class="bx-filter-parameters-box-container align-items-center"><?
							$arCur = current($arItem["VALUES"]);

							switch ($arItem["DISPLAY_TYPE"])
							{
								case SectionPropertyTable::NUMBERS://NUMBERS
									?>
					<div class="bx-fblock"><input class="min-price" placeholder="<?=GetMessage("CT_BCSF_FILTER_FROM")?>" type="text" name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>" id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>" value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>" onkeyup="smartFilter.keyup(this)" /></div>
					<div class="bx-fblock">—</div>
					<div class="bx-fblock"><input class="max-price" placeholder="<?=GetMessage("CT_BCSF_FILTER_TO")?>" ype="text" name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>" id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>" value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>" onkeyup="smartFilter.keyup(this)" /></div><?
									break;

								case SectionPropertyTable::DROPDOWN://DROPDOWN
									$checkedItemExist = false;
									?>
					<div class="w-100">
						<div class="bx-filter-select-container">
							<div class="bx-filter-select-block form-select" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
								<div class="bx-filter-select-text" data-role="currentOption"><?
													foreach ($arItem["VALUES"] as $val => $ar)
													{
														if ($ar["CHECKED"])
														{
															echo $ar["VALUE"];
															$checkedItemExist = true;
														}
													}
													if (!$checkedItemExist)
													{
														echo GetMessage("CT_BCSF_FILTER_ALL");
													}
													?>
								</div>
								<div class="bx-filter-select-arrow"></div>
								<input
													style="display: none"
													type="radio"
													name="<?=$arCur["CONTROL_NAME_ALT"]?>"
													id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
													value=""
								/>
												<?foreach ($arItem["VALUES"] as $val => $ar):?>
								<input
														style="display: none"
														type="radio"
														name="<?=$ar["CONTROL_NAME_ALT"]?>"
														id="<?=$ar["CONTROL_ID"]?>"
														value="<? echo $ar["HTML_VALUE_ALT"] ?>"
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
								/>
												<?endforeach?>
								<div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none;">
									<ul>
										<li>
											<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx-filter-param-label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
												<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
											</label>
										</li>
													<?
													foreach ($arItem["VALUES"] as $val => $ar):
														$class = "";
														if ($ar["CHECKED"])
															$class.= " selected";
														if ($ar["DISABLED"])
															$class.= " disabled";
													?>
										<li>
											<label for="<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" data-role="label_<?=$ar["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')"><?=$ar["VALUE"]?></label>
										</li>
													<?endforeach?>
									</ul>
								</div>
							</div>
						</div>
					</div>
									<?
									break;
							}
							?>
				</div>
				<div style="clear: both"></div>
			</div>
		</div><?
			}
		}
?></div><!--//row--><div class="row"><?
		foreach($arResult["ITEMS"] as $key=>$arItem) {
			if(
				$arItem["DISPLAY_TYPE"] != "F"
			)
				continue;
		?><div class="col-12 bx-filter-parameters-box bx-active">
			<span class="bx-filter-container-modef"></span>

			<div class="bx-filter-block" data-role="bx_filter_block">
				<div class="bx-filter-parameters-box-container align-items-center"><?
					$arCur = current($arItem["VALUES"]);
					?><div class="bx-fblock checkbox align-items-center"><?foreach($arItem["VALUES"] as $val => $ar):?><input
															type="checkbox"
															value="<? echo $ar["HTML_VALUE"] ?>"
															name="<? echo $ar["CONTROL_NAME"] ?>"
															id="<? echo $ar["CONTROL_ID"] ?>"
															<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
															onclick="smartFilter.click(this)"
					/><label for="<? echo $ar["CONTROL_ID"] ?>" class="checkbox-label"><?=$arItem["NAME"]?></label><?endforeach;?></div>
				</div>
			</div>
		</div>
		<?}
		?>
	</div><!--//row-->
	<div class="row">
		<div class="col-xs-12 buttons filter-btn-cont">
			<button class="btn_order" type="submit" id="set_filter" name="set_filter"><?=GetMessage("CT_BCSF_SET_FILTER")?></button>
			<button class="frbtn" type="submit" id="del_filter" name="del_filter"><?=GetMessage("CT_BCSF_DEL_FILTER")?></button>
			<span class="bx-filter-popup-result" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
				<a class="frbtn_gr" href="<?echo $arResult["FILTER_URL"]?>" target=""><?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.(int)($arResult["ELEMENT_COUNT"] ?? 0).'</span>'));?><i class="mso mi_rarr"></i><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
			</span>
		</div>
	</div>
	<div class="clb"></div>
</form></div>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>