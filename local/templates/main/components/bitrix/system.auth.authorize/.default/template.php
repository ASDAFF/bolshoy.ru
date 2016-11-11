<?
use \Bitrix\Main\Application;

if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true ) {
	die();
}
$arRequest = Application::getInstance()->getContext()->getRequest()->toArray();
?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>

<div class="bx-auth window-wrap js-replacement" id="login"><?
	if( $USER->IsAuthorized() ){
		?><p class="js-success"></p><?
	}
	elseif( !empty($arRequest['login']) ){
		?><div class="js-errors">
			<p>Проверьте правильность введенных данных</p>
		</div><?
	}
	?><form name="form_auth" class="forma" method="post" data-type="HTML" data-redirect-url="/personal/" target="_top" action="<?=$arResult["AUTH_URL"]?>">

		<input type="hidden" name="AUTH_FORM" value="Y"/>
		<input type="hidden" name="TYPE" value="AUTH"/>
		<? if( strlen($arResult["BACKURL"]) > 0 ): ?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>"/>
		<? endif ?>
		<? foreach($arResult["POST"] as $key => $value): ?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>"/>
		<? endforeach ?>

		<input placeholder="<?=GetMessage("AUTH_LOGIN")?>" class="bx-auth-input forma__inpt" type="text"
			   name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>"/>
		<input placeholder="<?=GetMessage("AUTH_PASSWORD")?>" class="bx-auth-input forma__inpt" type="password"
			   name="USER_PASSWORD" maxlength="255" autocomplete="off"/>
		<div class="soc-wide-login nopad">
			<? if( $arParams["NOT_SHOW_LINKS"] != "Y" ): ?>
				<noindex>
					<p>
						<a href="/ajax/form/getForgotForm/" class="js-fansibox"
						   rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
					</p>
				</noindex>
			<? endif ?>

			<input type="submit" class="forma__send js-forma__send" name="Login"
				   value="<?=GetMessage("AUTH_AUTHORIZE")?>"/>
		</div>

	</form>

	<div class="soc-wide-login nopad">
		<? if( $arResult["AUTH_SERVICES"] ): ?>
		<?
		$APPLICATION->IncludeComponent('bitrix:socserv.auth.form', '', array(
			'AUTH_SERVICES' => $arResult['AUTH_SERVICES'],
			'POPUP'         => 'N',
			'SUFFIX'        => 'form',
			'HEADER'        => 'AUTH_HEADER',
		), $component, array(
			'HIDE_ICONS' => 'N'
		));
		?>
		<? if( $arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y" ): ?>
			<noindex>
				<p></p>
				<p>
					<a href="/ajax/form/getRegForm/" class="js-fansibox"
					   rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a><br/>
				</p>
			</noindex>
		<? endif ?>
	</div>
</div>

<script type="text/javascript">
	<?if (strlen($arResult["LAST_LOGIN"]) > 0):?>
	try {
		document.form_auth.USER_PASSWORD.focus();
	} catch (e) {
	}
	<?else:?>
	try {
		document.form_auth.USER_LOGIN.focus();
	} catch (e) {
	}
	<?endif?>
</script>

<? endif ?>
