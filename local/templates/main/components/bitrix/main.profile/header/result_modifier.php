<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Entity;
use Bitrix\Main\UserTable;
use Site\Main\Hlblock\Packets;
use Site\Main\Hlblock\History;
use Site\Main\Util;

$arUser = &$arResult['arUser'];
$userId = $USER->GetID();

// Получаем список стран
$arCountries = \GetCountryArray();
// Пописываем пользователю страну
if (intval($arUser['PERSONAL_COUNTRY'])) {
    $countryRefId = array_search($arUser['PERSONAL_COUNTRY'], $arCountries['reference_id']);
    $arUser['PERSONAL_COUNTRY_INDEX'] = $arUser['PERSONAL_COUNTRY'];
    $arUser['PERSONAL_COUNTRY'] = $arCountries['reference'][$countryRefId];
}
else {
    $arUser['PERSONAL_COUNTRY'] = "";
}

// Формируем список стран для вывода
$arResult['COUNTRIES'] = Util::getCountriesArray();

// Тип пользователя
$rsUserType = \CUserFieldEnum::GetList(array(), array(
    "ID" => $arUser["UF_USER_TYPE"],
));
if($arUserType = $rsUserType->GetNext()) {
    $arResult['USER_TYPE'] = $arUserType['VALUE'];
}

// Аватар

$arUser['PERSONAL_PHOTO'] = \CFile::ResizeImageGet($arUser['PERSONAL_PHOTO'], array('width' => 100, 'height' => 100));

// Место в рейтинге
$rUserTable = UserTable::getList(Array(
    "select" => array('ID'),
    "filter" => array(
        'ACTIVE' => 'Y',
        array(
            "LOGIC" => "OR",
            array('>UF_PROGRAM' => $arUser['UF_PROGRAM']),
            array('UF_PROGRAM' => $arUser['UF_PROGRAM'], '>UF_RATING' => $arUser['UF_RATING']),
            array('UF_PROGRAM' => $arUser['UF_PROGRAM'], 'UF_RATING' => $arUser['UF_RATING'], "<ID" => $userId),
        )
    ),
    "data_doubling" => false,
));
$pos = 1;
while($arUserItem = $rUserTable->fetch()) {
    $pos++;
}
$arUser['POSITION'] = $pos;


// Получаем данные для вывода истории пакетов
$arHistory = History::getInstance()->getData(array('UF_USER' => $userId), array('*'), array('ID' => 'DESC'));
$arHistoryStatuses = History::getPHStatusesValId();
$arPacketsIds = array();

foreach($arHistory['ITEMS'] as &$arHistEl){
    $arHistEl['UF_STATUS'] = array_search($arHistEl['UF_STATUS'], $arHistoryStatuses);
    $arPacketsIds[$arHistEl['UF_PACKET']] = array();
}
unset($arHistEl);

if( !empty($arPacketsIds) ){
    $arPackets = Packets::getInstance()->getData(array('ID' => array_keys($arPacketsIds)), array('ID', 'UF_NAME', 'UF_PACKET_FILE'));
}
foreach($arHistory['ITEMS'] as &$arHistEl){
    $arHistEl['NAME'] = $arPackets['ITEMS'][$arHistEl['UF_PACKET']]['UF_NAME'];
    $arHistEl['PACKET_FILE'] = $arPackets['ITEMS'][$arHistEl['UF_PACKET']]['UF_PACKET_FILE'];
    if( empty($arUser['PACKET_IN_WORK']) && $arHistEl['UF_STATUS'] == 'В работе' ){
        $arUser['PACKET_IN_WORK'] = $arHistEl['UF_PACKET'];
    }
}
$arUser['HISTORY'] = $arHistory['ITEMS'];
// Ссылка на скачивание пакета
if(empty($arUser['PACKET_IN_WORK'])) {
    $arFreePacket = Packets::getInstance()->getFreePacket();
    $arUser['FREE_PACKET'] = Packets::getInstance()->getFreePacket();
}

unset($arUser, $arHistEl);


if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER']))
{
    $cp =& $this->__component;
    if (strlen($cp->getCachePath()))
    {
        $GLOBALS['CACHE_MANAGER']->RegisterTag('users_list');
    }
}