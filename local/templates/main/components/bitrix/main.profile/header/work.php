<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<section class="your-work">
    <div class="container">
        <p class="your-work__maintext">
            <b>Приступите к верификации.</b> Скачайте один из документов в разделе, нажав на кнопку «Получить пакет». Один пакет весит около
            <b>20&nbsp;МБ.</b><br>

            Скачанный пакет отобразится в таблице и ему будет присвоен статус «В работе». Обратите внимание, что единовременно у вас на проверке может находиться только один пакет.  <br>
            <b>Проверьте документ,</b> следуя
            <a href="/includes/manual.pdf" target="_blank">инструкции</a>. Мы просим вас очень внимательно вычитывать текст. Проверенный текст должен на 100% соответствовать оригиналу. На проверку вам отводится
            <b>2 дня (48 часов).</b>
            <br>Вычитанный вами пакет в течение 10 (десяти) рабочих дней будет проверен администратором, который удостоверится, что вы не допустили большого количества ошибок и правильно сохранили пакет. За правильно распознанный пакет участник получает 5 баллов. Если пакет отклонен, у участника вычитают 10 баллов.<br>
            <b>Загрузите пакет на сайт.</b> Название проверенного пакета должно полностью повторять изначальное имя пакета. Пакет должен быть заархивирован в формате .zip.<br>
            Названия пакетов афиш: FRA_0001_1925_ или FRA_0001_1925-1936.zip и далее по порядку.<br>
            Названия пакетов программ: FR_0001_1925 или FR_0001_1925-1936.zip и далее по порядку.<br>
            Чтобы скачать следующий пакет документов, завершите проверку предыдущего и загрузите его на сайт, нажав на кнопку «Отправить&nbsp;пакет».<br>
            Теперь вы можете взять новый пакет на проверку.<br>
            Ответы на самые популярные вопросы размещены в
            <a href="/faq/">специальном разделе FAQ</a>.<br>
            <p>Ваш серийный номер ABBYY FineReader: <?=$arUser['UF_TRIAL']?></p>
        </p>
    </div>
</section>
<div class="get-packet <?=( empty($arUser['HISTORY']) ) ? 'get-packet_empty' : ''?>">
    <div class="container get-packet__container"><?
        if($arUser['FREE_PACKET']) {
            ?><p class="get-packet__text">Вы можете взять пакет на проверку.</p>
            <a href="javascript:;" class="get-packet__btn btn btn_header btn_how-begin js-gp-activate no-reload">Получить пакет</a><?
        }
        elseif( $arUser['PACKET_IN_WORK'] ){
            ?><p class="text text_left">Чтобы скачать следующий пакет, завершите проверку предыдущего<br>и&nbsp;загрузите его на сайт, нажав кнопку "Отправить пакет"</p><?
        }
        else {
            ?><p class="text text_error">К сожалению, свободных пакетов не найдено! Попробуйте зайти позже.</p><?
        }
        if( $arUser['PACKET_IN_WORK'] ){
            ?><a href="javascript:;" class="get-packet__btn btn btn_header btn_how-begin no-reload js-upload-packet" data-packet="<?=$arUser['PACKET_IN_WORK']?>">
                Отправить пакет
            </a><?
        }
    ?></div>
</div><?

if( !empty($arUser['HISTORY']) ){
    ?><div class="status js-status">
        <div class="container">
            <div class="status-line status-line_head">
                <div class="status-col1"></div>
                <div class="status-col2">Номер пакета</div>
                <div class="status-col4">Статус</div>
            </div><?
            foreach($arUser['HISTORY'] as $arHist){
                ?><div class="status-line">
                    <div class="status-col1">
                        <svg class="icon__clocks2" width="24px" height="24px"><?
                            switch($arHist['UF_STATUS']){
                                case 'В работе':
                                    $iconId = 'clocks2';
                                    break;
                                case 'На проверке':
                                    $iconId = 'tocheck2';
                                    break;
                                case 'Принят':
                                    $iconId = 'adopted';
                                    break;
                                case 'Отклонен':
                                    $iconId = 'cancel';
                                    break;
                                case 'Просрочен':
                                    $iconId = 'timeout';
                                    break;
                            }
                            ?><use xlink:href="<?= SITE_TEMPLATE_PATH ?>/images/svg-symbols6mxl96swcdi.svg#<?=$iconId?>"></use><?
                        ?></svg>
                    </div>
                    <div class="status-col2">
                        <span><?=$arHist['NAME']?></span>
                    </div>
                    <div class="status-col3">
                        <span><?=$arHist['UF_STATUS']?></span>
                    </div>
                    <div class="status-col3"><?
                        if( $arHist['UF_STATUS'] == 'В работе' ){
                            ?><a href="<?=$arHist['PACKET_FILE']?>">Скачать пакет</a><?
                        }
                    ?></div>
                </div><?
            }
        ?></div>
    </div><?
}

