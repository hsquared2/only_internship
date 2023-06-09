<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Связаться");
$APPLICATION->SetPageProperty("description", "Связаться");
$APPLICATION->SetTitle("Связаться");?>
<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "request_form", array(
	"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array(
			"RESULT_ID" => "RESULT_ID",
			"WEB_FORM_ID" => "3",
		),
		"WEB_FORM_ID" => "3"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>