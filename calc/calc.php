<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

require_once $_SERVER['DOCUMENT_ROOT'] . "/functions.php";

function round4($val) {
	return round($val/10000)*10000;
}

$STEP = 10000;
if($SUM) {
	$STEP = 100;
}

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
	if(array_key_exists('RATE',$arItems) && (!$RATE)) { $RATE = $arItems['RATE']; }
	if(array_key_exists('SUM',$arItems) && (!$SUM)) { $SUM = $arItems['SUM']; }
	if(array_key_exists('SUM_MIN',$arItems) && (!$SUM_MIN)) { $SUM_MIN = $arItems['SUM_MIN']; }
	if(array_key_exists('SUM_MAX',$arItems) && (!$SUM_MAX)) { $SUM_MAX = $arItems['SUM_MAX']; }
	if(array_key_exists('PERCENT',$arItems) && (!$PERCENT)) { $PERCENT = $arItems['PERCENT']; }
	if(array_key_exists('PERCENT_MIN',$arItems) && (!$PERCENT_MIN)) { $PERCENT_MIN = $arItems['PERCENT_MIN']; }
	if(array_key_exists('PERCENT_MAX',$arItems) && (!$PERCENT_MAX)) { $PERCENT_MAX = $arItems['PERCENT_MAX']; }
	if(array_key_exists('TERM',$arItems) && (!$TERM)) { $TERM = $arItems['TERM']; }
	if(array_key_exists('TERM_MIN',$arItems) && (!$TERM_MIN)) { $TERM_MIN = $arItems['TERM_MIN']; }
	if(array_key_exists('TERM_MAX',$arItems) && (!$TERM_MAX)) { $TERM_MAX = $arItems['TERM_MAX']; }
	if(array_key_exists('PERCENT_I',$arItems) && (!$PERCENT_I)) { $PERCENT_I = $arItems['PERCENT_I']; }
	if(array_key_exists('PERCENT_MIN_I',$arItems) && (!$PERCENT_MIN_I)) { $PERCENT_MIN_I = $arItems['PERCENT_MIN_I']; }
	if(array_key_exists('PERCENT_MAX_I',$arItems) && (!$PERCENT_MAX_I)) { $PERCENT_MAX_I = $arItems['PERCENT_MAX_I']; }
	if(array_key_exists('TERM_I',$arItems) && (!$TERM_I)) { $TERM_I = $arItems['TERM_I']; }
	if(array_key_exists('TERM_MIN_I',$arItems) && (!$TERM_MIN_I)) { $TERM_MIN_I = $arItems['TERM_MIN_I']; }
	if(array_key_exists('TERM_MAX_I',$arItems) && (!$TERM_MAX_I)) { $TERM_MAX_I = $arItems['TERM_MAX_I']; }
}

if(!$RATE) {
	$RATE = 18;
}

if(!$SUM) {
	$SUM = 1000000;
}

if(!$SUM_MIN) {
	$SUM_MIN = 400000;
}

if(!$SUM_MAX) {
	$SUM_MAX = 5000000;
}

if($PERCENT) {
	$SUM0 = round4($SUM * $PERCENT / 100);
} else {
	if($SUM0) {
		$SUM0 = round4($SUM0);
		$PERCENT = round(($SUM0 / $SUM)*100);
	} else {
		$PERCENT = 30;
		$SUM0 = round4($SUM * $PERCENT / 100);
	}
}

if(!$PERCENT_MIN) {
	$PERCENT_MIN = 20;
}

if(!$PERCENT_MAX) {
	$PERCENT_MAX = 75;
}

if(!$TERM) {
	$TERM = 10;
}

if(!$TERM_MIN) {
	$TERM_MIN = 1;
}

if(!$TERM_MAX) {
	$TERM_MAX = 30;
}

$CREDIT = $SUM - $SUM0;
$MPC = $RATE / 1200;
$PA = $TERM * 12;
$PAY = round($CREDIT * (($MPC * pow(1 + $MPC, $PA)) / ((pow(1 + $MPC, $PA) - 1))));


if($PERCENT_I) {
	$SUM0_I = round4($SUM * $PERCENT_I / 100);
} else {
	if($SUM0_I) {
		$SUM0_I = round4($SUM0_I);
		$PERCENT_I = round(($SUM0_I / $SUM)*100);
	} else {
		$PERCENT_I = 70;
		$SUM0_I = round4($SUM * $PERCENT_I / 100);
	}
}

if(!$PERCENT_MIN_I) {
	$PERCENT_MIN_I = 50;
}

if(!$PERCENT_MAX_I) {
	$PERCENT_MAX_I = 90;
}

if(!$TERM_I) {
	$TERM_I = 6;
}

if(!$TERM_MIN_I) {
	$TERM_MIN_I = 2;
}

