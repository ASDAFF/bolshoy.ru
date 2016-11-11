<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/*vars*/
$arUser = $arResult['arUser'];

// формирование города, страны
$city = $arUser['PERSONAL_CITY'];
$country = $arUser['PERSONAL_COUNTRY'];
if ($city && $country) {
    $country = ', ' . $country;
}

// email
$email = $arUser['EMAIL'];

?>
<? //$this->SetViewTarget("header_add");?>
<section class="verifa-sec profile-header js-profile-header">
    <div class="container">
        <div class="verifa-sec__wrap">
            <div class="verificator">


                <? if ($arUser['UF_USER_TYPE']) { ?>
                    <h3 class="verificator__name"><?= $arResult['USER_TYPE'] ?></h3>

                    <?
                    if ($arResult["strProfileError"]) {
                        ShowError($arResult["strProfileError"]);
                    }
                    elseif ($arResult['DATA_SAVED'] == 'Y') {
                        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
                    }

                    ?>
                    <div id="thanks" class="window-wrap window-wrap__center js-notification js-notification-hidden none">
                        <h3 class="window-wrap__title js-notification-title"></h3>
                        <p></p>
                    </div>
                    <?
                    
                }
                ?>

                <div class="verificator__form">
                    <?= $arResult['BX_SESSION_CHECK'] ?>
                    <input type="hidden" name="lang" value="<?= LANG ?>"/>
                    <input type="hidden" name="ID" value="<?= $arResult['ID'] ?>"/>
                    <div class="verificator__left">
                        <div class="verificator__user-avatar">
                            <?
                            $src = (strlen($arUser['PERSONAL_PHOTO']['src']) > 0) ? $arUser['PERSONAL_PHOTO']['src'] : SITE_TEMPLATE_PATH . "/images/avatar.png";
                            ?>
                            <a href="javascript:;" class="verificator__userpic-ava" style="background-image: url('<?= $src ?>')"></a>
                            <input accept="image/jpeg,image/png,image/gif" name="PERSONAL_PHOTO" id="upload" type="file" data-max-size="2048" class="outtaHere inputfile js-avatar">
                            <label for="upload" class="verificator__change-ava">
                                <span>Изменить фото</span>
                            </label>
                        </div>
                    </div>
                    <div class="verificator__right">
                        <input value="<?= $arUser['NAME'] ?>" name="NAME" placeholder="Ваше ФИО" disabled class="verificator__whence verificator__user-field verificator__user-name">
                        <input value="<?= sprintf('%s', $city) ?>" name="PERSONAL_CITY" placeholder="Ваш город" disabled class="verificator__whence verificator__user-field js-city-selector">
                        <div class="verificator__whence-select-wrap verificator__whence verificator__user-field">
                            <input class="verificator__whence verificator__user-field-inp js-country-label" disabled placeholder="Ваша страна" value="<?= $arResult['COUNTRIES'][$arUser['PERSONAL_COUNTRY_INDEX']] ?>">
                            <select name="PERSONAL_COUNTRY" class="js-country-select widget selectize none">
                                <option value="0" <?= !$arUser['PERSONAL_COUNTRY_INDEX'] ? "selected" : "" ?>>Не выбрано</option>
                                <? foreach ($arResult['COUNTRIES'] as $arCountryId => $arCountryName) { ?>
                                    <option <?= ($arUser['PERSONAL_COUNTRY_INDEX'] == $arCountryId) ? 'selected' : '' ?> value="<?= $arCountryId ?>"><?= $arCountryName ?></option>
                                <? } ?>
                            </select>
                        </div>
                        <input type="email" name="EMAIL" value="<?= $email ?>" placeholder="Email" disabled class="verificator__user-field verificator__name-user">


                        <div class="verificator__line verificator_line-border">
                            <span class="verificator__passtext">Пароль</span>
                            <input type="password" name="NEW_PASSWORD" placeholder="******" disabled class="verificator__password">
                        </div>
                        <div class="verificator__line verificator__line_save">
                            <button type="reset" class="verificator__btn js-reset">Отменить</button>
                            <button type="button" id="verificator-save" class="verificator__btn">Cохранить</button>
                            <div id="edit-profil" class="verificator__profil-edit-btn">Редактировать профиль</div>
                            <button type="submit" class="js-submit-form none"></button>
                        </div>
                    </div>
                    <input type="hidden" name="LOGIN" value="<?= $arResult['arUser']['LOGIN'] ?>"/>
                    <input type="hidden" name="NEW_PASSWORD_CONFIRM" value=""/>
                    <input type="hidden" name="save" value="y"/>
                </div>
            </div>
            <div class="verif-raiting">
                <div class="verif-raiting__place">
                    <span class="verif-raiting__big-num verif-raiting__big-num_lavr"><?= $arUser['POSITION'] ?></span>
                    <span class="verif-raiting__descript">Место <br> в рейтинге</span>
                </div>
                <div class="verif-raiting__billboard">
                    <span class="verif-raiting__big-num"><?= number_format($arUser['UF_PROGRAM'], 0, '', ' ') ?></span>
                    <span class="verif-raiting__descript">афиш и программ <br> проверено</span>
                </div>
                <div class="verif-raiting__points">
                    <span class="verif-raiting__big-num"><?= number_format($arUser['UF_RATING'], 0, '', ' ') ?></span>
                    <span class="verif-raiting__descript">Баллов</span>
                </div>
            </div>
        </div>
        <!-- .verifa-sec__wraps-->
        <h2 class="verifa-sec__title">Как начать работу</h2>
    </div>
</section>