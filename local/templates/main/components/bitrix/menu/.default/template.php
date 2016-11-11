<?
use Site\Main\Util;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

if (empty($arResult)) {
	return;
}

$showLevel = function($node) use ($arParams, &$showLevel) {
	if ($node['DEPTH_LEVEL'] > $arParams['MAX_LEVEL']) {
		return;
	}
	
	foreach($node['CHILDREN'] as $item) {
		?><li class="top-m__item"><a href="<?=$item['LINK']?>" rel="nofollow noopener" class="top-m__link"><?=$item['TEXT']?></a></li><?
		$showLevel($item);
	}
};

?><ul class="top-m">
	<?$showLevel(Util::menuToTree($arResult))?>
</ul>