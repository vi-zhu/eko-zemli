<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Запрашиваемая страница не найдена");
$APPLICATION->SetPageProperty("top_background", "/imgs/pokupka_zemli.webp");
$APPLICATION->AddChainItem($APPLICATION->GetTitle());
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<div class="h1">Такой страницы не существует</div>
				<div class="hr"></div>
				<div class="row align-items-center">
					<div class="col-12 col-md-6 order-md-1 text-center" style="font-size: 11rem; font-weight: 400;">404</div>
					<div class="col-12 col-md-6 order-md-0">
						<div class="mt-4 mb-4">Такой страницы на сайте нет. Однако вы непременно найдете то что искали в данных разделах:</div>
						<div class="sort_ord">
							<a href="/">На главную</a>
							<a href="/zemelnye-uchastki-v-moskovskoy-oblasti/">Участки</a>
							<a href="/poselki-v-moskovskoj-oblasti/">Поселки</a>
						</div>
					</div>
				</div>
<div class="frame banner mt-4 mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>