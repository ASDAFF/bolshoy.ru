<?
use \Site\Main\User;
use \Site\Main\Util;
use \Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Открой историю Большого");
$APPLICATION->SetTitle("1С-Битрикс: Управление сайтом");
Asset::getInstance()->addString('<script src="//api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU"></script>');

$usersCount = User::GetCount();
?>
	<section class="fon-slider">
		<div class="container fon-slider__container">
			<div class="cont-flex">
				<div class="count-us flai">
					<div class="count-us__wrap">
						<svg class="world-pic-top" width="65.82px" height="65.82px">
							<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbols55o1e8z1tt9.svg#world"></use>
						</svg>

						<div class="count-us__right"><span class="count-us__text">Нас</span><span class="count-us__num"><?=User::getCount()?> </span>
						</div>
					</div>
				</div>
				</p>
			</div>
			<?$APPLICATION->IncludeFile('/includes/slider_header.php', array(), array('MODE' => 'html', 'NAME' => 'Изменить заголовок слайдера'))?>
			<?$APPLICATION->IncludeFile('/includes/slider_text.php', array(), array('MODE' => 'html', 'NAME' => 'Изменить текст слайдера'))?>
			
			<div class="fon-slider__share-row"><a href="/ajax/form/getRegForm/" class="js-fansibox btn btn-transp">Присоединиться</a>
				<div class="fon-slider__share-frends">
					<p class="fon-slider__share-text">РАССКАЗАТЬ ДРУЗЬЯМ</p>
					<div class="fon-slider__socials-wrap">
						<div data-services="facebook,vkontakte,odnoklassniki,twitter,linkedin,google" data-options="big,square,line,horizontal,nocounter,theme=04" data-background="transparent" class="pluso pluso-pc"></div>
						<!-- большие экраны-->
						<div data-background="transparent" data-options="medium,square,line,horizontal,nocounter,theme=04" data-services="facebook,vkontakte,odnoklassniki,twitter,linkedin,google" class="pluso pluso-mob"></div>
					</div>
				</div>
			</div>
			<div class="down-center">
				<a href="#video" class="js-down-section">
					<svg class="arr-down__pic" width="54.45px" height="33.59px">
						<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#arr-down"></use>
					</svg>
				</a>
			</div>
		</div>
	</section>
	<!--Этот блок показываектся только на мониторар меньше 1000 - то есть мобилки планшеты				-->
	<section class="coutn-users-mobile">
		<div class="container coutn-users-mobile__wrap">
			<svg class="world-pic" width="65.82px" height="65.82px">
				<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#world"></use>
			</svg>

			<div class="cout-mob__wrap"><span class="cout-mobus">нас</span><span class="cout-mobcount flai"><?=number_format($usersCount, 0, '', ' ')?></span>
			</div>
		</div>
	</section>
	<section id="video" class="video-sec">
		<div class="container video-sec__container">
			<div class="video-sec__wrap">
				<div class="video-sec__tube">
					<?$APPLICATION->IncludeFile('/includes/video_main.php', array(), array('MODE' => 'html', 'NAME' => 'Изменить ссылку на видео'))?>
				</div>
				<div class="video-sec__text-right flai">
					<?$APPLICATION->IncludeFile('/includes/video_text.php', array(), array('MODE' => 'html', 'NAME' => 'Изменить текст видео'))?>
				</div>
			</div>
		</div>
	</section>
	<!-- .map - только на больших экранах 1000px+-->

	<?$APPLICATION->IncludeComponent('site:users.map', '', array())?>

	<?
	$arRatingFilter = array('ACTIVE' => 'Y');
	$APPLICATION->IncludeComponent('site:users.list', 'rating', array(
		'FIELDS' => array(
			'NAME',
			'LAST_NAME',
			'PERSONAL_COUNTRY',
			'PERSONAL_CITY',
			'PERSONAL_PHOTO'
		),
		'UFIELDS' => array('UF_PROGRAM'),
		'SHOW_PAGER' => 'Y',
		'PAGE_ELEMENT_COUNT' => 5,
		'SORT_BY' => array('UF_PROGRAM' => 'desc', 'UF_RATING' => 'desc', "ID" => 'asc'),
		"SORT_ORDER" => "DESC",
		"FILTER_NAME" => "arRatingFilter"
	)); ?>

	<section class="community">
		<div class="container">
			<?$APPLICATION->IncludeFile('/includes/community_text.php', array(), array('MODE' => 'html', 'NAME' => 'Изменить текст Вступайте в наше сообщество'))?>
			<div class="community__wrap">
				<div class="community__item">
					<script type="text/javascript" src="//vk.com/js/api/openapi.js?129"></script>
					<!-- VK Widget -->
					<div id="vk_groups"></div>
					<script type="text/javascript">
						VK.Widgets.Group("vk_groups", {mode: 3, width: "auto", height: "400", color1: 'FFFFFF', color2: '000000', color3: '5E81A8'}, 128786609);
					</script>
				</div>
				<div class="community__item">
					<div id="fb-root"></div>
					<script>
						(function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) return;
							js = d.createElement(s); js.id = id;
							js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.7";
							fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));
					</script>
					<div data-href="https://www.facebook.com/openbolshoi/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" class="fb-page">
						<blockquote cite="https://www.facebook.com/openbolshoi/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/openbolshoi/">Открой историю Большого</a>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?
	$APPLICATION->IncludeComponent(
		"site:items.list.short",
		"partners",
		array(
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "N",
			"CACHE_TIME" => "86400",
			"CACHE_TYPE" => "A",
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"DISPLAY_TOP_PAGER" => "N",
			"FIELD_CODE" => array("PREVIEW_PICTURE", "CODE"),
			"FILTER_NAME" => "",
			"IBLOCK_ID" => 1,
			"IBLOCK_TYPE" => "Content",
			"MESSAGE_404" => "",
			"NEWS_COUNT" => "20",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "86400",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => ".default",
			"PAGER_TITLE" => "Новости",
			"PREVIEW_TRUNCATE_LEN" => "",
			"PROPERTY_CODE" => array("PARTNER_LINK", ""),
			"SET_BROWSER_TITLE" => "Y",
			"SET_STATUS_404" => "N",
			"SET_TITLE" => "Y",
			"SHOW_404" => "N",
			"SORT_BY1" => "SORT",
			"SORT_BY2" => "ID",
			"SORT_ORDER1" => "ASC",
			"SORT_ORDER2" => "ASC"
		)
	);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>