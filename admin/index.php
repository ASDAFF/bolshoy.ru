<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use Bitrix\Main\Application;
use \Site\Main\Grid;
use Site\Main\Hlblock\Packets;

$arUserGroups = $USER->GetUserGroup($USER->GetID());
$bUserAdmin = in_array(\Site\Main\GROUP_ID_PORTAL_ADMIN, $arUserGroups);
if( !$bUserAdmin ){
	LocalRedirect('/');
}

$arRequest = Application::getInstance()->getContext()->getRequest()->toArray();
$arAllPacketsInfo = Packets::getInstance()->getPacketsStatuses();
$arStatuses = Packets::getPStatusesValId();
$APPLICATION->SetPageProperty('bodyClass', 'big-resolution');

foreach($arAllPacketsInfo['STATUSES'] as $statusId => $packetsCnt){
	$statusText = array_search($statusId, $arStatuses);
	if( !empty($statusText) ){
		?><p class="packets-info"><b><?=$statusText?></b> - <?=$packetsCnt?></p><?
	}
}

?>
	<div class="tabo">
		<div class="tabs-wrap">
			<!-- active tab on page load gets checked attribute--><?
			$bCheckedPacks = !empty($arRequest['PAGEN_1']) || $arRequest['TAB'] == 'grid_packets';
			$bCheckedUsers = !empty($arRequest['PAGEN_2']) ||  $arRequest['TAB'] == 'grid_user';
			?>
			<input id="tab1" type="radio" name="tabGroup1" checked="<?=( $bCheckedPacks && !$bCheckedUsers ) ? 'checked' : 'false'?>" class="tabs">
			<label for="tab1">Пакеты</label>
			<input id="tab2" type="radio" name="tabGroup1" <?=( !$bCheckedPacks && $bCheckedUsers ) ? 'checked' : ''?> class="tabs">
			<label for="tab2">Участники</label>
			<div class="tabs__content">
				<section class="raiting raiting_full-width">
					<div class="container container_raiting">
						<div class="raiting__wrap raiting__wrap_full-w"><?
							$arResult = Grid::getPacketGridInfo();

							$APPLICATION->IncludeComponent(
								"bitrix:main.interface.grid",
								"",
								array(
									//уникальный идентификатор грида
									"GRID_ID" => $arResult["GRID_ID"],
									//описание колонок грида, поля типизированы
									"HEADERS" => array(
										array("id" => "UF_NAME", "name" => "ID пакета", "default" => true, 'class' => 'grid__packet-name', "sort" => "UF_NAME" ),
										array("id" => "UF_DATE_CHANGE", "name" => "Дата", "default" => true, "sort" => "UF_DATE_CHANGE"),
										array("id" => "USER_EMAIL", "name" => "Email", "default" => true, "sort" => "USER_EMAIL"),
										array("id" => "USER_NAME", "name" => "Пользователь", "default" => true,  'class' => 'grid__user-name', "sort" => "USER_NAME"),
										array("id" => "USER_RATING", "name" => "Рейтинг", "default" => true, 'class' => 'js-packet-rating'),
										array("id" => "ACTIONS", "name" => "", "sort" => "name", "default" => true),
									),

									//сортировка
									"SORT" => $arResult["SORT"],

									//данные
									"ROWS" => $arResult["ROWS"],
									
									"ROWS_COUNT" => $arResult['PACKETS_COUNT'],

									//футер списка, можно задать несколько секций
									"FOOTER" => array(array("title" => "Всего", "value" => $arResult['PACKETS_COUNT'])),

									//групповые действия
									"ACTIONS" => array(
										//можно удалять
										"delete" => true,
										//выпадающий список действий
										"list" => array("activate" => "Активировать", "deactivate" => "Деактивировать"),
									),
									//разрешить действия над всеми элементами
									"ACTION_ALL_ROWS" => true,
									//разрешено редактирование в списке
									"EDITABLE" => true,
									//объект постранички
									"NAV_OBJECT" => $arResult["NAV_OBJECT"],
									//можно использовать в режиме ajax
									"AJAX_MODE" => "N",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "N",
									//фильтр
									"FILTER" => $arResult["FILTER"],
								),
								$component
							);
						?></div>
					</div>
				</section>
			</div>
			<div class="tabs__content">
				<section class="raiting_full-width">
					<div class="container container_raiting">
						<div class="raiting__wrap raiting__wrap_full-w raiting__wrap_two-col-center"><?
							$arResult = Grid::getUserGridInfo();
							$APPLICATION->IncludeComponent(
								"bitrix:main.interface.grid",
								"",
								array(
									//уникальный идентификатор грида
									"GRID_ID" => $arResult["GRID_ID"],
									//описание колонок грида, поля типизированы
									"HEADERS" => array(
										array("id" => "NAME", "name" => "ФИО", "sort" => "name", "default" => true, 'class' => 'js-editable'),
										array("id" => "EMAIL", "name" => "Электронная почта",  "sort" => "email", "default" => true, 'class' => 'js-editable'),
										array("id" => "PERSONAL_PHONE", "name" => "Телефон", "sort" => "personal_phone", "default" => true, 'class' => 'js-editable'),
										array("id" => "PERSONAL_CITY", "name" => "Город", "sort" => "personal_city", "default" => true, 'class' => 'js-editable'),
										array("id" => "UF_RATING", "name" => "Рейтинг", "sort" => "uf_rating", "default" => true, 'class' => 'js-editable'),
										array("id" => "UF_USER_TYPE", "name" => "Статус", "default" => true, 'class' => 'js-editable'),
										array("id" => "NEW_PASSWORD", "name" => "Новый пароль", "default" => true, "editable" => true, 'class' => 'js-editable'),
										array("id" => "ACTIONS", "name" => "", "default" => true),
									),

									//сортировка
									"SORT" => $arResult["SORT"],

									//данные
									"ROWS" => $arResult["ROWS"],

									// кол-во записей
									"ROWS_COUNT" => count($arResult["ITEMS"]),

									//футер списка, можно задать несколько секций
									"FOOTER" => array(array("title" => "Всего", "value" => $arResult["ROWS_COUNT"])),

									//групповые действия
									"ACTIONS" => array(
										//можно удалять
										"delete" => true,
										//выпадающий список действий
										"list" => array("activate" => "Активировать", "deactivate" => "Деактивировать"),
									),
									//разрешить действия над всеми элементами
									"ACTION_ALL_ROWS" => true,
									//разрешено редактирование в списке
									"EDITABLE" => true,
									//объект постранички
									"NAV_OBJECT" => $arResult["NAV_OBJECT"],
									//можно использовать в режиме ajax
									"AJAX_MODE" => "N",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "N",
									//фильтр
									"FILTER" => $arResult["FILTER"],
								),
								$component
							);
						?></div>
					</div>
				</section>
			</div>
		</div>
	</div><?
//}
?>

<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>