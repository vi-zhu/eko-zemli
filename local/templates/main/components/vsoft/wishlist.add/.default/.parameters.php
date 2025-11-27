<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	$arTemplateParameters = array(
		"DELAYED" => array(
			"PARENT" => "DATA_SOURSE",
			"NAME" => GetMessage('VSOFT_PARAM_DELAYED'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N"
		),
		"USE_BATCH" => array(
			"PARENT" => "DATA_SOURSE",
			"NAME" => GetMessage('VSOFT_PARAM_USE_BATCH'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N"
		)
	);
?>