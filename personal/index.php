<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $USER;
if(!$USER->IsAuthorized()) {
    LocalRedirect('/');
}
$APPLICATION->SetTitle("Как начать работу");
$APPLICATION->SetPageProperty('bodyClass', 'body_fix-width960 js-personal-page');
$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"header", 
	array(
		"SET_TITLE" => "Y",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"USER_PROPERTY" => array(
		),
		"SEND_INFO" => "N",
		"CHECK_RIGHTS" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "header",
		"MANUAL_LINK" => "/includes/manual.pdf",
		"FR_LINK" => "//fr7.abbyy.com/fr12/ABBYY_FineReader_12_Professional_Bolshoi.exe"
	),
	false
); ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>