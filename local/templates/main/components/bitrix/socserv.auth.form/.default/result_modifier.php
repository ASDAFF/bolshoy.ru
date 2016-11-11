<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

/*Меняем backurl*/
foreach($arParams['AUTH_SERVICES'] as &$arService){
	$arService['ONCLICK'] = preg_replace('/\/ajax.*index.php/', '/', urldecode(urldecode($arService['ONCLICK'])));
}

unset($arService);