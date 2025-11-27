<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Земельные участки в Московской области");
$APPLICATION->SetPageProperty("top_background", "/imgs/uchastki_v_mo.webp");
$APPLICATION->SetAdditionalCss("/calc/style.css");
$APPLICATION->AddHeadScript("/calc/jquery-ui.min.js");
$APPLICATION->AddHeadScript("/calc/jquery.ui.touch-punch.min.js");
$APPLICATION->AddHeadScript("/calc/script.js");

$UID = (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"])));
?> 
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<div class="founded mb-4">Работаем для Вас с <?=$business_founded?> года</div>
				<?$APPLICATION->IncludeFile(SITE_DIR."include/about1.php", array("age" => (date('Y') - $business_founded)), array("MODE" => "html"));?>
				<div class="row buy"><?$APPLICATION->IncludeFile(SITE_DIR."include/about2.php", array("age" => (date('Y') - $business_founded)), array("MODE" => "html"));?></div>
				<div class="buttons mb-5"><a class="button frbtn" href="/o-nas/<?if($UID != ""){ echo "?uid=".$UID; }?>">Подробнее<i class="mso mi_rarr right"></i></a></div>
				<div class="h2 mb-4">Последние новости</div>
				<div class="top3new"><?$APPLICATION->IncludeComponent(
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
		"NEWS_COUNT" => "3",
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
				<div class="h2 mb-4 mt-4">Наши поселки</div>
				<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"poselki", 
	array(
		"IBLOCK_TYPE" => "site",
		"IBLOCK_ID" => "5",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"ELEMENT_SORT_FIELD" => "SORT",
		"ELEMENT_SORT_ORDER" => "asc",
		"LINE_ELEMENT_COUNT" => 3,
		"PROPERTY_CODE" => array(),
		"PAGE_ELEMENT_COUNT" => 50,
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"UID" => (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"]))),
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"USE_FILTER" => "N",
		"FILTER_VIEW_MODE" => "HORIZONTAL",
		"FILTER_HIDE_ON_MOBILE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"COMPONENT_TEMPLATE" => "",
		"TEMPLATE_THEME" => "",
		"MEDIA_PROPERTY" => "",
		"SLIDER_PROPERTY" => "",
		"SEF_FOLDER" => "/",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"element" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
			"compare" => "",
			"smart_filter" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
		)
	),
	false
				);?>
				<!--div class="buttons text-center mt-0 mb-3"><a class="button" href="/poselki-v-moskovskoj-oblasti/<?if($UID != ""){ echo "?uid=".$UID; }?>">Все поселки<i class="mso mi_rarr right"></i></a></div-->
				<div class="infotext"><?$APPLICATION->IncludeFile(SITE_DIR."include/home.php", array(), array("MODE" => "html"));?></div>
</div></div></div></div>
<div class="canvas mb-5">
	<div class="content mt-0 mb-3"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
		<?$APPLICATION->IncludeFile(SITE_DIR."include/buy.php", array(), array("MODE" => "html"));?>
	</div></div></div></div>
</div>
<div class="content mt-0 mb-2"><div class="container-fluid"><div class="row"><div class="col-12 col-xl-10 offset-xl-1">
				<div class="frame mb-4"><?$APPLICATION->IncludeFile(SITE_DIR."calc/calc.php", array(), array("MODE" => "html"));?></div>
				<p>&nbsp;</p>
				<div class="frame banner mt-4"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<div id="map_location" style="height: 500px; width: 100%;"></div>
<script type="text/javascript" src="https://<?=$_SERVER["HTTP_HOST"]?>/js/map/?type=map&mode=poselki<?if($UID != ""){ echo "&uid=".$UID; }?>"></script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>