if(!$TERM_MAX_I) {
	$TERM_MAX_I = 6;
}

$CREDIT_I = $SUM - $SUM0_I;

$PAY_I = round($CREDIT_I / $TERM_I);

?>
<div class="tabs_header mb-3 d-flex align-items-center justify-content-center">
	<div class="tab_trigger active" data-tab="1">Ипотека</div>
	<div class="tab_toggle"><i id="tab_toggle" class="mso mi_toggle1" data-tab="1"></i></div>
	<div class="tab_trigger" data-tab="2">Рассрочка</div>
</div>
<div class="tab_content">
	<div class="tab_item active" data-tab="1">


		<form id="f_mortgage">
			<input type="hidden" id="m_price" name="m_price" value="<?=$SUM?>">
			<input type="hidden" id="m_price_min" name="m_price_min" value="<?=$SUM_MIN?>">
			<input type="hidden" id="m_price_max" name="m_price_max" value="<?=$SUM_MAX?>">
			<input type="hidden" id="m_contribution" name="m_contribution" value="<?=$SUM0?>">
			<input type="hidden" id="m_percent" name="m_percent" value="<?=$PERCENT?>">
			<input type="hidden" id="m_percent_min" name="m_percent_min" value="<?=$PERCENT_MIN?>">
			<input type="hidden" id="m_percent_max" name="m_percent_max" value="<?=$PERCENT_MAX?>">
			<input type="hidden" id="m_term" name="m_term" value="<?=$TERM?>">
			<input type="hidden" id="m_term_min" name="m_term_min" value="<?=$TERM_MIN?>">
			<input type="hidden" id="m_term_max" name="m_term_max" value="<?=$TERM_MAX?>">
			<input type="hidden" id="m_credit" name="m_credit" value="<?=$CREDIT?>">
			<input type="hidden" id="m_rate" name="m_rate" value="<?=$RATE?>">
			<input type="hidden" id="m_pay" name="m_pay" value="<?=$PAY?>">
			<input type="hidden" id="m_step" name="m_step" value="<?=$STEP?>">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="content_item">
						<div class="label">Стоимость участка</div>
						<div class="val_cont">
							<div class="val_value"><span id="im_price"><?=formatNum($SUM)?></span> ₽</div>
						</div>
						<div class="sldr" id="sm_price"></div>
						<div class="caption d-flex justify-content-between">
							<div>от <?=$SUM_MIN/1000000?> млн ₽</div>
							<div>до <?=$SUM_MAX/1000000?> млн ₽</div>
						</div>
					</div>
					<div class="content_item">
						<div class="label">Первоначальный взнос</div>
						<div class="val_cont d-flex justify-content-between">
							<div class="val_value"><span id="im_contribution"><?=formatNum($SUM0)?></span> ₽</div>
							<div class="val_value"><span id="im_percent"><?=$PERCENT?></span> %</div>
						</div>
						<div class="sldr" id="sm_percent"></div>
						<div class="caption d-flex justify-content-between">
							<div>от <?=$PERCENT_MIN?>%</div>
							<div>до <?=$PERCENT_MAX?>%</div>
						</div>
					</div>
					<div class="content_item">
						<div class="label">Срок ипотеки</div>
						<div class="val_cont">
							<div class="val_value" id="im_term"><?=$TERM?></div>
						</div>
						<div class="sldr" id="sm_term"></div>
						<div class="caption d-flex justify-content-between">
							<div>от <?=$TERM_MIN." ".(($TERM_MIN > 1)?"лет":"года")?></div>
							<div>до <?=$TERM_MAX?> лет</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-5 offset-md-1">
					<div class="grey_box">
						<div class="content_item">
							<div class="label">Процентная ставка</div>
							<div class="val_cont">
								<div class="val_value"><span id="im_rate"><?=$RATE?></span> %</div>
							</div>
						</div>
						<div class="content_item">
							<div class="label">Сумма кредита</div>
							<div class="val_cont">
								<div class="val_value"><span id="im_credit"><?=formatNum($CREDIT)?></span> ₽</div>
							</div>
						</div>
						<div class="content_item">
							<div class="label">Ежемесячный платеж</div>
							<div class="val_cont">
								<div class="val_value"><span id="im_pay"><?=formatNum($PAY)?></span> ₽</div>
							</div>
						</div>
						<div class="content_item">
							<div class="content_descr">Обратите внимание на то, что <strong>приведенные расчеты носят предварительный характер</strong>. Окончательный расчет суммы кредита и ежемесячных платежей производятся банком после предоставления полного комплекта документов заемщиком.</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="buttons text-center"><a id="showbron1" class="button" onclick="show_zayavka('Заявка на консультацию по поводу кредита на сумму '+formatNum($('#m_credit').val())+' ₽. Срок (лет): '+$('#m_term').val()+'. Стоимость участка '+formatNum($('#m_price').val())+' ₽. Первоначальный взнос '+formatNum($('#m_contribution').val())+' ₽ ('+$('#m_percent').val()+' %)')">Оставить заявку</a></div>
				</div>
			</div>
		</form>


	</div>
	<div class="tab_item" data-tab="2" style="display: none;">


		<form id="f_installment">
			<input type="hidden" id="i_price" name="i_price" value="<?=$SUM?>">
			<input type="hidden" id="i_price_min" name="i_price_min" value="<?=$SUM_MIN?>">
			<input type="hidden" id="i_price_max" name="i_price_max" value="<?=$SUM_MAX?>">
			<input type="hidden" id="i_contribution" name="i_contribution" value="<?=$SUM0_I?>">
			<input type="hidden" id="i_percent" name="i_percent" value="<?=$PERCENT_I?>">
			<input type="hidden" id="i_percent_min" name="i_percent_min" value="<?=$PERCENT_MIN_I?>">
			<input type="hidden" id="i_percent_max" name="i_percent_max" value="<?=$PERCENT_MAX_I?>">
			<input type="hidden" id="i_credit" name="i_credit" value="<?=$CREDIT_I?>">
			<input type="hidden" id="i_pay" name="i_pay" value="<?=$PAY_I?>">
			<input type="hidden" id="i_term" name="i_term" value="<?=$TERM_I?>">
			<input type="hidden" id="i_term_min" name="i_term_min" value="<?=$TERM_MIN_I?>">
			<input type="hidden" id="i_term_max" name="i_term_max" value="<?=$TERM_MAX_I?>">
			<input type="hidden" id="i_step" name="i_step" value="<?=$STEP?>">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="content_item">
						<div class="label">Стоимость участка</div>
						<div class="val_cont">
							<div class="val_value"><span id="ii_price"><?=formatNum($SUM)?></span> ₽</div>
						</div>
						<div class="sldr" id="si_price"></div>
						<div class="caption d-flex justify-content-between">
							<div>от <?=$SUM_MIN/1000000?> млн ₽</div>
							<div>до <?=$SUM_MAX/1000000?> млн ₽</div>
						</div>
					</div>
					<div class="content_item">
						<div class="label">Первоначальный взнос</div>
						<div class="val_cont d-flex justify-content-between">
							<div class="val_value"><span id="ii_contribution"><?=formatNum($SUM0_I)?></span> ₽</div>
							<div class="val_value"><span id="ii_percent"><?=$PERCENT_I?></span> %</div>
						</div>
						<div class="sldr" id="si_percent"></div>
						<div class="caption d-flex justify-content-between">
							<div>от <?=$PERCENT_MIN_I?>%</div>
							<div>до <?=$PERCENT_MAX_I?>%</div>
						</div>
					</div>
					<div class="content_item">
						<div class="label">Срок рассрочки</div>
						<div class="val_cont">
							<div class="val_value" id="ii_term"><?=$TERM_I?></div>
						</div>
						<div class="sldr" id="si_term"></div>
						<div class="caption d-flex justify-content-between">
							<div>от <?=$TERM_MIN_I." ".(($TERM_MIN_I > 1)?"месяцев":"месяца")?></div>
							<div>до <?=$TERM_MAX_I?> месяцев</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-5 offset-md-1">
					<div class="grey_box">
						<div class="content_item">
							<div class="label">Сумма рассрочки</div>
							<div class="val_cont">
								<div class="val_value"><span id="ii_credit"><?=formatNum($CREDIT_I)?></span> ₽</div>
							</div>
						</div>
						<div class="content_item">
							<div class="label">Ежемесячный платеж</div>
							<div class="val_cont">
								<div class="val_value"><span id="ii_pay"><?=formatNum($PAY_I)?></span> ₽</div>
							</div>
						</div>
						<div class="content_item">
							<div class="content_descr">Обратите внимание на то, что <strong>приведенные расчеты носят предварительный характер</strong>. Окончательный расчет суммы рассрочки и ежемесячных платежей производятся после предоставления полного комплекта документов заемщиком.</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="buttons text-center"><a id="showbron1" class="button" onclick="show_zayavka('Заявка на консультацию по поводу рассрочки на сумму '+formatNum($('#i_credit').val())+' ₽. Срок (месяцев): '+$('#i_term').val()+'. Стоимость участка '+formatNum($('#i_price').val())+' ₽. Первоначальный взнос '+formatNum($('#i_contribution').val())+' ₽ ('+$('#i_percent').val()+' %)')">Оставить заявку</a></div>
				</div>
			</div>
		</form>


	</div>
</div>
<div class="hidden_block" id="zayavkadiv">
<script data-b24-form="click/22/ah80xz" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://cdn-ru.bitrix24.ru/b29466034/crm/form/loader_22.js');</script>
<button></button>
</div>