<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

if (defined('\Site\Main\IS_AJAX') && \Site\Main\IS_AJAX) {
	return;
}
				if( !\Site\Main\IS_INDEX && !\Site\Main\IS_LK){
					?></div><?
				}
				?>
			</section>
			<div class="page__buffer"></div>
		</section>
		<div class="page__footer">
			<footer class="footer">
				<div class="container footer__container">
					<div class="footer__texts">
						<p class="footer__orga">Оргкомитет:</p>
						<p class="footer__paragraf">
		
							<?=tplvar('footer_phone', true)?>
							<br><a href="mailto:<?=tplvar('footer_email')?>" class="footer__mail"><?=tplvar('footer_email', true)?> </a>
						</p>
						<p class="footer__copyr">© 2016 ABBYY. Все права защищены.</p>
					</div>
					<div class="header__right-socials header__right-socials_footer">
						<a href="https://www.facebook.com/openbolshoi/" rel="nofollow noopener" target="_blank" class="header__soc-item header__soc-item_fb">
							<img src="<?=SITE_TEMPLATE_PATH?>/images/general/fb.svg" alt="facebook" class="header__soc-pic-fb">
						</a>
						<a href="https://vk.com/openbolshoi" rel="nofollow noopener" target="_blank" class="header__soc-item header__soc-item_vk">
							<img src="<?=SITE_TEMPLATE_PATH?>/images/general/vk.svg" alt="Vk" class="header__soc-pic-vk">
						</a>
					</div>
				</div>
			</footer>
		</div>


<div class="none">
		<div id="login" class="window-wrap">
			<form action="#" class="forma">
				<input id="emlail" type="email" placeholder="Электронная почта *" class="forma__inpt">
				<input id="pass" type="text" placeholder="Пароль *" class="forma__inpt">
				<div class="soc-wide-login nopad">
					<p> <a href="#restore_password" class="js-fansibox forma__link"> Я забыл пароль</a>
					</p>
					<button class="forma__send btn">Войти</button>
					<p></p>
					<p class="soc-wide-login__text">Зарегистрироваться с помощью:</p>
					<div class="soc-wide-login__wrap">
						<a href="#" class="soc-wide-login__item">
							<svg class="soc-wide-login__vk" width="32.85px" height="19.06px">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#vk"></use>
							</svg>
						</a>
						<a href="#" class="soc-wide-login__item">
							<svg class="soc-wide-login__ok" width="43.02px" height="74.25px">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#ok"></use>
							</svg>
						</a>
						<a href="#" class="soc-wide-login__item">
							<svg class="soc-wide-login__mail" width="68.06px" height="65.3px">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#mail"></use>
							</svg>
						</a>
						<a href="#" class="soc-wide-login__item">
							<svg class="soc-wide-login__fb" width="17px" height="31px">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#fb"></use>
							</svg>
						</a>
					</div>
					<p></p>
					<p> <a href="#login" class="js-fansibox forma__link">Зарегистрироваться</a>
					</p>
				</div>
			</form>
		</div>
		<div id="restore_password" class="window-wrap">
			<form action="#" class="forma">
				<input id="emlail2" type="email" placeholder="Электронная почта *" class="forma__inpt">
				<input id="pass2" type="text" placeholder="Пароль *" class="forma__inpt">
				<div class="soc-wide-login nopad">
					<button class="forma__send btn">Отправить пароль</button>
					<button class="forma__send btn">Войти</button>
					<p></p>
					<p class="soc-wide-login__text">Зарегистрироваться с помощью:</p>
					<div class="soc-wide-login__wrap">
						<a href="#" class="soc-wide-login__item">
							<svg class="soc-wide-login__vk" width="32.85px" height="19.06px">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#vk"></use>
							</svg>
						</a>
						<a href="#" class="soc-wide-login__item">
							<svg class="soc-wide-login__ok" width="43.02px" height="74.25px">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#ok"></use>
							</svg>
						</a>
						<a href="#" class="soc-wide-login__item">
							<svg class="soc-wide-login__mail" width="68.06px" height="65.3px">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#mail"></use>
							</svg>
						</a>
						<a href="#" class="soc-wide-login__item">
							<svg class="soc-wide-login__fb" width="17px" height="31px">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/svg-symbolsgepw9rizfr.svg#fb"></use>
							</svg>
						</a>
					</div>
					<p></p>
					<p> <a href="#login" class="js-fansibox forma__link">Зарегистрироваться				</a>
					</p>
				</div>
			</form>
		</div>

		<?$APPLICATION->IncludeComponent('site:form.send', 'connection', array())?>

		<div id="thanks" class="window-wrap window-wrap__center">
			<h3 class="window-wrap__title">Спасибо за регистрацию!</h3>
			<p>Вы успешно зарегистрировались! Все подробности мы отправим отдельным письмом во время старта проекта.</p>
		</div>

		<div class="none">
			<div id="loading-indicator-template" class="hidden">
				<? $APPLICATION->IncludeFile('includes/loading-indicator.php', array(), array(
						'SHOW_BORDER' => false,
					)) ?>
			</div>

			<? $APPLICATION->IncludeComponent('site:no.old.browser', '', array(), false, array(
					'HIDE_ICONS' => 'Y',
				)) ?>
		</div>
</div>
		
	</body>
</html>