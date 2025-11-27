<?
$POSELOK_ID = array_key_exists('id', $_GET) ? (int)$_GET['id'] : 4153;
$SELLOT_ID = array_key_exists('sel', $_GET) ? (int)$_GET['sel'] : 0;
$COLOR_ID = "blue";
$SECTION_ID = 0;
$MAP_FILTER_SQUARE = array(array(0, 5), array(6, 8), array(9, 10), array(11, 15), array(16, 0));
$LZS1 = 12;
$LZS2 = 2;
$LZS3 = 2;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $POSELOK_ID;

$template = ".default";
?> 
<?$APPLICATION->IncludeComponent("bitrix:catalog.element", $template, Array(
	"IBLOCK_ID" => "5",	// Инфоблок
		"IBLOCK_TYPE" => "site",	// Тип инфоблока
		"ELEMENT_CODE" => "",	// Код элемента
		"COMPARE_PATH" => "".$_GET["mode"],	// Передяем наш собственный параметр
		"ELEMENT_ID" => $POSELOK_ID,	// ID элемента
		"SELLOT_ID" => $SELLOT_ID,	// ID лота
		"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"ADDITIONAL_FILTER_NAME" => "elementFilter",	// Имя массива со значениями фильтра для дополнительной фильтрации элемента
		"ADD_DETAIL_TO_SLIDER" => "N",	// Добавлять детальную картинку в слайдер
		"ADD_ELEMENT_CHAIN" => "N",	// Включать название элемента в цепочку навигации
		"ADD_PICT_PROP" => "-",	// Дополнительная картинка основного товара
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
        "ADD_PICT_PROP" => "MORE_PHOTO",
		"ADD_TO_BASKET_ACTION" => array(
			0 => "BUY",
		),
		"ADD_TO_BASKET_ACTION_PRIMARY" => array(
			0 => "BUY",
		),
		"BACKGROUND_IMAGE" => "-",	// Установить фоновую картинку для шаблона из свойства
		"BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
		"BLOG_USE" => "N",	// Использовать комментарии
		"BRAND_PROPERTY" => "-",	// Свойство брендов
		"BRAND_PROP_CODE" => array(
			0 => "BRAND_REF",
			1 => "",
		),
		"BRAND_USE" => "N",	// Использовать компонент "Бренды"
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHECK_SECTION_ID_VARIABLE" => "N",	// Использовать код группы из переменной, если не задан раздел элемента
		"COMPATIBLE_MODE" => "Y",	// Включить режим совместимости
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"DATA_LAYER_NAME" => "dataLayer",	// Имя контейнера данных
		"DETAIL_PICTURE_MODE" => array(	// Режим показа детальной картинки
			0 => "POPUP",
			1 => "MAGNIFIER",
		),
		"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",	// Не подключать js-библиотеки в компоненте
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"FILE_404" => "",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"LABEL_PROP" => "",	// Свойство меток товара
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "top-left",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",	// URL на страницу, где будет показан список связанных элементов
		"LINK_IBLOCK_ID" => "",	// ID инфоблока, элементы которого связаны с текущим элементом
		"LINK_IBLOCK_TYPE" => "",	// Тип инфоблока, элементы которого связаны с текущим элементом
		"LINK_PROPERTY_SID" => "",	// Свойство, в котором хранится связь
		"MAIN_BLOCK_OFFERS_PROPERTY_CODE" => array(
			0 => "COLOR_REF",
		),
		"MAIN_BLOCK_PROPERTY_CODE" => array(
			0 => "MATERIAL",
		),
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
		"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
		"MESS_COMMENTS_TAB" => "Комментарии",	// Текст вкладки "Комментарии"
		"MESS_DESCRIPTION_TAB" => "Описание",	// Текст вкладки "Описание"
		"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
		"MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",	// Сообщение о недоступности услуги
		"MESS_PROPERTIES_TAB" => "Характеристики",	// Текст вкладки "Характеристики"
		"MESS_RELATIVE_QUANTITY_FEW" => "мало",
		"MESS_RELATIVE_QUANTITY_MANY" => "много",
		"MESS_SHOW_MAX_QUANTITY" => "Наличие",
		"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
		"PRICE_CODE" => "",	// Тип цены
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"PRODUCT_INFO_BLOCK_ORDER" => "sku,props",	// Порядок отображения блоков информации о товаре
		"PRODUCT_PAY_BLOCK_ORDER" => "rating,price,quantityLimit,quantity,buttons",	// Порядок отображения блоков покупки товара
		"PRODUCT_PROPERTIES" => array(
			0 => "NEWPRODUCT",
			1 => "SALELEADER",
			2 => "MATERIAL",
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PRODUCT_QUANTITY_VARIABLE" => "",	// Название переменной, в которой передается количество товара
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(
			0 => "MANUFACTURER",
			1 => "MATERIAL",
			2 => "",
		),
		"RELATIVE_QUANTITY_FACTOR" => "5",
		"SECTION_CODE" => "",	// Код раздела
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => "",	// ID раздела
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"SEF_RULE" => "",	// Правило для обработки
		"SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
		"SET_CANONICAL_URL" => "N",	// Устанавливать канонический URL
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"SET_VIEWED_IN_COMPONENT" => "N",
		"SHOW_404" => "N",	// Показ специальной страницы
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DEACTIVATED" => "N",	// Показывать деактивированные товары
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_MAX_QUANTITY" => "M",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"SHOW_SLIDER" => "Y",	// Показывать слайдер для товаров
		"SLIDER_INTERVAL" => "5000",	// Интервал смены слайдов, мс
		"SLIDER_PROGRESS" => "N",	// Показывать полосу прогресса
		"STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа элемента
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"USE_COMMENTS" => "Y",	// Включить отзывы о товаре
		"USE_ELEMENT_COUNTER" => "Y",	// Использовать счетчик просмотров
		"USE_ENHANCED_ECOMMERCE" => "Y",	// Включить отправку данных в электронную торговлю
		"USE_GIFTS_DETAIL" => "Y",
		"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
		"USE_MAIN_ELEMENT_SECTION" => "N",	// Использовать основной раздел для показа элемента
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"USE_PRODUCT_QUANTITY" => "Y",	// Разрешить указание количества товара
		"USE_VOTE_RATING" => "Y",	// Включить рейтинг товара
		"VK_USE" => "N",	// Использовать Вконтакте
		"VOTE_DISPLAY_AS_RATING" => "rating",	// В качестве рейтинга показывать
		"COMPONENT_TEMPLATE" => ".default",
		"IMAGE_RESOLUTION" => "16by9",	// Соотношение сторон изображения товара
		"MESS_PRICE_RANGES_TITLE" => "Цены",	// Название блока c расширенными ценами
		"SHOW_SKU_DESCRIPTION" => "N",	// Отображать описание для каждого торгового предложения
		"USE_RATIO_IN_RANGES" => "N",	// Учитывать коэффициенты для диапазонов цен
		"UID" => "".$_GET["uid"]
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>