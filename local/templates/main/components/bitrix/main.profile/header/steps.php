<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<section class="how-begin">
    <div class="how-begin__step js-how-begin__step <?= ($arUser['UF_DOWNLOAD_MANUAL']) ? 'how-begin__step_noactive' : '' ?>">
        <div class="container container_how-begin">
            <div class="how-begin__num-step">1</div>
            <p class="how-begin__texts">Перед началом проверки внимательно 
                <b>ознакомьтесь с инструкцией.</b>
            </p>
            <a href="<?= $arParams["MANUAL_LINK"] ?>" target="_blank" class="btn btn_header btn_how-begin js-dm-activate">скачать инструкцию</a>
        </div>
    </div>
    <div class="how-begin__step js-how-begin__step <?= ($arUser['UF_INSTALL_FR'] || !$arUser['UF_DOWNLOAD_MANUAL']) ? 'how-begin__step_noactive' : '' ?>">
        <div class="container container_how-begin">
            <div class="how-begin__num-step">2</div>
            <p class="how-begin__texts">Для работы вам понадобится стационарный компьютер на ОС Windows. Если у вас еще не

                установлена программа <b>ABBYY FineReader 12 Professional Edition</b>, скачайте и установите ее

                на свой компьютер. Для корректной проверки документов мы рекомендуем использовать

                именно 12-ую версию программы.
            </p>
            <a href="<?= $arParams["FR_LINK"] ?>" class="btn btn_header btn_how-begin js-ifr-activate" target="_blank">Установить
                <span>ABBYY FineReader</span></a>
        </div>
    </div>
    <div class="how-begin__step js-how-begin__step <?= ($arUser['UF_GET_TRIAL'] || !$arUser['UF_DOWNLOAD_MANUAL'] || !$arUser['UF_INSTALL_FR']) ? 'how-begin__step_noactive' : '' ?>">
        <div class="container container_how-begin">
            <div class="how-begin__num-step">3</div>
            <p class="how-begin__texts">
                <b>Получите серийный номер,</b> введите его в окне программы для активации.
            </p>
            <a href="javascript:;" class="btn btn_header btn_how-begin js-gt-activate">Получить серийный номер</a>
        </div>
    </div>
    <div class="how-begin__step js-how-begin__step <?= (!$arUser['UF_DOWNLOAD_MANUAL'] || !$arUser['UF_INSTALL_FR'] || !$arUser['UF_GET_TRIAL']) ? 'how-begin__step_noactive' : '' ?>">
        <div class="container container_how-begin">
            <div class="how-begin__num-step how-begin__top">4</div>
            <div class="how-begin__texts">
                <p class="how-begin__texts_minmarg">
                    <b>Приступите к верификации.</b> Скачайте один из документов в разделе, нажав на кнопку

                    «Получить пакет». Один пакет весит <b>около 20&nbsp;МБ.</b>
                </p>
                <p class="how-begin__texts_minmarg">Скачанный пакет отобразится в таблице и ему будет присвоен статус<br>«В работе». Обратите
                    внимание, что единовременно у вас на проверке может находиться только один пакет. На проверку вам
                    отводится <b>2 дня (48 часов).</b>
                </p>
                <? if (!$arUser['FREE_PACKET']) {
                    ?>
                    <br>
                    <p class="btn_header text_error">К сожалению, свободных пакетов не найдено!<br/> Попробуйте зайти позже.</p>
                <? } ?>
            </div>
            <? if ($arUser['FREE_PACKET']) {
                ?><a href="javascript:;" class="btn btn_header btn_how-begin how-begin__top js-gp-activate">Получить пакет</a><?
            }
        ?></div>
    </div>

</section>

<input type="hidden" name="UF_DOWNLOAD_MANUAL" class="js-dm" value="<?= $arUser['UF_DOWNLOAD_MANUAL'] ?>"/>
<input type="hidden" name="UF_INSTALL_FR" class="js-ifr" value="<?= $arUser['UF_INSTALL_FR'] ?>"/>
<input type="hidden" name="UF_GET_TRIAL" class="js-gt" value="<?= $arUser['UF_GET_TRIAL'] ?>"/>
<input type="hidden" name="UF_GET_PACK" class="js-gp" value="<?= $arUser['UF_GET_PACK'] ?>"/>
