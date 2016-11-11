<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require $_SERVER['DOCUMENT_ROOT'] . '/local/modules/site.main/lib/aws/aws-autoloader.php';

use \Site\Main\Hlblock\Packets;
use \Site\Main\Amazon;

$arResult = array();

/*Получаем пакеты, которые уже есть в БД*/
$arPackets = Packets::getInstance()->getElements();
$arPackets = $arPackets['ITEMS'];
$arExFiles = array();
foreach($arPackets as $arPacket){
	$arExFiles[$arPacket['UF_PACKET_FILE']] = array();
}

$arConfig = Amazon::getConfig();
$amazonDirectory = \COption::GetOptionString('site.main', 'amazon_directory');

/*Создаем объект SDK класса*/
$obSdk = new Aws\Sdk($arConfig);

/*Создаем объект S3 класса*/
$obS3 = $obSdk->createS3();

/*Получаем доступные файлы*/
$arAvStatus = \CUserFieldEnum::GetList(array(), array('VALUE' => 'Активный'))->fetch();

$arIterator = $obS3->getIterator('ListObjects', array(
	'Bucket' => \COption::GetOptionString('site.main', 'amazon_directory'),
	'Prefix' => 'available/'
));

$i = 0;
/*Добавляем новые записи в HLoad*/
foreach($arIterator as $arFile){
	if( $i == 0 ){
		$i++;
		continue;
	}

	$fileSrc = '//' . $amazonDirectory . '.s3.amazonaws.com/' . $arFile['Key'];
	if( !array_key_exists($fileSrc, $arExFiles) ) {
		$arName = explode('/', $arFile['Key']);
		$arDate = (array)$arFile['LastModified'];

		$el = Packets::getInstance()->addData(array(
				'UF_PACKET_FILE' => $fileSrc,
				'UF_NAME' => end($arName),
				'UF_STATUS' => $arAvStatus['ID'],
				'UF_DATE_CHANGE' => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($arDate['date']))
			)
		);

		$arResult[$arFile['Key']] = array();
	}
}

echo 'Обработано пакетов:' . count($arResult);