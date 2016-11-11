<?
use Bitrix\Main\Application;
use Bitrix\Main\UserTable;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$arDocRoot = Application::getInstance()->getContext()->getServer()->getDocumentRoot();
$arUsers = UserTable::getList(
	array(
		'filter' => array(
			'ACTIVE' => 'N'
		),
		'select' => array(
			'ID',
			'UF_TRIAL'
		)
	)
)->fetchAll();

$trials = "";
foreach($arUsers as $arUser){
	if( !empty($arUser['UF_TRIAL']) ){
		$trials .= $arUser['UF_TRIAL'] . "\n";
	}
}

file_put_contents($arDocRoot . '/trials_unactive.csv', $trials);