<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
$UID = (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"])));
?>
<div class="hidden_block" id="brondiv">
<script data-b24-form="click/10/dmevo8" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://cdn-ru.bitrix24.ru/b29466034/crm/form/loader_10.js');</script>
</div>
<div class="footer">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<div class="row">
					<div class="col-12 col-md-4 col-lg-3 col-xl-3">
						<a href="/<?if($UID != ""){ echo "?uid=".$UID; }?>" title="На главную"><div class="blogo" id="blogo"></div></a>
						<div class="footer_contacts">
							<div class="office">
								<div class="footer_office"><?$APPLICATION->IncludeFile(SITE_DIR."include/phone.php", array(), array("MODE" => "text"));?></div>
								<div class="footer_address"><?$APPLICATION->IncludeFile(SITE_DIR."include/address.php", array(), array("MODE" => "text"));?></div>
								<div class="footer_email"><?$APPLICATION->IncludeFile(SITE_DIR."include/email.php", array(), array("MODE" => "text"));?></div>
							</div>
						</div>

					</div>
					<div class="col-12 col-md-8 col-lg-6 col-xl-6"><?$APPLICATION->IncludeComponent("bitrix:menu", "bottom", Array(
		"ROOT_MENU_TYPE" => "top", 
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A", 
		"MENU_CACHE_TIME" => "36000000",
		"UID" => "".$_GET["uid"], 
		"MENU_CACHE_USE_GROUPS" => "Y", 
		"MENU_CACHE_GET_VARS" => ""
	),
	false);?></div>
					<div class="col-12 col-md-12 col-lg-3 col-xl-3">
						<div class="subscribe">
						<p class="bm-title">Земельные участки Подмосковья</p>
<?$APPLICATION->IncludeComponent("neosoft:simplesubscription","",Array(
		"TITLE" => "", 
		"SUBTITLE" => "Хотите узнавать первыми о новых предложениях?", 
		"BUTTON" => "Подписаться", 
		"POLICY" => "/privacy-policy/",
		"CACHE_TYPE" => "N", 
		"CACHE_TIME" => "36000000" 
	)
);?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="footer_footer">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<div class="row">
					<div class="col-12">
						<div class="copyright">© <?=$business_founded?> — <?php echo date('Y') ?> «ЭКО Земли»</div>
						<div class="policy"><a href="/privacy-policy/<?if($UID != ""){ echo "?uid=".$UID; }?>">Политика конфиденциальности</a>, <a href="/soglasie-na-obrabotku/<?if($UID != ""){ echo "?uid=".$UID; }?>">Согласие на обработку персональных данных</a>, <a href="/sitemap/<?if($UID != ""){ echo "?uid=".$UID; }?>">Карта сайта</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="cookie_cont" class="py-4 py-sm-4 py-xl-5">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
				<div class="cookie_box d-flex flex-wrap flex-md-nowrap justify-content-center justify-content-md-between align-items-center gap-3 gap-sm-3 gap-md-4 gap-xl-5">
					<div class="text-center text-md-start">К сайту подключен сервис веб-аналитики Яндекс Метрика, использующий cookie-файлы. Нажимая кнопку «согласен» Вы даете свое <a href="/soglasie-na-obrabotku/<?if($UID != ""){ echo "?uid=".$UID; }?>" target="_blank">согласие на обработку персональных данных</a> с помощью этого сервиса в порядке, указанном в <a href="/privacy-policy/<?if($UID != ""){ echo "?uid=".$UID; }?>" target="_blank">Политике конфиденциальности</a></div>
					<div class="buttons"><a id="btn_cookie_accept" class="button">Согласен</a><a id="btn_cookie_reject" class="button frbtn">Не согласен</a></div>
				</div>
			</div>
		</div>
	</div>
</div>
<noscript><div><img id="yandex_img" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<script src="//code.jivo.ru/widget/Oj08DONTKm" async></script>
</body>
</html>