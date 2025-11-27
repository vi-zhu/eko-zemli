<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions.php";

function round4($val) {
	return round($val/10000)*10000;
}

$STEP = 100000;

if (CModule::IncludeModule('highloadblock')) {
	$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(4)->fetch();
	$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
	$strEntityDataClass = $obEntity->getDataClass();

	$rsData = $strEntityDataClass::getList(array(
		'select' => array('UF_VAR', 'UF_VALUE'),
	));
	$arItems = Array();
	while ($arItem = $rsData->Fetch()) {
		$arItems[$arItem['UF_VAR']] = $arItem['UF_VALUE'];
	}
	if(array_key_exists('PROFIT',$arItems) && (!$PROFIT)) { $PROFIT = $arItems['PROFIT']; }
	if(array_key_exists('PERIOD',$arItems) && (!$PERIOD)) { $PERIOD = $arItems['PERIOD']; }
	if(array_key_exists('INVEST',$arItems) && (!$INVEST)) { $INVEST = $arItems['INVEST']; }
}

if(!$PROFIT) {
	$PROFIT = 18;
}

if(!$PERIOD) {
	$PERIOD = 10;
}

if(!$PERIOD_MIN) {
	$PERIOD_MIN = 1;
}

if(!$PERIOD_MAX) {
	$PERIOD_MAX = 30;
}

if(!$INVEST) {
	$INVEST = 5000000;
}

if(!$INVEST_MIN) {
	$INVEST_MIN = 1000000;
}

if(!$INVEST_MAX) {
	$INVEST_MAX = 20000000;
}

$SUM = round($INVEST * pow((1 + ($PROFIT/100)), $PERIOD) - $INVEST);

?>
<div class="tab_content mt-2">
	<div class="tab_item active">

		<form id="f_invest">
			<input type="hidden" id="m_invest" name="m_invest" value="<?=$INVEST?>">
			<input type="hidden" id="m_invest_min" name="m_invest_min" value="<?=$INVEST_MIN?>">
			<input type="hidden" id="m_invest_max" name="m_invest_max" value="<?=$INVEST_MAX?>">
			<input type="hidden" id="m_profit" name="m_profit" value="<?=$PROFIT?>">
			<input type="hidden" id="m_period" name="m_period" value="<?=$PERIOD?>">
			<input type="hidden" id="m_period_min" name="m_period_min" value="<?=$PERIOD_MIN?>">
			<input type="hidden" id="m_period_max" name="m_period_max" value="<?=$PERIOD_MAX?>">
			<input type="hidden" id="m_sumy" name="m_sum" value="<?=$SUM?>">
			<input type="hidden" id="m_step" name="m_step" value="<?=$STEP?>">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="content_item">
						<div class="label">Размер Ваших инвестиций</div>
						<div class="val_cont">
							<div class="val_value"><span id="im_invest"><?=formatNum($INVEST)?></span> ₽</div>
						</div>
						<div class="sldr" id="sm_invest"></div>
						<div class="caption d-flex justify-content-between">
							<div>от <?=$INVEST_MIN/1000000?> млн ₽</div>
							<div>до <?=$INVEST_MAX/1000000?> млн ₽</div>
						</div>
					</div>
					<div class="content_item">
						<div class="label">Срок инвестирования</div>
						<div class="val_cont">
							<div class="val_value" id="im_period"><?=$PERIOD?></div>
						</div>
						<div class="sldr" id="sm_period"></div>
						<div class="caption d-flex justify-content-between">
							<div>от <?=$PERIOD_MIN." ".(($PERIOD_MIN > 1)?"лет":"года")?></div>
							<div>до <?=$PERIOD_MAX?> лет</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-5 offset-md-1">
					<div class="grey_box">
						<div class="content_item">
							<div class="label">Доходность</div>
							<div class="val_cont">
								<div class="val_value"><span id="im_rate"><?=$PROFIT?></span> %</div>
							</div>
						</div>
						<div class="content_item">
							<div class="label">Ваш доход</div>
							<div class="val_cont">
								<div class="val_value"><span id="im_sum"><?=formatNum($SUM)?></span> ₽</div>
							</div>
						</div>
						<div class="content_item">
							<div class="content_descr">Обратите внимание на то, что <strong>приведенные расчеты носят ознакомительный характер и не является публичной офертой</strong>. Итоговая доходность и сумма Вашего дохода будут зависеть от ситуации на рынке, выбранных участков и коттеджных посёлков.</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="buttons text-center"><a id="showbron1" class="button" onclick="show_zayavka('Заявка на консультацию по поводу инвестиций на сумму '+formatNum($('#m_invest').val())+' ₽. ')">Оставить заявку</a></div>
				</div>
			</div>
		</form>


	</div>
</div>
<div class="hidden_block" id="zayavkadiv">
<script data-b24-form="click/22/ah80xz" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://cdn-ru.bitrix24.ru/b29466034/crm/form/loader_22.js');</script>
<button></button>
</div>