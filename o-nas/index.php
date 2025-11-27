<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О нашей компании");
$APPLICATION->SetPageProperty("top_background", "/imgs/uschastki_s_dorogoi.webp");

$UID = (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"])));
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1 about">
				<div class="row align-items-center">
					<div class="col-12 col-lg-7">
						<div class="founded mb-4">Работаем для Вас с <?=$business_founded?> года</div>
						<?$APPLICATION->IncludeFile(SITE_DIR."include/about1.php", array("age" => (date('Y') - $business_founded)), array("MODE" => "html"));?>
					</div>
					<div class="col-12 col-lg-5 col-xl-4 offset-xl-1"><?

$areas_count = count($areas = get_hl_table(2, 100));

$resElemCnt = CIBlockElement::GetList(
	false, // сортировка
	array('IBLOCK_ID' => 6, "ACTIVE" => "Y", "PROPERTY_52_VALUE" => "в продаже", ">PROPERTY_46" => 0), // фильтрация
	false, // параметры группировки полей
	false, // параметры навигации
	array("ID") // поля для выборки
);
$lots_count = $resElemCnt -> SelectedRowsCount();

$resElemCnt = CIBlockElement::GetList(
	false, // сортировка
	array('IBLOCK_ID' => 5), // фильтрация
	false, // параметры группировки полей
	false, // параметры навигации
	array("ID") // поля для выборки
);
$villages_count = $resElemCnt -> SelectedRowsCount();
						?>
						<div class="align-items-center mt-4 mt-lg-0">
							<div class="text-center">
								<div class="advantage"><span class="big"><?=(date('Y') - $business_founded)?><span class="small"> лет</span></span>на рынке</div><div class="advantage"><span class="big"><?=$areas_count?><span class="small"><?=" ".rayonov($areas_count)?></span></span>Подмосковья</div><div class="advantage"><span class="big"><?=$lots_count?></span><?=getLotsEnd($lots_count)?><br>в продаже</div><div class="advantage"><span class="big"><?=$villages_count?></span><?=getPoselkovPostroeno($villages_count)?></div>
							</div>
						</div>
					</div>
				</div>
				<div class="row buy">
					<?$APPLICATION->IncludeFile(SITE_DIR."include/about2.php", array("age" => (date('Y') - $business_founded)), array("MODE" => "html"));?>
					<?$APPLICATION->IncludeFile(SITE_DIR."include/about3.php", array("age" => (date('Y') - $business_founded)), array("MODE" => "html"));?>
				</div>
				<div class="h2 mb-4 mt-5">Последние новости</div>
				<div><?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"", 
	array(
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"UID" => $UID,
		"CHECK_DATES" => "Y",
		"COLOR_NEW" => "3E74E6",
		"COLOR_OLD" => "C0C0C0",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DETAIL_ACTIVE_DATE_FORMAT" => "j F Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "N",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "DT",
			1 => "MORE_PHOTO",
		),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_AS_RATING" => "rating",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FONT_MAX" => "50",
		"FONT_MIN" => "10",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "7",
		"IBLOCK_TYPE" => "news",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "j F Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "DT",
		),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "6",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PERIOD_NEW_TAGS" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "PROPERTY_DT",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"TAGS_CLOUD_ELEMENTS" => "150",
		"TAGS_CLOUD_WIDTH" => "100%",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "",
		"TEMPLATE_THEME" => "",
		"MEDIA_PROPERTY" => "",
		"SLIDER_PROPERTY" => "",
		"SEF_FOLDER" => "/",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "o-nas/novosti/",
			"detail" => "o-nas/novosti/#ELEMENT_CODE#/",
		)
	),
	false
				);?></div>
				<div class="buttons text-center mt-0"><a class="button" href="/o-nas/novosti/<?if($UID != ""){ echo "?uid=".$UID; }?>">Все новости<i class="mso mi_rarr right"></i></a></div>
				<div class="frame mt-5"><?print_lot_search_form(0)?></div>
				<div class="frame banner mt-5 mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<div id="map_location" style="height: 500px; width: 100%;"></div>
<script type="text/javascript" src="https://<?=$_SERVER["HTTP_HOST"]?>/js/map/?type=map&mode=poselki<?if($UID != ""){ echo "&uid=".$UID; }?>"></script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>