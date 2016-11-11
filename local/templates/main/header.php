<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

if (defined('\Site\Main\IS_AJAX') && \Site\Main\IS_AJAX) {
	return;
}

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;
use \Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.3.1.0.min.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery-ui.min.js');
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/selectize.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/fancybox/jquery.fancybox.pack.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vegas.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/site.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/cropper.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/template.js");

Asset::getInstance()->addString('<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700&subset=cyrillic-ext" rel="stylesheet">');
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/vegas.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/fancybox/jquery.fancybox.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/cropper.min.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/jquery-ui.min.css");

CJSCore::Init(array("fx"));
$serverName = Application::getInstance()->getContext()->getServer()->getServerName();
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
	<head>
		<title><?$APPLICATION->ShowTitle()?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta property="og:title" content="Открой историю Большого" />
		<meta property="og:description" content="Хотите открыть историю главного театра страны и первыми увидеть редчайшие программы и афиши? Присоединяйтесь к проекту!"/><?
		if( strpos($serverName, 'p-w-d') === false ){
			?><meta property="og:image" content="http://<?=$serverName . SITE_TEMPLATE_PATH?>/images/bolshoi-history-refresh.png" /><?
		}
		else{
			?><meta property="og:image" content="<?=$serverName . SITE_TEMPLATE_PATH?>/images/bolshoi-history.png" /><?
		}

		?><meta property="og:url" content="http://<?=$serverName?>" />
		<?/*<meta name="viewport" content="width=1024, maximum-scale=1"/>*/?>


		<?$APPLICATION->ShowHead()?>
		
		<?/*<script rel="bx-no-check">site.utils.apply(site.app.locale, <?=\Site\Main\Locale::getInstance()->toJSON()?>);</script>*/?>
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Selectivizr IE8 support of CSS3-selectors -->
		<!--[if lt IE 9]>
			<link data-skip-moving="true" rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/ie.css"/>
			<script data-skip-moving="true" src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script data-skip-moving="true" src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<script data-skip-moving="true" src="<?=SITE_TEMPLATE_PATH?>/js/selectivizr-min.js"></script>
		<![endif]-->
	</head>

	<body role="document" class="<?=$APPLICATION->ShowProperty('bodyClass');?>"><?
		if( !preg_match('/p-w-d/', Application::getInstance()->getContext()->getServer()->getHttpHost()) ){
			?>
				<!-- Google Tag Manager-->
				<noscript>
					<iframe src="//www.googletagmanager.com/ns.html?id=GTM-WQBZMV" height="0" width="0" style="display:none;visibility:hidden"></iframe>
				</noscript>
				<script>
					(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
						new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
						j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
						'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
					})(window,document,'script','dataLayer','GTM-WQBZMV');
				</script>
				<!-- End Google Tag Manager-->
			<?
		}
		?><?$APPLICATION->ShowPanel()?>
		<section class="page__wrapper <?=( $USER->IsAdmin() ) ? 'page__wrapper_authorized' : ''?>">
			<header class="header">
				<div class="container header__flex-contain">
					<div class="header__left-logos">
						<a href="http://www.bolshoi.ru/" rel="nofollow noopener" target="_blank" class="logo__link">
							<img width="89" height="89" src="<?=SITE_TEMPLATE_PATH?>/images/general/Bolshoi_logo.png" alt="Большой театр" class="logo__img logo__img_main">
						</a>
						<a href="https://www.abbyy.com/ru-ru/" rel="nofollow noopener" target="_blank" class="logo__link">
							<img src="<?=SITE_TEMPLATE_PATH?>/images/general/ABBYY_Logo.png" alt="ABBY" class="logo__img">
						</a>
					</div><?
					$APPLICATION->IncludeComponent('bitrix:menu', '', array(
						"ROOT_MENU_TYPE" => "top",
						"MAX_LEVEL" => "1",
						"CHILD_MENU_TYPE" => "top",
						"USE_EXT" => "N",
						"DELAY" => "N",
						"ALLOW_MULTI_SELECT" => "Y",
						"MENU_CACHE_TYPE" => "N",
						"MENU_CACHE_TIME" => "86400",
						"MENU_CACHE_USE_GROUPS" => "N",
						"MENU_CACHE_GET_VARS" => ""
					));
					if( !$USER->IsAuthorized() ){
						?><a href="/ajax/form/getAuthForm/" class="btn btn_transp btn_header js-fansibox mob-hide">Вход/регистрация</a><?
					}
					else{
						?><!--<a href="<?/*=$APPLICATION->GetCurPageParam('logout=yes', array('logout'))*/?>" class="btn btn_transp btn_header mob-hide">Выход</a>-->
						<div  class="header__autoziz-buttons">
							<a class="btn btn_transp btn_header btn_kabinet mob-hide" href="/personal/">Личный кабинет</a>
							<a class="btn btn_transp btn_header btn_exit mob-hide" href="<?=$APPLICATION->GetCurPageParam('logout=yes', array('logout'))?>">Выход</a>
						</div><?
					}

					?><div class="header__right-socials">
						<a href="https://www.facebook.com/openbolshoi/" rel="nofollow noopener" target="_blank" class="header__soc-item header__soc-item_fb">
							<img src="<?=SITE_TEMPLATE_PATH?>/images/general/fb.svg" alt="facebook" class="header__soc-pic-fb">
						</a>
						<a href="https://vk.com/openbolshoi" rel="nofollow noopener" target="_blank" class="header__soc-item header__soc-item_vk">
							<img src="<?=SITE_TEMPLATE_PATH?>/images/general/vk.svg" alt="Vk" class="header__soc-pic-vk">
						</a>
					</div>
					<div class="show-menu"></div>
				</div>
			</header>

			
			<?

			if( !\Site\Main\IS_INDEX && !\Site\Main\IS_LK){
				?><div class="anti-header"></div>
				<section class="raiting-page">
						<div class="container">
						<h1 class="raiting-page__title"><?$APPLICATION->ShowTitle(false)?></h1>
				<?
			}
			?>