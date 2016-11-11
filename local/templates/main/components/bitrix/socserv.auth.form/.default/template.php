<?
use Bitrix\Main\Localization\Loc;

if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true ) {
	die();
}
return;

?>
	<script src="/bitrix/js/socialservices/ss.js"></script><?
$arAuthServices = $arPost = array();
if( is_array($arParams["~AUTH_SERVICES"]) ) {
	$arAuthServices = $arParams["~AUTH_SERVICES"];
}
if( is_array($arParams["~POST"]) ) {
	$arPost = $arParams["~POST"];
}

?><div class="bx-auth soc-wide-login">
	<p class="soc-wide-login__text"><?=Loc::getMessage($arParams['HEADER'])?></p>
	<form method="post" name="bx_auth_services<?=$arParams["SUFFIX"]?>" target="_top"
		  action="/"><?
		if( $arParams["~FOR_SPLIT"] != 'Y' ){
			?><div class="bx-auth-services soc-wide-login__wrap"><?
				foreach($arAuthServices as $service){
					$service['ONCLICK'] = preg_replace('/\/ajax.*index.php/', '/', urldecode(urldecode($service['ONCLICK'])));
					?><a href="javascript:void(0)" class="soc-wide-login__item <?=( empty($service['ONCLICK']) ) ? 'js-social-form' : ''?>" data-form='bx_auth_serv_form<?=$service['ID']?>' <?=( !empty($service['ONCLICK']) ) ? 'onclick="' . $service['ONCLICK'] . '"' : ''?>
					   id="bx_auth_href_<?=$arParams["SUFFIX"]?><?=$service["ID"]?>">
						<svg class="soc-wide-login__<?=$service['ICON']?>">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
								 xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbols55o1e8z1tt9.svg#<?=$service['ICON']?>"></use>
						</svg>
					</a>
					<div id="bx_auth_serv_form<?=$service['ID']?>" class="none">
						<?=$service['FORM_HTML']?>
					</div>
					<?
				}
			?></div><?
		 }

		?><input type="hidden" name="auth_service_id" value=""/>
	</form>
</div>