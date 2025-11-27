<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Согласие на обработку персональных данных пользователя сайта");
$APPLICATION->SetPageProperty("top_background", "/imgs/uchastki_v_mo.webp");
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-xl-10 offset-xl-1">
<p>Я, являясь субъектом персональных данных, свободно, своей волей и в своих интересах предоставляю согласие <?$APPLICATION->IncludeFile(SITE_DIR."include/ip_name.php", array(), array("MODE" => "html"));?> (<?$APPLICATION->IncludeFile(SITE_DIR."include/ip.php", array(), array("MODE" => "html"));?>, далее – Оператор) на обработку моих персональных данных посредством автоматизированных сбора, записи, систематизации, накопления, хранения, уточнения (обновления, изменения), извлечения, использования, передачи (предоставления, доступа), блокирования, удаления и уничтожения в следующих целях:</p>
<ul>
<li><p>Проведение консультаций о товарах, размещенных на сайте <a href="/">https://<?=$_SERVER["HTTP_HOST"]?></a> (далее – Сайт) Оператора.</p></li>
<li><p>Анализ статистической и аналитической информации обо мне, как пользователя Сайта.</p></li>
</ul>

<p>Настоящее согласие на обработку персональных данных предоставлено в отношении следующих категорий персональных данных: имя, номер мобильного телефона, адрес электронной почты.</p>
<p>Я ознакомился и принимаю условия Политики в отношении персональных данных, размещенной по адресу <a href="/privacy-policy/">https://<?=$_SERVER["HTTP_HOST"]?>/privacy-policy/</a>.</p>
<p>Я разрешаю передачу согласия любым третьими лицам с соблюдением указанных целей.</p>
<p>Хранение персональных данных Оператором осуществляется в течение 2-х лет с даты предоставления согласия (проставления галочки согласия на Сайте Оператора), либо до отзыва мной данного согласия на обработку персональных данных путем направления соответствующего обращения Оператору по электронной почте по адресу <?$APPLICATION->IncludeFile(SITE_DIR."include/email.php", array(), array("MODE" => "text"));?> или путем направления письменного заявления посредством почтовой связи по адресу <?$APPLICATION->IncludeFile(SITE_DIR."include/address.php", array(), array("MODE" => "html"));?>.</p>

<p>&nbsp;</p>
				<div class="frame banner mt-4 mb-3"><?$APPLICATION->IncludeFile(SITE_DIR."include/survey.php", array(), array("MODE" => "html"));?></div>
			</div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>