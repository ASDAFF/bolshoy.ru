<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/*vars*/

$pageNumber = $arResult['NavPageNomer']; // номер страницы
$pageSize = $arResult['NavPageSize']; // размер страницы
$elementsCountTotal = $arResult['NavRecordCount']; // всего элементов
$fPage = $arResult['nStartPage']; // номер первой страницы
$ePage = $arResult['nEndPage']; // номер последней страницы

$fPageShow = $arResult['NavFirstRecordShow']; // первая показанная страница
$ePageShow = $arResult['NavLastRecordShow']; // последняя показанная страница

$linkPrev = $arResult['sUrlPath'] . '?' . $strNavQueryString . 'PAGEN_' . $arResult['NavNum'] . '=' . ($arResult['NavPageNomer'] - 1); // ссылка на предыдущий пункт меню
$linkNext = $arResult['sUrlPath'] . '?' . $strNavQueryString . 'PAGEN_' . $arResult['NavNum'] . '=' . ($arResult['NavPageNomer'] + 1); // ссылка на следующий пункт меню

?>

<div class="paginate-raiting">
    <a href="<?=$linkPrev?>" class="paginate-raiting__link <?= ($pageNumber == $fPage) ? 'paginate-raiting__link-disabled is-disabled' : '' ?>">
        <svg class="paginate-raiting__arrow" width="52.5px" height="6.36px">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/images/svg-symbols6mxl96swcdi.svg#raiting-arrow"></use>
        </svg>
        <span><?= ($fPageShow - $pageSize) ?>-<?= ($fPageShow - 1) ?></span>
    </a>

    <a href="<?=$linkNext?>" class="paginate-raiting__link <?= ($pageNumber == $ePage) ? 'paginate-raiting__link-disabled is-disabled' : '' ?>">
        <span>
            <?
                $navNextFirstRecordShow = ($ePageShow + 1);
                $navNextLastRecordShow = ($ePageShow + $pageSize);
                if($pageNumber == ($ePage - 1)) { // для предпоследней страницы нужно отдельно посчитать сколько элементов нужно для последней
                    $pageEndRecordsCount = $elementsCountTotal - (($ePage - 1) * $pageSize);
                    $navNextLastRecordShow = $navNextFirstRecordShow + $pageEndRecordsCount - 1;
                }
            ?>
            <?= ($navNextFirstRecordShow == $navNextLastRecordShow) ? $navNextFirstRecordShow : $navNextFirstRecordShow . "-" . $navNextLastRecordShow ?>
        </span>
        <svg class="paginate-raiting__arrow paginate-raiting__arrow-right" width="52.5px" height="6.36px">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/images/svg-symbols6mxl96swcdi.svg#raiting-arrow"></use>
        </svg>
    </a>
</div>