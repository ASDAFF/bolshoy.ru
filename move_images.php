<?
/**
 * Обновление картинок пользователей (Перенос из амазона на хостинг).
 */

require $_SERVER['DOCUMENT_ROOT'] . '/local/modules/site.main/lib/aws/aws-autoloader.php';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Application;
use \Site\Main\Amazon;
?>

<?
$arUsers = \Bitrix\Main\UserTable::getList(
	array(
		'filter' => array('!PERSONAL_PHOTO' => false),
		'select' => array('ID', 'PERSONAL_PHOTO')
	)
)->fetchAll();

/*Конфиг подключения к амазону*/
$arConfig = Amazon::getConfig();
/*Создаем объект SDK класса*/
$obSdk = new \Aws\Sdk($arConfig);
/*Создаем объект S3 класса*/
$obS3 = $obSdk->createS3();
$amazonDirectory = \COption::getOptionString('site.main', 'amazon_directory');

$docRoot = Application::getInstance()->getDocumentRoot();
$obUser = new \CUser();

/*
 * Бежим по пользователям и меняем картинки тем, у кого они в амазоне
 * */
foreach($arUsers as $arUser){
	$arImg = \CFile::GetFileArray($arUser['PERSONAL_PHOTO']);
	$file = fopen($arImg['SRC'], 'r');
	if( $file && strpos($arImg['SRC'], 'amazon') !== false ){
		$newSrc =  $docRoot . '/upload/' . $arImg['ORIGINAL_NAME'];
		$result = $obS3->getObject(array(
			'Bucket' => $amazonDirectory,
			'Key'    => $arImg['SUBDIR'] . '/' . $arImg['FILE_NAME'],
			'SaveAs' => $newSrc
		));
		$arNewFile = \CFile::MakeFileArray($newSrc);
		$arNewFile['del'] = "Y";
		$arNewFile['old_file'] = $arUser['PERSONAL_PHOTO'];
		$arNewFile['MODULE_ID'] = 'main';

		$bUpdated = $obUser->Update($arUser['ID'], array('PERSONAL_PHOTO' => $arNewFile));
		fclose($file);
	}
}
?>

<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>
