<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$docRoot = \Bitrix\Main\Application::getInstance()->getDocumentRoot();


$trials = file_get_contents($docRoot . "/serials4999.csv");
if ( !empty($trials) ) {
	$arTrials = preg_split('/[(\r)?\n]/mi', $trials);
	$currentTrial = reset($arTrials);
	$arNewTrials = array();

	/*Присваиваем информацию по триалке пользователю и обновляем файл*/
	if( !empty($currentTrial) ){
		unset($arTrials[0]);

		foreach($arTrials as $key){
			$arNewTrials[] = $key;
		}
		file_put_contents($docRoot . "/serials4999.csv", implode("\n", $arNewTrials));

		$obUser = new \CUser();
		$bUpdated = $obUser->update($GLOBALS['USER']->GetId(), array(
			'UF_TRIAL' => $currentTrial
		));

		if( $bUpdated ){
			$arResult = array('SUCCESS' => true, 'TRIAL_KEY' => $currentTrial);
		}
	}
	else{
		$arResult['ERROR'] = true;
	}
}