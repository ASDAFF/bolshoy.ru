<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);

?>
<div class="window-wrap js-replacement">
	<form name="bform" method="post" data-type="JSON" data-show-note="true" data-refirect-url="/" target="_top" action="/ajax/user/changePassword/"><?

		if( strlen($arResult["BACKURL"]) > 0 ) {
			?><input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" /><?
		}

		?><input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">
		<p>
			<?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
		</p>

		<input type="text" class="forma__inpt" placeholder="<?=GetMessage("AUTH_EMAIL")?>" value="<?=$arResult["LAST_LOGIN"]?>" name="USER_EMAIL" maxlength="255"/>
		<input type="submit" class="forma__send js-forma__send" name="send_account_info"
			   value="<?=GetMessage("AUTH_SEND")?>"/>
		<button class="forma__send js-fansibox" href="/ajax/form/getAuthForm/"><?=GetMessage("AUTH_AUTH")?></button>
	</form><?


	if( empty($arResult['ERRORS']) ){
		?><div class="js-success"><?
			ShowMessage(Array("TYPE"=>"OK", "MESSAGE" => "Запрос на смену пароля принят! | Мы отправили инструкцию по смене пароля на ваш e-mail."));
		?></div><?
	}
?></div>
<script type="text/javascript">
//document.bform.USER_EMAIL.focus();
</script>
