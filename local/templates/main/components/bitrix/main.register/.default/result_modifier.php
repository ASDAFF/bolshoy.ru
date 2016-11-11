<?
use Bitrix\Main\Application;
use Site\Main\Util;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

$arResult['ALLOW_SOCSERV_AUTHORIZATION'] = (COption::GetOptionString('main', 'allow_socserv_authorization', 'Y') != 'N' ? 'Y' : 'N');
if (CModule::IncludeModule('socialservices') && $arResult['ALLOW_SOCSERV_AUTHORIZATION'] == 'Y') {
	$oAuthManager = new CSocServAuthManager();
	$arResult['AUTH_SERVICES'] = $oAuthManager->GetActiveAuthServices(array(
		'BACKURL'      => SITE_DIR,
		'FOR_INTRANET' => $arResult['FOR_INTRANET'],
	));
}

usort($arResult['SHOW_FIELDS'], function($a, $b) use($arParams){
	$compA = array_search($a, $arParams['SHOW_FIELDS']);
	$compB = array_search($b, $arParams['SHOW_FIELDS']);

	if( $compA === false ){
		$compA = 999;
	}
	if( $compB === false ){
		$compB = 999;
	}

	return $compA <= $compB ? -1 : 1;
});

/*Не показываем сообщение об ошибке логина*/
if( !empty($arResult['ERRORS']) ){

	foreach($arResult['ERRORS'] as &$error){
		$error = preg_replace(
			array(
				'/Логин [А-Я0-9\s\.]*<br( \/)?>/ui',
				'/Пользователь с логином (.)*<br( \/)?>/ui'
			),
			array(
				'',
				"Указанный e-mail уже зарегистрирован. <a class='js-fansibox' href='/ajax/form/getForgotForm/'>Забыли пароль?</a>"
			),
			$error
		);
	}

	unset($error);
}

$arResult['COUNTRIES'] = Util::getCountriesArray();

/*Не даем подменить значение поля Страна на id страны*/
$arReq = Application::getInstance()->getContext()->getRequest()->toArray();
if( !empty($arReq['REGISTER']['PERSONAL_COUNTRY']) ){
    $arResult['VALUES']['PERSONAL_COUNTRY'] = $arResult['COUNTRIES'][$arReq['REGISTER']['PERSONAL_COUNTRY']];
}

