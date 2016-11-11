<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
	die();
}
$arMsg = explode('|', $arParams['MESSAGE']);
?><div id="thanks" class="window-wrap window-wrap__center js-notification none">
	<h3 class="window-wrap__title"><?=$arMsg[0]?></h3>
	<p><?=$arMsg[1]?></p>
</div>