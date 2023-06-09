<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>		
<!DOCTYPE html>
<html lang="ru">
	<head>
		<?$APPLICATION->ShowHead();?>
		<title><?$APPLICATION->ShowTitle();?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
		<link href="<?=SITE_TEMPLATE_PATH?>/assets/css/services/style.css" rel="stylesheet">
		<link href="<?=SITE_TEMPLATE_PATH?>/assets/css/contact-us/style.css" rel="stylesheet">
	</head>
<body>
	<div id="panel">
		<?$APPLICATION->ShowPanel();?>
	</div>
	<?$APPLICATION->IncludeComponent(
		"bitrix:menu",
		"top_menu",
		Array(
			"ALLOW_MULTI_SELECT" => "N",
			"DELAY" => "N",
			"MAX_LEVEL" => "1",
			"MENU_CACHE_GET_VARS" => array(""),
			"MENU_CACHE_TIME" => "3600",
			"MENU_CACHE_TYPE" => "N",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_THEME" => "site",
			"ROOT_MENU_TYPE" => "top",
			"USE_EXT" => "N"
		)
	);
	?>
