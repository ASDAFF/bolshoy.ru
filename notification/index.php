<?
use Site\Main\Hlblock\Packets;
use Site\Main\Hlblock\History;
use Site\Main\User;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$obPackets = Packets::getInstance();
/*Получаем статусы по всем пакетам*/
$arPackets = $obPackets->getPacketsStatuses();
/*Получаем информацию по возможным статусам пакетов*/
$arStatusesInfo = $obPackets->getPStatusesValId();

/*Кол-во доступных пакетов*/
$activePacketsCnt = $arPackets['STATUSES'][$arStatusesInfo['Активный']];

/*Вычисляем процент заблокированных пакетов*/
$percents = 0;
switch($activePacketsCnt){
	case ($activePacketsCnt < ($arPackets['PACKETS_COUNT'] * 0.05)):
		$percents = 95;
		break;
	case($activePacketsCnt < ($arPackets['PACKETS_COUNT'] * 0.2)):
		$percents = 80;
		break;
	case($activePacketsCnt < ($arPackets['PACKETS_COUNT'] * 0.4)):
		$percents = 60;
		break;
	default:
		$percents = 100;
		break;
}

if( $percents >= 60 ){
	\CEvent::SendImmediate('AVAILABLE_PACKETS_REPORT', 's1', array('PERCENTS' => $percents));
}


/*Отправляем информацию о кол-ве пакетов, находящихся на проверке*/
$checkPacketsCnt = $arPackets['STATUSES'][$arStatusesInfo['На проверке']];
if( $checkPacketsCnt >= 1000 ){
//	$event = \CEvent::SendImmediate('CHECK_PACKETS_REPORT', 's1', array());
}


// Отправляем пользователям нотификацию о том, что до конца верификации осталось менее 2 часов
$arStatusesInfo = History::getPHStatusesValId();
$arPacketsHistory = History::getInstance()->getData(
	array(
		'UF_STATUS' => $arStatusesInfo['Работа'],
		'<=UF_DATE_START' => ConvertTimeStamp(time() - (2 * 86400) + (2 * 3600), 'FULL')
	)
);
$arUsersId = array();
foreach($arPacketsHistory as $arHist){
	$arUsersId[$arHist['UF_USER']] = array();
}
if( !empty($arUsersId) ){
	$arUsersId = implode('|', array_keys($arUsersId));
	$arUsers = User::getList(
		array('ID' => $arUsersId),
		array(
			'FIELDS' => array(
				'ID',
				'EMAIL'
			)
		)
	);
	if( !empty($arUsers['ITEMS']) ){
	    foreach($arUsers['ITEMS'] as $arUser){
			\CEvent::SendImmediate('VERIFICATION_TIME_OUT', 's1', array('EMAIL' => $arUser['EMAIL']));
		}
	}
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");