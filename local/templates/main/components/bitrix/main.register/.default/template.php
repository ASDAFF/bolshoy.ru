<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */
use \Bitrix\Main\Application;

$arServer = Application::getInstance()->getContext()->getServer();
require_once($arServer['DOCUMENT_ROOT'] . '/local/modules/site.main/lib/recaptchalib.php');

/**
 * Bitrix vars
 * @global CMain                   $APPLICATION
 * @global CUser                   $USER
 *
 * @param array                    $arParams
 * @param array                    $arResult
 * @param CBitrixComponentTemplate $this
 */

if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true ) {
	die();
}

$arRequest = Application::getInstance()->getContext()->getRequest()->toArray();
?><div class="bx-auth-reg js-reg-form window-wrap js-replacement" id="join"><?

	if( count($arResult["ERRORS"]) == 0 && !empty($arResult['VALUES']) ) {
		?><div class="js-success js-success_reg">
			<div class="window-wrap already-registered"><?
				if( $arParams['MOBILE'] ){
					ShowMessage(Array("TYPE"=>"OK", "MESSAGE" => "Спасибо за регистрацию! | " . GetMessage('MAIN_REGISTER_MOBILE')));
				}
				else{
					ShowMessage(Array("TYPE"=>"OK", "MESSAGE" => "Спасибо за регистрацию! | " . GetMessage('MAIN_REGISTER_AUTH')));
				}
			?></div>
		</div><?
	}
	else {
		if( count($arResult["ERRORS"]) > 0 ) {
			?><div class="js-errors forma__errors"><?
			foreach($arResult["ERRORS"] as $key => $error) {
				echo $error . '<br>';
			}
			?></div><?
		}
		elseif( $arResult["USE_EMAIL_CONFIRMATION"] === "Y" ){
			?><div class="js-success">
				<p><? echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT") ?></p>
			</div><?
		}

		?><form method="post" action="<?=POST_FORM_ACTION_URI?>" data-type="HTML" data-show-note="true" data-redirect-url="/personal/" name="regform" enctype="multipart/form-data">
		<input type="hidden" name="register_submit_button" value="Y">
		<input type="hidden" name="UF_USER_TYPE" value="2"><?

		if( $arResult["BACKURL"] <> '' ) {
			?><input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>"/><?
		}

		?><p class="forma__notif">Заполняя эту форму, вы соглашаетесь c <a href="/includes/agree.php" class="js-fansibox forma__agree">условиями</a>
			обработки персональных данных</p><?

		foreach($arResult["SHOW_FIELDS"] as $FIELD) {
			$bIsRequired = in_array($FIELD, $arParams['REQUIRED_FIELDS']);
			switch($FIELD) {
				case "PASSWORD":
					?><input type="hidden" name="REGISTER[<?=$FIELD?>]" value="123456"/><?
					break;

				case "CONFIRM_PASSWORD":
					?><input type="hidden" name="REGISTER[CONFIRM_PASSWORD]" value="123456"/><?
					break;


					case "PERSONAL_COUNTRY":
					case "WORK_COUNTRY":
						?><select <?=$bIsRequired ? ' required' : ''?> class="forma__inpt widget selectize" name="REGISTER[<?=$FIELD?>]"><?
							foreach($arResult["COUNTRIES"] as $key => $value) {
								?><option value="<?=$key?>"
								<? if( $value == $arResult["VALUES"][$FIELD] ){
									?>selected="selected"<?}?>>
									<?=$value?>
								</option><?
							}
						?></select><?
						break;

				default:
					if( $FIELD == 'LOGIN' ) {
						?><input type="hidden" name="REGISTER[LOGIN]" value="123"/><?
					}
					else {
						if( $FIELD == 'PERSONAL_CITY' ) {
							$fieldClass = 'js-city-selector';
						}
						else {
							$fieldClass = '';
						}
						?><input class="forma__inpt <?=$fieldClass?>"
							 placeholder="<?=GetMessage('REGISTER_FIELD_' . $FIELD)?><?=$bIsRequired ? ' *' : ''?>"
							 size="30"
							 type="text" name="REGISTER[<?=$FIELD?>]"
							 value="<?=$arResult["VALUES"][$FIELD]?>" <?=$bIsRequired ? 'required' : ''?>
						/><?
					}

					break;
			}
		}

		?><div class="filter__checkbox js-filter__checkbox">
			<input name="REGISTER[SUBSCRIBE]" id="sub" class="filter__chboxhide" type="checkbox">
			<label id="igra2" for="sub" class="filter__labl"></label><span id="ch1" class="filter__textchbox">Подписка на новости</span>
		</div>
		<div class="filter__checkbox js-filter__checkbox js-agree">
			<input id="participation" name="REGISTER[AGREE]" class="filter__chboxhide" type="checkbox" <?=( !empty($arRequest['REGISTER']['AGREE']) ) ? 'checked' : ''?>>
			<label id="parti_label" for="participation" class="filter__labl"></label>
			<span id="ch2" class="filter__textchbox">Согласен с <a href="/terms/" target="_blank">Условиями участия</a>*  </span>
		</div>
		<div class="g-recaptcha" id="captcha" data-sitekey="<?=\COption::GetOptionString('site.main', 'recaptcha_public_key')?>"></div>

		<input type="submit" <?=( empty($arRequest['REGISTER']['AGREE']) ) ? 'disabled' : ''?> name="register_submit_button" class="forma__send js-forma__send btn"
			   value="<?=GetMessage("AUTH_REGISTER")?>"/>
		</form>
		<script src="https://www.google.com/recaptcha/api.js"></script><?

		if( $arResult['AUTH_SERVICES'] ) {
			$APPLICATION->IncludeComponent('bitrix:socserv.auth.form', '', array(
				'AUTH_SERVICES' => $arResult['AUTH_SERVICES'],
				'POPUP'         => 'N',
				'SUFFIX'        => 'form',
				'HEADER'        => 'REGISTRATION_HEADER',
			), $component, array(
				'HIDE_ICONS' => 'N'
			));
		}
	}
?></div><?