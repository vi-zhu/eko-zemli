<? 
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); // Проверка на подключение ядра
use Bitrix\Main\Loader; // Подключаем модули
Loader::includeModule('subscribe'); // Подключаем модуль Подписка, рассылки

$UID = (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"])));
?>
<div class="subscribe__text"><?= $arResult['SUBTITLE']; ?></div>
<form action="<?=$componentPath?>/include/ajax.php" class="subscribe__form" method="post">
	<div class="input__container">
		<input placeholder="Ваш e-mail" required name="email" data-type="email" type="email"><button class="footer-subscribe-btn" type="submit" title="Подписаться на новые предложения"><i class="mso mi mi_subscribe"></i></button>
		<div class="subscribe_soglasie"><input type="checkbox" name="soglasie" value="yes" required> Даю <a target="_blank" href="/soglasie-na-obrabotku/<?if($UID != ""){ echo "?uid=".$UID; }?>">согласие на обработку</a> моих персональных данных в соответствии с <a target="_blank" href="/privacy-policy/<?if($UID != ""){ echo "?uid=".$UID; }?>">политикой конфиденциальности</a></div>
	</div>
</form>
<div class="subscribe__mailing"></div>