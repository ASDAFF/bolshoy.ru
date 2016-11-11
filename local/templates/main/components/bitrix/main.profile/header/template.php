<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<form class="js-profile-form" method="post" action="<?= $arResult['FORM_TARGET'] ?>?" enctype="multipart/form-data" role="profile">
    <?
    // Профиль пользователя
    require(realpath(dirname(__FILE__)) . '/profile.php');
    // Выполненные действия
    if($arUser['UF_DOWNLOAD_MANUAL'] && $arUser['UF_INSTALL_FR'] && $arUser['UF_GET_TRIAL'] && $arUser['UF_GET_PACK']) { // пользователь уже первый раз прошел 4 шага
        require(realpath(dirname(__FILE__)) . '/work.php');
    }
    else {
        require(realpath(dirname(__FILE__)) . '/steps.php');
    }
    ?>
</form>
